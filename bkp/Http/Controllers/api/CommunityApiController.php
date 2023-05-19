<?php

namespace App\Http\Controllers\api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use Session;
use Config;
use Auth;
use App\Models\Tag;
use App\Models\User;
use App\Models\Community;
use App\Models\CommunityAnswer;
use App\Models\CommunityTagTagged;
use App\Models\UserCommunityVote;
use App\Models\UserCommunityViewed;
use Exception;
use App\Helpers\ResponseTrait;

class CommunityApiController extends BaseController {
    
    use ResponseTrait;

    public function getCommunityList(Request $request) {
        try {
            $recordPerPageConfig = Config::get('constant.record_per_page');
            $limit = $recordPerPageConfig['community'] ?? 8;

            $logged_user_id = $request->logged_user_id;
            $page = $request->page ?? 1;
            $start = $limit * ($page - 1);

            \Log::info('-1 getCommunityList $request->all()::' . print_r($request->all(), true));

            $totalCommunities = Community
                    ::getByStatus(true)
                    ->getExtendedSearch($request->search_text)
                    ->getByTags($request->tags ?? [])
                    ->count();
            $totalPages = ceil($totalCommunities / $limit);

            $communities = Community
                            ::getByStatus(true)
                            ->getExtendedSearch($request->search_text)
                            ->getByTags($request->tags ?? [])
                            ->withCount('UserCommunityVote')
                            ->withCount('UserCommunityViewed')
                            ->withCount('CommunityAnswer')
                            ->with('CommunityTagTagged.Tag')
                            ->with('user')
                            ->offset($start)->limit($limit)
                            ->orderBy('community.id', 'desc')
                            ->get()
                            ->map(function ($communityItem) use ($logged_user_id) {
                                $communityItem['is_new'] = false;
                                $communityItem['is_already_voted'] = false;
                                if (!empty($logged_user_id) && $logged_user_id == 'null') {
                                    $loggedUserCommunityViewedCount = UserCommunityViewed
                                            ::getByCommunityId($communityItem->id)
                                            ->getByUserId($logged_user_id)
                                            ->count();
                                    $communityItem['is_new'] = $loggedUserCommunityViewedCount == 0;
                                    if ($loggedUserCommunityViewedCount == 0) {
                                        $userCommunityViewed = new UserCommunityViewed();
                                        $userCommunityViewed->community_id = $communityItem->id;
                                        $userCommunityViewed->user_id = $logged_user_id;
                                        $userCommunityViewed->save();
                                    }

                                    $loggedUserCommunityVotesCount = UserCommunityVote
                                            ::getByCommunityId($communityItem->id)
                                            ->getByUserId($logged_user_id)
                                            ->count();
                                    $communityItem['is_already_voted'] = $loggedUserCommunityVotesCount > 0;
                                }

                                return $communityItem;
                            })->all();

            \Log::info('-2 getCommunityList $totalPages::' . print_r($totalPages, true));

            return $this->success(['communities' => $communities,'totalPages' => $totalPages], "Public List");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function index(Request $request, $community_slug, $logged_user_id = null) {

        $communityData = Community
                ::getBySlug($community_slug)
                ->getByStatus(true)
                ->with('user')
                ->first();

        if (empty($communityData)) {
            return response()->json(['message' => 'Community slug : ' . $community_slug . ' not found !'], HTTP_RESPONSE_BAD_REQUEST);
        }
        $userCommunityVotesCount = UserCommunityVote
                ::getByCommunityId($communityData->id)
                ->count();

        $loggedUserCommunityVotesCount = 0;
        if (!empty($logged_user_id) && $logged_user_id != 'null') {
            $loggedUserCommunityVotesCount = UserCommunityVote
                    ::getByCommunityId($communityData->id)
                    ->getByUserId($logged_user_id)
                    ->count();

            $loggedUserCommunityViewedCount = UserCommunityViewed
                    ::getByCommunityId($communityData->id)
                    ->getByUserId($logged_user_id)
                    ->count();
            if ($loggedUserCommunityViewedCount == 0) {
                $userCommunityViewed = new UserCommunityViewed();
                $userCommunityViewed->community_id = $communityData->id;
                $userCommunityViewed->user_id = $logged_user_id;
                $userCommunityViewed->save();
            }
        }

        $totalUserCommunityViewedCount = UserCommunityViewed
                ::getByCommunityId($communityData->id)
                ->count();

        $communityData->published_at_formatted = getCFFormattedDate($communityData->published_at);

        return response()->json([
                    'community' => $communityData,
                    'userCommunityVotesCount' => $userCommunityVotesCount,
                    'loggedUserCommunityVotesCount' => $loggedUserCommunityVotesCount,
                    'is_already_voted' => $userCommunityVotesCount,
                    'totalUserCommunityViewedCount' => $totalUserCommunityViewedCount,
                        ], HTTP_RESPONSE_OK);
    }

// public function index(Request $request, $community_id)

    public function getTags(Request $request, $community_id) {
        $community = Community
                ::getById($community_id)
                ->getByStatus(true)
                ->with('user')
                ->first();
        if (empty($community)) {
            return response()->json(['message' => 'Community id : ' . $community_id . ' not found !'], HTTP_RESPONSE_BAD_REQUEST);
        }

        $communityTags = CommunityTagTagged
                ::getByCommunityId($community_id)
                ->with('tag')
                ->orderBy('community_tag_tagged.id', 'desc')
                ->get();


        return response()->json([
                    'communityTags' => $communityTags,
                        ], HTTP_RESPONSE_OK);
    }

// public function getTags(Request $request, $community_id)

    public function getPopularQuestions(Request $request, $community_id) {
        $community = Community
                ::getById($community_id)
                ->getByStatus(true)
                ->with('user')
                ->first();
        if (empty($community)) {
            return response()->json(['message' => 'Community id : ' . $community_id . ' not found !'], HTTP_RESPONSE_BAD_REQUEST);
        }

        $communitydetailConfig = Config::get('constant.communitydetail');
        $number_popular_questions = $communitydetailConfig['number_popular_questions'];
        $communityPopularQuestions = Community
                ::getByNotId($community_id)
                ->withCount('UserCommunityVote')
                ->withCount('UserCommunityViewed')
                ->withCount('CommunityAnswer')
                ->with('CommunityTagTagged.Tag')
                ->offset(0)->limit($number_popular_questions)
                ->orderBy('user_community_vote_count', 'desc')
                ->get();

        return response()->json([
                    'communityPopularQuestions' => $communityPopularQuestions,
                        ], HTTP_RESPONSE_OK);
    }

    public function getPopularQuestionsHome(Request $request) {


        $communitydetailConfig = Config::get('constant.communitydetail');
        $number_popular_questions = $communitydetailConfig['number_popular_questions'];
        $communityPopularQuestions = Community
                ::withCount('UserCommunityVote')
                ->withCount('UserCommunityViewed')
                ->withCount('CommunityAnswer')
                ->with('CommunityTagTagged.Tag')
                ->offset(0)->limit($number_popular_questions)
                ->orderBy('user_community_vote_count', 'desc')
                ->get();

        return response()->json([
                    'communityPopularQuestions' => $communityPopularQuestions,
                        ], HTTP_RESPONSE_OK);
    }

    public function getNewQuestionsHome(Request $request) {


        $communitydetailConfig = Config::get('constant.communitydetail');
        $number_popular_questions = $communitydetailConfig['number_popular_questions'];
        $communityNewQuestions = Community
                ::withCount('UserCommunityVote')
                ->withCount('UserCommunityViewed')
                ->withCount('CommunityAnswer')
                ->with('CommunityTagTagged.Tag')
                ->offset(0)->limit($number_popular_questions)
                ->orderBy('id', 'desc')
                ->get();

        return response()->json([
                    'communityNewQuestions' => $communityNewQuestions,
                        ], HTTP_RESPONSE_OK);
    }

// public function getPopularQuestions(Request $request, $community_id)

    public function getAnswers(Request $request, $community_id) {

        $recordPerPageConfig = Config::get('constant.record_per_page');
        $limit = $recordPerPageConfig['community_answers_on_community'] ?? 4;
        $page = $request->page ?? 1;
        $start = $limit * ($page - 1);
        $community = Community
                ::getById($community_id)
                ->getByStatus(true)
                ->with('user')
                ->first();
        if (empty($community)) {
            return response()->json(['message' => 'Community id : ' . $community_id . ' not found !'], HTTP_RESPONSE_BAD_REQUEST);
        }

        $default_user_avatar_url = config('app.empty_default_user_avatar_url');
        $totalCommunityAnswers = CommunityAnswer
                ::getByCommunityId($community_id)
                ->count();
        $totalPages = ceil($totalCommunityAnswers / $limit);

        $communityAnswers = CommunityAnswer
                        ::getByCommunityId($community_id)
                        ->with('creator')
                        ->offset($start)->limit($limit)
                        ->orderBy('community_answer.id', 'asc')
                        ->get()
                        ->map(function ($communityAnswerItem) use ($default_user_avatar_url) {
                            $userProfilePhotoImageProps = ['image_url' => $default_user_avatar_url];
                            if (!empty($communityAnswerItem->creator->profile_photo)) {
                                // $userProfilePhotoImageProps = User::readUserImageProps($communityAnswerItem->creator['id'], $communityAnswerItem->creator['profile_photo'] ?? $default_user_avatar_url, true);
                                // if (empty($userProfilePhotoImageProps['image_url'])) {
                                //     $userProfilePhotoImageProps['image_url'] = $default_user_avatar_url;
                                // }
                                $userProfilePhotoImageProps['image_url'] = $communityAnswerItem->creator->profile_photo;
                            }
                            $communityAnswerItem['creatorUserProfilePhotoImageProps'] = $userProfilePhotoImageProps;

                            return $communityAnswerItem;
                        })->all();

        return response()->json([
                    'totalCommunityAnswers' => $totalCommunityAnswers,
                    'communityAnswers' => $communityAnswers,
                    'page' => $page,
                    'community_answers_on_community' => $limit,
                    'totalPages' => $totalPages,
                        ], HTTP_RESPONSE_OK);
    }

// public function getAnswers(Request $request, $community_id)

    public function addAnswer(Request $request) {
        $newCommunityAnswer = new CommunityAnswer();
        $newCommunityAnswer->id_parent = 0;
        $newCommunityAnswer->community_id = $request->community_id;
        $newCommunityAnswer->user_id = $request->user_id;
        $newCommunityAnswer->answer_text = crlf($request->answer_text);
        $newCommunityAnswer->status = true;
        $newCommunityAnswer->answer_point = 0;
        $newCommunityAnswer->save();

        return response()->json([
                    'message' => 'Your answer was created successfully',
                    'id' => $newCommunityAnswer->id,
                        ], HTTP_RESPONSE_OK
        );
    }

    public function addQuestion(Request $request) {
        $newCommunityQuestion = new Community();
        $newCommunityQuestion->user_id = $request->user_id;
        $newCommunityQuestion->title = crlf($request->title);
        $newCommunityQuestion->desc = crlf($request->desc);
        $newCommunityQuestion->status = true;
        $newCommunityQuestion->save();
        if (isset($request->tags)) {
            foreach ($request->tags as $key => $tag) {
                if (isset($tag['id'])) {
                    $CommunityTagTagged = new CommunityTagTagged();
                    $CommunityTagTagged->community_id = $newCommunityQuestion->id;
                    $CommunityTagTagged->tag_id = crlf($tag['id']);
                    $CommunityTagTagged->save();
                }
            }
        }



        return response()->json([
                    'message' => 'Your Question was created successfully',
                    'id' => $newCommunityQuestion->id,
                    'slug' => $newCommunityQuestion->slug,
                        ], HTTP_RESPONSE_OK
        );
    }

// public function addAnswer(Request $request)

    public function voteCommunity(Request $request) {
        if (!empty($request->user_id) and ! empty($request->community_id)) {
            $userCommunityVote = new UserCommunityVote();
            $userCommunityVote->user_id = $request->user_id;
            $userCommunityVote->community_id = $request->community_id;
            $userCommunityVote->save();

            return response()->json([
                        'message' => 'You voted successfully',
                        'id' => $userCommunityVote->id,
                            ], HTTP_RESPONSE_OK
            );
        }

        return response()->json([
                    'message' => 'Invalid vote parameters !',
                        ], HTTP_RESPONSE_BAD_REQUEST
        );
    }

// public function voteCommunity(Request $request)

/**
     *
     * @param Request $request
     */
    public function doDeleteCommunity(Request $request) {
        try {
            if (!isset($request->id) || $request->id == "" || !is_numeric($request->id)) {
                throw new Exception('Invalid request, please try again.');
            }
            $user_details   = User::getLoggedInUserDetails();
            if (empty($user_details)) {
                throw new Exception('User not found, please try again.');
            }
            $user_id = $user_details['id'];
            $id      = $request->id;

            $community_obj = Community::where('id', $id)->where('user_id', $user_id)->first();
            if (empty($community_obj)) {
                throw new Exception('Community not deleted, please try again.');
            }
            
            CommunityAnswer::where('community_id', $id)->delete();
            CommunityTagTagged::where('community_id', $id)->delete();

            if ($community_obj->delete()) {
                return $this->success(null,'Community deleted successfully');
            } else {
                throw new Exception('Community not deleted, please try again.');
            }
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }
}
