<?php

namespace App\Http\Controllers\api;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Mail;
use Config;
use App\Models\User;
use App\Models\Conversation;
use App\Models\GeneralSetting;
use App\Models\UserCategorySkill;
use App\Models\UserCategory;
use App\Models\UserPortfolio;
use App\Models\UserPortfolioImage;
use App\Models\ProjectImage;
use App\Models\UserPortfolioSkill;
use App\Models\UserLanguage;
use App\Models\Community;
use App\Models\CommunityAnswer;
use App\Models\CommunityTagTagged;
use App\Models\UserCommunityVote;
use App\Models\UserCommunityViewed;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PublicProfileController extends BaseController {

    //         window.api_path + 'public_profile/' + this.buyer_id,
    public function index(Request $request, $user_id) {
//        \Log::info(  varDump($user_id, ' -1 PublicProfileController $user_id::') );
        $user = User::find($user_id);

        if (empty($user)) {
            return response()->json(['message' => 'User id : ' . $user_id . ' not found !'], HTTP_RESPONSE_BAD_REQUEST);
        }
//        \Log::info(  varDump($user, ' -1 PublicProfileController $user::') );
        $empty_img_url = config('app.empty_img_url');

        if (!empty($user->profile_photo)) {
            $userPhotoImageProps = User::readUserImageProps($user->id, $user->profile_photo ?? $empty_img_url, true);
        } else {
            $userPhotoImageProps['image_url'] = $empty_img_url;
        }
//        \Log::info(  varDump($userPhotoImageProps, ' -1 PublicProfileController $userPhotoImageProps::') );
        return response()->json([
                    'user' => $user,
                    'userPhotoImageProps' => $userPhotoImageProps,
                        ], HTTP_RESPONSE_OK);
    }

// public function index(Request $request, $user_id)

    public function getUserProfile(Request $request, $user_name) {
     
        $User = User::where("login",$user_name)->first();
        //   dd($user);
        $default_user_avatar_url = config('app.empty_default_user_avatar_url');

        if (!empty($User->profile_photo)) {
            $loggedUserProfilePhotoImageProps = User::readUserImageProps($User->id, $User->profile_photo ?? $default_user_avatar_url, true);
            if (empty($loggedUserProfilePhotoImageProps)) {
                $loggedUserProfilePhotoImageProps['image_url'] = $default_user_avatar_url;
            }
        } else {
            $loggedUserProfilePhotoImageProps['image_url'] = $default_user_avatar_url;
        }


        if (!empty($User->cover_image)) {
            $UserCoverPhotoImageProps = User::readUserCoverProps($User->id, $User->cover_image ?? $default_user_avatar_url, true);
            if (empty($UserCoverPhotoImageProps)) {
                $UserCoverPhotoImageProps['cover_image_url'] = $default_user_avatar_url;
            }
        } else {
            $UserCoverPhotoImageProps['cover_image_url'] = $default_user_avatar_url;
        }

        $categories = DB::table('user_category')
                ->join('category', 'category.id', '=', 'user_category.category_id')
                ->select('user_category.*', 'category.title')
                ->where('user_category.user_id', $User->id)
                //->groupBy('user_category_skill.category_id')
                ->get();

        foreach ($categories as $k => $category) {
            //$categories[$k]['skill'] 
            $skill = DB::table('user_category_skill')
                    ->join('tag', 'tag.id', '=', 'user_category_skill.skill_id')
                    ->select('user_category_skill.*', 'tag.title', 'tag.title as text')
                    ->where('user_category_skill.user_id', $User->id)
                    ->where('user_category_skill.category_id', $category->category_id)
                    //->groupBy('user_category_skill.category_id')
                    ->get();
            $categories[$k]->skills = $skill;
        }


        $portfolios = DB::table('user_portfolio')
                ->select('user_portfolio.*')
                ->where('user_portfolio.user_id', $User->id)
                //->groupBy('user_category_skill.category_id')
                ->get();
        foreach ($portfolios as $k => $portfolio) {
            //$categories[$k]['skill'] 
            $skill = DB::table('user_portfolio_skill')
                    ->join('tag', 'tag.id', '=', 'user_portfolio_skill.skill_id')
                    ->select('user_portfolio_skill.*', 'tag.title', 'tag.title as text')
                    ->where('user_portfolio_skill.user_id', $User->id)
                    ->where('user_portfolio_skill.portfolio_id', $portfolio->id)
                    //->groupBy('user_category_skill.category_id')
                    ->get();
            $portfolios[$k]->skills = $skill;
            $UserPortfolioImages = UserPortfolioImage::where('portfolio_id', $portfolio->id)->get();
            foreach ($UserPortfolioImages as $i => $UserPortfolioImage) {
                //dd($UserPortfolioImage->filename);
                $UserPortfolioImages[$i] = UserPortfolio::readPortfolioImageProps($portfolio->id, $UserPortfolioImage->filename, true);
            }
            //dd($UserPortfolioImages);
            $portfolios[$k]->gallery_images = $UserPortfolioImages;
//            if (!empty($portfolio->gallery_image)) {
//                $portfolios[$k]->gallery_image = UserPortfolio::readPortfolioImageProps($User->id, $portfolio->gallery_image ?? $default_user_avatar_url, true);
//                if (empty($UserCoverPhotoImageProps)) {
//                    $portfolios[$k]->gallery_image = $default_user_avatar_url;
//                }
//            } else {
//                $portfolios[$k]->gallery_image = $default_user_avatar_url;
//            }
        }
        $logged_user_id = $User->id;
        $communities = Community
                        ::getByStatus(true)
                        // ->getExtendedSearch($request->search_text)
                        //->getByTags($request->tags ?? [])
                        ->withCount('UserCommunityVote')
                        ->withCount('UserCommunityViewed')
                        ->withCount('CommunityAnswer')
                        ->with('CommunityTagTagged.Tag')
                        ->with('user')
                        ->where('user_id', $User->id)
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

        //  dd($communities);
        $userlanguage = DB::table('user_language')
                ->select('user_language.*', 'user_language.language as text')
                ->where('user_language.user_id', $User->id)
                ->get();

        $page = (int) $request->page ?? 1;
        $recordPerPageConfig = Config::get('constant.record_per_page');
        $limit = 12;
        $start = $limit * ($page - 1);
        $query = Project
                ::getByStatus('A')
                ->with('category')
                ->with('creator')
                ->orderBy('project.created_at', 'desc');

        $query = $query->where('project.user_id', $User->id);

        $projects = $query->offset($start)->limit($limit)
                        ->get()
                        ->map(function ($projectItem) use ($logged_user_id) {
        $default_user_avatar_url = config('app.empty_default_user_avatar_url');
                    $projectItem->creator_full_name = $projectItem->creator->full_name ?? '';
                    $projectItem->created_at_formatted = getCFFormattedDateTime($projectItem->created_at);
                    $userProfilePhotoImageProps = ['image_url' => $default_user_avatar_url];
                    if (!empty($projectItem->creator->profile_photo)) {
                        $userProfilePhotoImageProps = User::readUserImageProps($projectItem->creator->id, $projectItem->creator->profile_photo ?? $default_user_avatar_url, true);
                        if (empty($userProfilePhotoImageProps['image_url'])) {
                            $userProfilePhotoImageProps['image_url'] = $default_user_avatar_url;
                        }
                    }

                    $projectItem['creatorUserProfilePhotoImageProps'] = $userProfilePhotoImageProps;

                            $projectImageMainItem = ProjectImage
                                    ::getByProjectId($projectItem->id)
                                    ->getByIsMain(true)
                                    ->first();
                            $empty_img_url = config('app.empty_img_url');
                            if (!empty($projectImageMainItem->project_id)) {
                                $projectImageItemImgProps = ProjectImage::readProjectImageProps($projectImageMainItem->project_id, $projectImageMainItem->filename ?? $empty_img_url, true);
                                $projectImageItemImgProps['info'] = $projectImageMainItem->info;
                            } else {
                                $projectImageItemImgProps['image_url'] = $empty_img_url;
                                $projectImageItemImgProps['info'] = "Default project image";
                            }
                            $projectItem->projectImagePropsArray = $projectImageItemImgProps;



                            if (isset($projectItem['category'][0]['category_id'])) {
                                $Category = Category::select('title')->where(['id' => $projectItem['category'][0]['category_id']])->first();
                                $projectItem->categoryname = $Category['title'];
                            }
                            return $projectItem;
                        })->toArray();

        return response()->json([
                    'User' => $User,
                    'communities' => $communities,
                    'categories' => $categories,
                    'projects' => $projects,
                    'portfolio' => $portfolios,
                    'userlanguage' => $userlanguage,
                    'UserCoverPhotoImageProps' => $UserCoverPhotoImageProps,
                    'UserProfilePhotoImageProps' => $loggedUserProfilePhotoImageProps,
                        ], HTTP_RESPONSE_OK);
    }

    public function getFilteredConversations(Request $request, $user_id) {
        $user = User::find($user_id);
//        \Log::info(  varDump($user, ' -1 getFilteredConversations $user::') );
        if (empty($user)) {
            return response()->json(['message' => 'User id : ' . $user_id . ' not found !'], HTTP_RESPONSE_BAD_REQUEST);
        }

        $empty_img_url = config('app.empty_img_url');

        $conversations = Conversation
//            ::getByStatus('A')
                ::getByCreatorOrCompanionId($user_id)
                ->with('creator')
                ->with('companion')
                ->with('latestConversationMessage')
                ->withCount('conversationMessages')
                ->orderBy('conversation.created_at', 'desc')
                ->get()
                ->map(function ($conversationItem) use ($user_id, $empty_img_url) {
            if ($user_id == $conversationItem->creator_id) {
                $conversationItem->conversation_user_full_name = $conversationItem->companion['full_name'];
                $companionPhotoImageProps = User::readUserImageProps($conversationItem->companion['id'], $conversationItem->companion['profile_photo'], true);
                $conversationItem->conversation_user_image_url = $companionPhotoImageProps['image_url'] ?? $empty_img_url;
            }
            if ($user_id == $conversationItem->companion_id) {
                $conversationItem->conversation_user_full_name = $conversationItem->creator['full_name'];
                $creatorPhotoImageProps = User::readUserImageProps($conversationItem->creator['id'], $conversationItem->creator['profile_photo'], true);
                $conversationItem->conversation_user_image_url = $creatorPhotoImageProps['image_url'] ?? $empty_img_url;
            }
            $conversationItem->latest_conversation_message_created_at = $conversationItem->latestConversationMessage->created_at ?? '';
            $conversationItem->latest_conversation_message_text = $conversationItem->latestConversationMessage->text ?? '';

            return $conversationItem;
        });

//        \Log::info(  varDump($conversations, ' -1 $conversations::') );
        return response()->json([
                    'conversations' => $conversations,
                        ], HTTP_RESPONSE_OK);
    }

// public function getFilteredConversations(Request $request, $user_id)
}
