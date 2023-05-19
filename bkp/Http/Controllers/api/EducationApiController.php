<?php

namespace App\Http\Controllers\api;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Session;
use Config;
use App\CustomFunction\CustomFunction;
use App\Models\Education;
use App\Models\EducationComment;
use App\Models\EducationTagTagged;
use Illuminate\Support\Facades\DB;
use App\Models\UserEducationDownload;
use Carbon\Carbon;
use Exception;
use App\Helpers\ResponseTrait;

class EducationApiController extends BaseController {

    use ResponseTrait;

    public function index(Request $request, $education_id) {
        $educationData = Education
                ::getBySlug($education_id)
                ->getByStatus(true)
                ->with('author')
                ->first();

        if (empty($educationData)) {
            return response()->json(['message' => 'Education id : ' . $education_id . ' not found !'], HTTP_RESPONSE_BAD_REQUEST);
        }
        $educationData->published_at_formatted = getCFFormattedDate($educationData->published_at);

        $empty_img_url = config('app.empty_img_url');
        $empty_book_url = "";

        $educationdetailConfig = Config::get('constant.educationdetail');
        $number_other_articles = $educationdetailConfig['number_other_articles'];
        $number_also_like_books = $educationdetailConfig['number_also_like_books'];

        $educationOtherArticles = Education
                ::getByDocumentType('B')  // 'B' => 'Blog'
                ->getByStatus(true)
                ->with('author')
                ->whereNotIn('id', [$educationData->id])
                ->orderBy('education.id', 'desc')
                ->offset(0)->limit($number_other_articles)
                ->get();

        $educationRelatedArticles = Education
                        ::getByDocumentType('B')  // 'B' => 'Blog'
                        ->getByStatus(true)
                        ->where(['education_category_id' => $educationData->education_category_id])
                        ->whereNotIn('id', [$educationData->id])
                        ->orderBy('education.id', 'desc')
                        ->offset(0)->limit(3)
                        ->get()->map(function ($educationRelatedItem) use($empty_img_url) {
                    $educationRelatedItemImageProps = ['image_url' => $empty_img_url];
                    if (!empty($educationRelatedItem->image)) {
                        // $educationRelatedItemImageProps = Education::readEducationImageProps($educationRelatedItem->id, $educationRelatedItem->image ?? $empty_img_url, true);
                        // if (empty($educationRelatedItemImageProps['image_url'])) {
                        //     $educationRelatedItemImageProps['image_url'] = $empty_img_url;
                        // }
                        $educationRelatedItemImageProps['image_url'] = $educationRelatedItem->image;
                    }
                    $educationRelatedItem['educationRelatedItemImageProps'] = $educationRelatedItemImageProps;
                    return $educationRelatedItem;
                })->all();

        $educationAlsoLikeBooks = Education
                        ::getByDocumentType('P')  // 'P' => 'Paul\'s book'
                        ->getByStatus(true)
                        ->orderBy('education.id', 'desc')
                        ->offset(0)->limit($number_also_like_books)
                        ->get()
                        ->map(function ($educationAlsoLikeBookItem) use($empty_img_url) {
                            $educationAlsoLikeBookItemImageProps = ['image_url' => $empty_img_url];
                            if (!empty($educationAlsoLikeBookItem->image)) {
                                // $educationAlsoLikeBookItemImageProps = Education::readEducationImageProps($educationAlsoLikeBookItem->id, $educationAlsoLikeBookItem->image ?? $empty_img_url, true);
                                // if (empty($educationAlsoLikeBookItemImageProps['image_url'])) {
                                //     $educationAlsoLikeBookItemImageProps['image_url'] = $empty_img_url;
                                // }
                                $educationAlsoLikeBookItemImageProps = ['image_url' => $educationAlsoLikeBookItem->image];
                            }
                            $educationAlsoLikeBookItem['educationBookItemImageProps'] = $educationAlsoLikeBookItemImageProps;
                            return $educationAlsoLikeBookItem;
                        })->map(function ($educationAlsoLikeBookItem) use($empty_book_url) {
                    $educationAlsoLikeBookItemBookProps = ['book_url' => $empty_book_url];
                    if (!empty($educationAlsoLikeBookItem->book)) {
                        $educationAlsoLikeBookItemBookProps = Education::readEducationBookProps($educationAlsoLikeBookItem->id, $educationAlsoLikeBookItem->book ?? $empty_book_url, true);
                        if (empty($educationAlsoLikeBookItemBookProps['book_url'])) {
                            $educationAlsoLikeBookItemBookProps['book_url'] = $empty_book_url;
                        }
                    }
                    $educationAlsoLikeBookItem['educationOtherArticleItemBookProps'] = $educationAlsoLikeBookItemBookProps;
                    return $educationAlsoLikeBookItem;
                })->all();

        if (!empty($educationData->image)) {
            // $educationImageProps = Education::readEducationImageProps($educationData->id, $educationData->image ?? $empty_img_url, true);
            $educationImageProps['image_url'] = $educationData->image;
        } else {
            $educationImageProps['image_url'] = $empty_img_url;
        }

        return response()->json([
                    'education' => $educationData,
                    'educationRelatedArticles' => $educationRelatedArticles,
                    'educationImageProps' => $educationImageProps,
                    'educationOtherArticles' => $educationOtherArticles,
                    'educationAlsoLikeBooks' => $educationAlsoLikeBooks,
                        ], HTTP_RESPONSE_OK);
    }

// public function index(Request $request, $education_id)

    public function getTags(Request $request, $education_id) {
        $education = Education
                ::getById($education_id)
                ->getByStatus(true)
                ->first();
        if (empty($education)) {
            return response()->json(['message' => 'Education id : ' . $education_id . ' not found !'], HTTP_RESPONSE_BAD_REQUEST);
        }

        $educationTags = EducationTagTagged
                ::getByEducationId($education_id)
                ->with('tag')
                ->orderBy('education_tag_tagged.id', 'desc')
                ->get();
        $tags = DB::table('tag')
                ->get();
        return response()->json([
                    'educationTags' => $educationTags,
                    'tags' => $tags,
                        ], HTTP_RESPONSE_OK);
    }

// public function getTags(Request $request, $education_id)

    public function listing(Request $request) {
        try {
            $empty_img_url = config('app.empty_img_url');
            $empty_book_url = "";

            $educationdetailConfig = Config::get('constant.educationdetail');
            $number_other_articles = $educationdetailConfig['number_other_articles'];
            $number_also_like_books = 3; //$educationdetailConfig['number_also_like_books'];

            $limit = 7;
            $page = $request->page ?? 1;
            if(!empty($request->search_text)){
                $page = 1;
            }
            $start = $limit * ($page - 1);
            $start_book = $number_also_like_books * ($page - 1);

            $tag = [];
            if (isset($request->tags) && !empty($request->tags)) {
                $tag = DB::table('tag')->where('tag.title', $request->tags)->first();
                $tag = [$tag->id];
            }

            $totalarticles = Education
                    ::getByDocumentType('B')
                    ->getExtendedSearch($request->search_text)
                    ->getByTags($tag ?? [])
                    ->orderBy('education.id', 'desc')
                    ->getByStatus(true)
                    ->count();
            $totalPagesArticles = ceil($totalarticles / $limit);
            
            $educationOtherArticles = Education
                            ::getByDocumentType('B')  // 'B' => 'Blog'
                            ->getByStatus(true)
                            ->getExtendedSearch($request->search_text)
                            ->getByTags($tag ?? [])
                            ->orderBy('education.id', 'desc')
                            ->offset($start)->limit($limit)
                            ->get()
                            ->map(function ($educationArticleItem) use($empty_img_url) {
                                $educationArticleItemImageProps = ['image_url' => $empty_img_url];
                                if (!empty($educationArticleItem->image)) {
                                    // $educationArticleItemImageProps = Education::readEducationImageProps($educationArticleItem->id, $educationArticleItem->image ?? $empty_img_url, true);
                                    // if (empty($educationArticleItemImageProps['image_url'])) {
                                    //     $educationArticleItemImageProps['image_url'] = $empty_img_url;
                                    // }
                                    $educationArticleItemImageProps = ['image_url' => $educationArticleItem->image];
                                }
                                $educationArticleItem['educationArticleItemImageProps'] = $educationArticleItemImageProps;
                                return $educationArticleItem;
                            })->all();

            $educationAlsoLikeBooks = Education
                            ::getByDocumentType('P')  // 'P' => 'Paul\'s book'
                            ->getByStatus(true)
                            ->orderBy('education.id', 'desc')
                            // ->offset(0)->limit($number_also_like_books)
                            ->offset($start_book)->limit($number_also_like_books)
                            ->get()
                            ->map(function ($educationAlsoLikeBookItem) use($empty_img_url) {
                                $educationAlsoLikeBookItemImageProps = ['image_url' => $empty_img_url];
                                if (!empty($educationAlsoLikeBookItem->image)) {
                                    // $educationAlsoLikeBookItemImageProps = Education::readEducationImageProps($educationAlsoLikeBookItem->id, $educationAlsoLikeBookItem->image ?? $empty_img_url, true);
                                    // if (empty($educationAlsoLikeBookItemImageProps['image_url'])) {
                                    //     $educationAlsoLikeBookItemImageProps['image_url'] = $empty_img_url;
                                    // }
                                    $educationAlsoLikeBookItemImageProps = ['image_url' => $educationAlsoLikeBookItem->image];
                                }
                                $educationAlsoLikeBookItem['educationOtherArticleItemImageProps'] = $educationAlsoLikeBookItemImageProps;
                                return $educationAlsoLikeBookItem;
                            })->map(function ($educationAlsoLikeBookItem) use($empty_book_url) {
                        $educationAlsoLikeBookItemBookProps = ['book_url' => $empty_book_url];
                        if (!empty($educationAlsoLikeBookItem->book)) {
                            // $educationAlsoLikeBookItemBookProps = Education::readEducationBookProps($educationAlsoLikeBookItem->id, $educationAlsoLikeBookItem->book ?? $empty_book_url, true);
                            // if (empty($educationAlsoLikeBookItemBookProps['book_url'])) {
                            //     $educationAlsoLikeBookItemBookProps['book_url'] = $empty_book_url;
                            // }
                            $educationAlsoLikeBookItemBookProps['book_url'] = $educationAlsoLikeBookItem->book;
                        }
                        $educationAlsoLikeBookItem['educationOtherArticleItemBookProps'] = $educationAlsoLikeBookItemBookProps;
                        return $educationAlsoLikeBookItem;
                    })->all();

//        if ( !empty($educationData->image)) {
//            $educationImageProps      = Education::readEducationImageProps($educationData->id, $educationData->image ?? $empty_img_url, true);
//        } else {
//            $educationImageProps['image_url'] = $empty_img_url;
//        }

            return $this->success([
//            'education' => $educationData,
//            'educationImageProps' => $educationImageProps,
                        'educationOtherArticles' => $educationOtherArticles,
                        'educationAlsoLikeBooks' => $educationAlsoLikeBooks,
                        'totalPages' => $totalPagesArticles,
                        'page' => $page,
                            ], "Public List");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function book_download(Request $request) {
        $eduData = Education::select('book')->where('id',$request->book_id)->first();
        $user_id = (int) $request->id;
        $downloaded_books = new UserEducationDownload();
        $downloaded_books->education_id = $request->book_id;
        $downloaded_books->user_id = $user_id;
        $downloaded_books->created_at = Carbon::now(config('app.timezone'));
        if($downloaded_books->save()){
            if(!empty($eduData->book))
                return response()->json(['status' => true, 'msg' => 'File downloaded successfully!', 'file' => $eduData->book]);
            else
                return response()->json(['status' => false, 'msg' => 'No file found!']);
                
        }
        return response()->json(['status' => false, 'msg' => 'Something went wrong while downloading file!']);
    }

    public function homelisting(Request $request) {


        $empty_img_url = config('app.empty_img_url');
        $empty_book_url = "";

        $educationdetailConfig = Config::get('constant.educationdetail');
        $number_other_articles = $educationdetailConfig['number_other_articles'];
        $number_also_like_books = 4; //$educationdetailConfig['number_also_like_books'];

        $limit = 7;
        $page = $request->page ?? 1;
        $start = $limit * ($page - 1);
        $start_book = $number_also_like_books * ($page - 1);
        //dd($request->tags[0]['text']);

        $educationAlsoLikeBooks = Education
                        ::getByDocumentType('P')  // 'P' => 'Paul\'s book'
                        ->getByStatus(true)
                        ->orderBy('education.id', 'desc')
                        // ->offset(0)->limit($number_also_like_books)
                        ->offset($start_book)->limit($number_also_like_books)
                        ->get()
                        ->map(function ($educationAlsoLikeBookItem) use($empty_img_url) {
                            $educationAlsoLikeBookItemImageProps = ['image_url' => $empty_img_url];
                            if (!empty($educationAlsoLikeBookItem->image)) {
                                // $educationAlsoLikeBookItemImageProps = Education::readEducationImageProps($educationAlsoLikeBookItem->id, $educationAlsoLikeBookItem->image ?? $empty_img_url, true);
                                // if (empty($educationAlsoLikeBookItemImageProps['image_url'])) {
                                //     $educationAlsoLikeBookItemImageProps['image_url'] = $empty_img_url;
                                // }
                                $educationAlsoLikeBookItemImageProps = ['image_url' => $educationAlsoLikeBookItem->image];
                            }
                            $educationAlsoLikeBookItem['educationOtherArticleItemImageProps'] = $educationAlsoLikeBookItemImageProps;
                            return $educationAlsoLikeBookItem;
                        })->map(function ($educationAlsoLikeBookItem) use($empty_book_url) {
                    $educationAlsoLikeBookItemBookProps = ['book_url' => $empty_book_url];
                    if (!empty($educationAlsoLikeBookItem->book)) {
                        // $educationAlsoLikeBookItemBookProps = Education::readEducationBookProps($educationAlsoLikeBookItem->id, $educationAlsoLikeBookItem->book ?? $empty_book_url, true);
                        // if (empty($educationAlsoLikeBookItemBookProps['book_url'])) {
                        //     $educationAlsoLikeBookItemBookProps['book_url'] = $empty_book_url;
                        // }
                        $educationAlsoLikeBookItemBookProps = ['book_url' => $educationAlsoLikeBookItem->book];
                    }
                    $educationAlsoLikeBookItem['educationOtherArticleItemBookProps'] = $educationAlsoLikeBookItemBookProps;
                    return $educationAlsoLikeBookItem;
                })->all();

        return response()->json([
//            'education' => $educationData,
//            'educationImageProps' => $educationImageProps,
                    'educationAlsoLikeBooks' => $educationAlsoLikeBooks,
                        ], HTTP_RESPONSE_OK);
    }

}
