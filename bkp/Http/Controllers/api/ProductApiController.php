<?php

namespace App\Http\Controllers\api;

use App\Models\ProjectImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use JWTAuth;
use Carbon\Carbon;
use Config;
use App\CustomFunction\CustomFunction;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Project;
use App\Models\UserProjectVote;
use App\Models\CMSItem;
use App\Models\{Category, SubCategory};
use App\Models\Platform;
use App\Models\ProjectComment;
use App\Models\ProjectProduct;
use App\Models\ProjectTagTagged;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Models\Product;
use App\Models\BrandProduct;
use App\Models\ProductCategory;
use App\Models\CompatibleProducts;
use App\Models\ProductAccessories;
use App\Models\ProductTags;
use App\Models\Product_documents;
use App\Models\Product_images;
use App\Models\ProductReviews;
use App\Models\ProductLikes;
use App\Helpers\ResponseTrait;
use App\Helpers\CommonTrait;
use Exception;

class ProductApiController extends BaseController {

    use ResponseTrait;
    use CommonTrait;

    public function doaddproductlist(Request $request) {
        try {
            if (!isset($request->user_id) || $request->user_id == "") {
                throw new Exception('User id is required');
            }
            if (!isset($request->name) || $request->name == "") {
                throw new Exception('Please enter the Product name');
            }
            if (!isset($request->sku) || $request->sku == "") {
                throw new Exception('Please enter the Product sku');
            }
            if (!isset($request->product_category) || $request->product_category == "") {
                throw new Exception('Please enter the Product category');
            }
            if (!isset($request->price) || $request->price == "") {
                throw new Exception('Please enter the Product price');
            }
            if (!$this->isCurrency($request->price)) {
                throw new Exception('Product price is not valid');
            }
            if (!isset($request->brand) || $request->brand == "") {
                throw new Exception('Please enter the Product brand');
            }
            if (!isset($request->desc) || $request->desc == "") {
                throw new Exception('Please enter the Product description');
            }
            if (!isset($request->short_desc) || $request->short_desc == "") {
                throw new Exception('Please enter the Product technical specifications');
            }
            
            if(!empty($request->website_link) && !filter_var($request->website_link, FILTER_VALIDATE_URL)) {
                throw new Exception('Please enter the valid  URL');
            }
            
            if(!empty($request->youtube_link) && !filter_var($request->youtube_link, FILTER_VALIDATE_URL)) {
                throw new Exception('Youtube link is not correct url');
            }
            
            if(!empty($request->youtube_link2) && !filter_var($request->youtube_link2, FILTER_VALIDATE_URL)) {
                throw new Exception('Youtube link 2 is not correct url');
            }
            
            $user_details = User::getLoggedInUserDetails();
            //check if user is allowed to mark product as featured
            if (isset($request->is_featured) && $request->is_featured == "true") {                
                $this->checkIfUserIsPermitted($user_details, 'FEATURED_PRODUCTS');
            }
            
            //check if user is allowed to create product
            $this->checkIfUserIsPermitted($user_details, 'PRODUCTS');
            
            $imageType = 0;
            $documentType = 0;
            $allowedimageTypes = array("image/jpeg", "image/gif", "image/png");
            $alloweddocumentTypes = array("application/pdf");
            //documents check
            if ($request->hasFile('documents')) {
                $files = $request->file('documents');
                foreach ($files as $k => $file) {
                    $extension = $file->clientExtension();
                    $mimeType = $file->getMimeType();
                    $filename = $file->getClientOriginalName();
                    if (!in_array($mimeType, $alloweddocumentTypes)) {
                        $documentType = 1;
                    }
                    $store_file[$k] = $mimeType;
                }
            }

            if ($documentType == 1) {
                throw new Exception('Document should be of type ' . implode(", ", $alloweddocumentTypes));
            }
            //Images check
            if ($request->hasFile('images')) {
                $files = $request->file('images');
                foreach ($files as $k => $file) {
                    $extension = $file->clientExtension();
                    $mimeType = $file->getMimeType();
                    $filename = $file->getClientOriginalName();
                    if (!in_array($mimeType, $allowedimageTypes)) {
                        $imageType = 1;
                    }
                    $store_file[$k] = $mimeType;
                }
            } else {
                throw new Exception('At least one image is required');
            }

            if (count($store_file) > 5) {
                throw new Exception('Product images cannot be more than 5');
            }

            if ($imageType == 1) {
                throw new Exception('Product images should be of type ' . implode(", ", $allowedimageTypes));
            }

            //unique Name
            $name = $request->name;
            // $productname = Product::where('name', $name)->get();
            // if(isset($productname[0])){
            // throw new Exception('Product name  should be unique');
            // }
            //unique sku
            $productsku = Product::where('sku', $request->sku)->get();
            if (isset($productsku[0])) {
                throw new Exception('Product sku should be unique');
            }

            //unique slug
            $array = array(0);
            $slug = Product::createProductSlug($name);
            $sug = $slug;
            //Infinite loop to check product slug
            foreach ($array as $key => &$val) {
                $array[++$key] = $key;
                $productslug = Product::where('slug', $slug)->get();
                if (isset($productslug[0])) {
                    $slug = $sug . '-' . random_int(1, 99);
                } else {
                    break;
                }
            }

            $sku = $request->sku;
            $category = $request->product_category;
            $product_sub_category = $request->product_sub_category;
            $price = $request->price;
            $brand_id = $request->brand;
            $desc = $request->desc;
            $short_desc = $request->short_desc;
            $website_link = $request->website_link;
            $youtube_link = $request->youtube_link;
            $youtube_link2 = $request->youtube_link2;
            if (isset($request->checked)) {
                $is_checked = 1;
            } else {
                $is_checked = 0;
            }
            $user_id = $request->user_id;
            $product = new Product();
            $product->name = $name;
            $product->user_id = $user_id;
            $product->slug = $slug;
            $product->sku = $sku;
            $product->product_category = $category;
            $product->product_sub_category = $product_sub_category;
            $product->price = $price;
            $product->brand_id = $brand_id;
            $product->desc = $desc;
            $product->short_desc = $short_desc;
            $product->website_link = $website_link;
            $product->youtube_link = $youtube_link;
            $product->youtube_link2 = $youtube_link2;
            $product->is_checked = $is_checked;
            $product->updated_at = date('Y-m-d H:i:s');
            $product->featured = isset($request->is_featured) && $request->is_featured == "true" ? 1 : 0;
            $product->is_approved = $this->checkIfUserIsPermitted($user_details, 'PRODUCTS_APPROVAL');
            $product->save();

            if ($product->id) {
                $productid = $product->id;
                // upload documents
                if ($request->hasFile('file_pdf')) {
                    $files = $request->file('file_pdf');
                    foreach ($files as $k => $file) {
                        $data = date('Y/m/d');
                        $hour = date('H');
                        $path = 'product/document/' . $data . '/' . $hour . '-' . $productid;
                        $uploaded_filename = imageuploads3($path, $file);

                        $productdoc = new Product_documents();
                        $productdoc->product_id = $productid;
                        $productdoc->document_name = $uploaded_filename;
                        $productdoc->caption = $request->file_pdf_caption[$k];
                        $productdoc->save();
                    }
                }

                if ($request->hasFile('images')) {
                    $files = $request->file('images');
                    $image_caption_arr = $request->image_caption;
                    $image_is_main_arr = $request->image_is_main;
                    foreach ($files as $k => $file) {
                        $data = date('Y/m/d');
                        $hour = date('H');
                        $path = 'product/images/' . $data . '/' . $hour . '-' . $productid;
                        $product_image_file_path = imageuploads3($path, $file);

                        $productimg = new Product_images();
                        $productimg->product_id = $productid;
                        $productimg->image_name = $product_image_file_path;
                        $productimg->image_type = isset($image_is_main_arr[$k]) ? $image_is_main_arr[$k] : 0;
                        $productimg->caption = isset($image_caption_arr[$k]) ? $image_caption_arr[$k] : "";
                        $productimg->save();
                    }
                }

                $request_compatible = json_decode($request->compatible_product, true);
                if ($request->compatible_product) {
                    foreach ($request_compatible as $k => $compatible_product) {
                        $compproduct = new CompatibleProducts();
                        $compproduct->product_id = $productid;
                        $compproduct->compatible_product_id = $compatible_product;
                        $compproduct->save();
                    }
                }

                $request_acc = json_decode($request->accessories, true);
                if ($request->accessories) {
                    foreach ($request_acc as $k => $accessorie_product) {
                        $accproduct = new ProductAccessories();
                        $accproduct->product_id = $productid;
                        $accproduct->accessory_product_id = $accessorie_product;
                        $accproduct->save();
                    }
                }
                if ($request->tags) {
                    $tags_products = json_decode($request->tags);
                    foreach ($tags_products as $k => $tags_product) {
                        $tagproduct = new ProductTags();
                        $tagproduct->product_id = $productid;
                        $tagproduct->tag_product_id = $tags_product;
                        $tagproduct->save();
                    }
                }
            }
            return $this->success(['slug' => $slug], 'Product details saved successfully');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    function isCurrency($number) {
        return preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $number);
    }

    public function getcompatibleproduct(Request $request) {
        try {
            if (!isset($request->search)) {
                throw new Exception('search parameter is required');
            }
            $search = $request->search;
            $compatibleproject = Product::select('id', 'name')->where('name', 'LIKE', '%' . $search . '%')->orderBy('name', 'asc')->get();
            $prod = array();
            if (!empty($compatibleproject[0])) {
                foreach ($compatibleproject as $product) {
                    $prod[$product['id']] = $product['name'];
                }
            }

            return $this->success(['compatibleproduct' => $prod], "Compatible Products");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }
    
    /**
     * IN USE
     * Common function to filter products
     * @param type $query
     * @param type $request
     * @return type
     */
    private function filterProducts($query, $request)
    {
        $data_type = $request->data_type ?? '';
        
        $query = $query->getByName($request->search_text);
        
        if ($data_type == 'featured') {
            $query = $query->where('featured', 1);
        }

        if ($data_type == 'newest') {
            $query = $query->whereRaw('created_at >= DATE_SUB(CURDATE(), INTERVAL 180 DAY)');
        }

        if ($request->min_budget !== null || $request->max_budget !== null) {
            $query = $query->whereBetween('price', [$request->min_budget, $request->max_budget]);
        }

        if (isset($request->category) && !empty($request->category)) {
            $query = $query->where('product.product_category', '=', $request->category);
        }

        if (isset($request->sub_category) && !empty($request->sub_category)) {
            $query = $query->where('product.product_sub_category', '=', $request->sub_category);
        }
        
        $tag = [];
        if (isset($request->tags) && count($request->tags) > 0) {
            $tag = DB::table('tag')->select(DB::raw("GROUP_CONCAT(id) AS tagIds"))
                    ->whereIn('tag.title', $request->tags)->first();

            if(!empty($tag) && $tag->tagIds) {                
                $query = $query->leftJoin('product_tags AS PT', 'product.id', '=', 'PT.product_id')
                    ->whereIn('PT.tag_product_id', explode(",", $tag->tagIds));
            }
        }
        
        return $query;
    }

    /**
     * IN USE
     * @param Request $request
     * @return type
     */
    public function getProductList(Request $request) {
        try {
            $page = (int) $request->page ?? 1;
            $data_type = $request->data_type ?? '';
            $limit = $request->limit ?? 5;
            $start = $limit * ($page - 1);
            $default_user_avatar_url = config('app.empty_default_user_avatar_url');
            $empty_img_url = config('app.empty_img_url');
            $user_details = User::getLoggedInUserDetails();
            $logged_user_id = $user_details['id'];
            $prod = [];
            
            $query_count = Product::query();            
            $query_count = $this->filterProducts($query_count, $request);
           
            $totalproducts = $query_count->count();
            $totalPages = ceil($totalproducts / $limit);
            
            
            $query = Product::query()
                    ->with(['ProductCategory:id,title', 'ProductSubCategory:id,title', 'reviews'])
                    ->with('creator:id,full_name,profile_photo,location,title,login');
            $query = $this->filterProducts($query, $request);
            
            $products = $query->orderBy('product.created_at', 'desc')->offset($start)->limit($limit)->get();
            if (!empty($products)) {
                $products = $products->toArray();
                foreach ($products as $product) {
                    $temp = [];
                    $temp['id'] = $product['id'];
                    $temp['name'] = $product['name'];
                    $temp['slug'] = $product['slug'];
                    $temp['sku'] = $product['sku'];
                    $temp['desc'] = $product['desc'];
                    $temp['link'] = $product['link'];
                    $temp['price'] = $product['price'];
                    $temp['manufacturer'] = $product['manufacturer'];
                    $temp['website_link'] = $product['website_link'];
                    $temp['youtube_link'] = $product['youtube_link'];
                    
                    $temp['creator'] = $product['creator'];
                    $temp['category'] = $product['product_category'];
                    $temp['sub_category'] = $product['product_sub_category'];
                    $temp['reviews_count'] = count($product['reviews']);
                    
                    //ProductReviews
                    $totalStars = 0;
                    $numberOfReviews = 0;
                    $average = 0;
                    if (isset($product['reviews'])) {
                        foreach ($product['reviews'] as $k => $productrev) {
                            $numberOfReviews++;
                            $totalStars += $productrev['ratings'];
                        }
                        if ($numberOfReviews != 0) {
                            $average = $totalStars / $numberOfReviews;
                        }
                    }

                    $temp['total_stars'] = $totalStars;
                    $temp['likes'] = 4;
                    $temp['overall_ratings'] = floor($average);
                    
                    //product_image
                    $productImage = Product_images::where('product_id', $product['id'])->where('image_type', 1)->first();
                    if (isset($productImage->id)) {
                        if ($productImage->image_name != '') {
                            $product_img = $productImage->image_name;
                        } else {
                            $product_img = $empty_img_url;
                        }                        
                    } else {
                        $product_img = $empty_img_url;
                    }
                    
                    $temp['product_image'] = $product_img;
                    
                    $prod[] = $temp;
                }
            }

            return $this->success(['page' => $page, 'totalPages' => $totalPages, 'products' => $prod], " Products");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function getproductaccessories(Request $request) {
        try {
            if (!isset($request->search)) {
                throw new Exception('search parameter is required');
            }
            $search = $request->search;
            $productaccessories = Product::select('id', 'name')->where('name', 'LIKE', '%' . $search . '%')->orderBy('name', 'asc')->get();
            $prod = array();
            if (!empty($productaccessories[0])) {
                foreach ($productaccessories as $product) {
                    $prod[$product['id']] = $product['name'];
                }
            }

            return $this->success(['productaccessories' => $prod,], " Products Acc");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    /**
     * IN USE
     * @param Request $request
     * @return type
     */
    public function getproductcategories(Request $request) {
        try {
            $productcategories = ProductCategory::select('id', 'title')->where('product_category_parent_id', '=', 0)->orderBy('title', 'asc')->get()->toarray();
            // $productcategories = Category::select('id', 'title')->where('status', '=', 1)->orderBy('title', 'asc')->get()->toarray();
            $prod = array();
            if (!empty($productcategories[0])) {
                foreach ($productcategories as $product) {
                    $prod[$product['id']] = $product['title'];
                }
            }

            return $this->success(['productcategories' => $prod,], " Products Categories");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function getproductsubcategories(Request $request, $id) {
        try {
            $productsubcategories = ProductCategory::select('id', 'title')->where('product_category_parent_id', $id)->orderBy('title', 'asc')->get();
            // $productsubcategories = SubCategory::select('id', 'name')->where('category_id', $id)->orderBy('name', 'asc')->get();
            $prod = array();
            if (!empty($productsubcategories[0])) {
                foreach ($productsubcategories as $product) {
                    $prod[$product['id']] = $product['title'];
                }
            }

            return $this->success(['productsubcategories' => $prod,], " Products Sub Categories");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    /* Mywork routes 25-Apr-22 */

    public function getproduct(Request $request, $slug) {
        try {
            $user_details = User::getLoggedInUserDetails();
            
            $productarray = Product::where('slug', $slug)
                    ->with('ProductCompatible.compProducts')
                    ->with('ProductCompatible.compBrand')
                    ->with('ProductCompatible.compBrand.brand')
                    ->with('ProductCompatible.image')
                    ->with('ProductAccessories.compProducts')
                    ->with('ProductAccessories.compBrand')
                    ->with('ProductAccessories.compBrand.brand')
                    ->with('ProductAccessories.image')
                    ->with('ProductTags.tagproduct')
                    ->with('reviews.user')
                    ->with('productProject.project')
                    ->with('productProject.project.user')
                    ->with('productProject.projeccategory.category')
                    ->with('Brand.brandimages')
                    ->with(['relatedCategory', 'relatedSubCategory', 'likescount', 'ProductCategories'])
                    ->with('creator:id,full_name,profile_photo,location,title,login')
                    ->get();
            $prod = array();
            $app_root_url = config('app.url');
            if (!empty($productarray[0])) {
                foreach ($productarray as $product) {
                    $prod['product_id'] = $product['id'];
                    $prod['name'] = $product['name'];
                    $prod['slug'] = $product['slug'];
                    $prod['sku'] = $product['sku'];
                    $prod['desc'] = $product['desc'];
                    $prod['short_desc'] = $product['short_desc'];
                    $prod['price'] = $product['price'];
                    $prod['website_link'] = $product['website_link'];
                    $prod['youtube_link'] = $product['youtube_link'] ?? null;
                    $prod['youtube_link2'] = $product['youtube_link2'] ?? null;
                    $prod['is_brand_member'] = $product['is_checked'] == 0 ? 0 : 1;
                    $prod['approved'] = $product['is_approved'] == 0 ? 0 : 1;
                    $prod['featured'] = $product['featured'] == 0 ? 0 : 1;
                    
                    $prod['creator'] = $product['creator'];                    
                    
                    $prod['liked'] = 0;
                    if(isset($user_details['id']) && $user_details['id'] > 0) {
                        $prod['liked'] = ProductLikes::where(['user_id' => $user_details['id'], 'product_id' => $product['id']])->get()->count();
                    }
                    
                    $id = $prod['product_id'];
                    //ProductBrand
                    $ProductBrand_array = array();
                    if (isset($product->Brand)) {
                        $productbrand = $product->Brand;

                        $ProductBrand_array['id'] = $productbrand['id'];
                        $ProductBrand_array['name'] = $productbrand['name'];
                        $ProductBrand_array['slug'] = $productbrand['slug'];
                        $ProductBrand_array['desc'] = $productbrand['desc'];
                        $ProductBrand_array['web_url'] = $productbrand['web_url'];
                        $ProductBrand_array['youtube_url'] = $productbrand['youtube_url'];
                        $ProductBrand_array['facebook_url'] = $productbrand['facebook_url'];
                        $ProductBrand_array['image'] = isset($productbrand->brandimages->filename) ? $productbrand->brandimages->filename : '';
                    }
                    $prod['productbrand'] = $ProductBrand_array;
                    //Images
                    $image_array = array();
                    if (isset($product->ProductImages)) {
                        $productImages = $product->ProductImages;
                        foreach ($productImages as $k => $productimage) {
                            $image_array[$k]['id'] = $productimage['id'];
                            $image_array[$k]['image_name'] = $productimage['image_name'];
                            $image_array[$k]['image_type'] = $productimage['image_type'];
                            $image_array[$k]['image_caption'] = $productimage['caption'];
                            $image_array[$k]['path'] = $productimage['image_name'];
                        }
                    }
                    $prod['images'] = $image_array;
                    //Documents
                    $document_array = array();
                    if (isset($product->ProductDocuments)) {
                        $ProductDocuments = $product->ProductDocuments;
                        foreach ($ProductDocuments as $k => $productdoc) {
                            $document_array[$k]['id'] = $productdoc['id'];
                            $document_array[$k]['document_name'] = $productdoc['document_name'];
                            $document_array[$k]['document_caption'] = $productdoc['caption'];
                            $document_array[$k]['path'] = $productdoc['document_name'];
                        }
                    }
                    $prod['documents'] = $document_array;

                    //Compatible products
                    $compatible_product_array = array();
                    if (isset($product->ProductCompatible)) {
                        $ProductCompatible = $product->ProductCompatible;
                        foreach ($ProductCompatible as $k => $productcomp) {
                            $compatible_product_array[$k]['id'] = $productcomp['id'];
                            $compatible_product_array[$k]['product_id'] = $productcomp['compatible_product_id'];
                            $compatible_product_array[$k]['product_image'] = isset($productcomp->image->image_name) ? $productcomp->image->image_name : '';
                            $compatible_product_array[$k]['product_name'] = isset($productcomp->compProducts->name) ? $productcomp->compProducts->name : '';
                            $compatible_product_array[$k]['product_description'] = isset($productcomp->compProducts->desc) ? $productcomp->compProducts->desc : '';
                            $compatible_product_array[$k]['product_price'] = isset($productcomp->compProducts->price) ? $productcomp->compProducts->price : '';
//						$compatible_product_array[$k]['brand_name'] = $productcomp->compBrand->brand->name;
//						$compatible_product_array[$k]['brand_slug'] = $productcomp->compBrand->brand->slug;
                        }
                    }
                    $prod['compatibleproducts'] = $compatible_product_array;

                    //Accessory products
                    $accessory_product_array = array();
                    if (isset($product->ProductAccessories)) {
                        $ProductAccessories = $product->ProductAccessories;
                        foreach ($ProductAccessories as $k => $productAss) {
                            $accessory_product_array[$k]['id'] = $productAss['id'];
                            $accessory_product_array[$k]['product_id'] = $productAss['accessory_product_id'];
                            $accessory_product_array[$k]['product_image'] = isset($productAss->image->image_name) ? $productAss->image->image_name : '';
                            $accessory_product_array[$k]['product_name'] = isset($productAss->compProducts->name) ? $productAss->compProducts->name : '';
                            $accessory_product_array[$k]['product_description'] = isset($productAss->compProducts->desc) ? $productAss->compProducts->desc : '';
                            $accessory_product_array[$k]['product_price'] = isset($productAss->compProducts->price) ? $productAss->compProducts->price : '';
//						$accessory_product_array[$k]['brand_name'] = $productAss->compBrand->brand->name;
//						$accessory_product_array[$k]['brand_slug'] = $productAss->compBrand->brand->slug;
                        }
                    }
                    $prod['accessoriesproducts'] = $accessory_product_array;

                    //ProductCategory
                    $ProductCategory_array = array();
                    if (isset($product->ProductCategory)) {
                        $productcateg = $product->ProductCategory;
                        $ProductCategory_array['id'] = $productcateg['id'];
                        $ProductCategory_array['title'] = $productcateg['title'];
                        $ProductCategory_array['slug'] = $productcateg['slug'];
                        $ProductCategory_array['short_desc'] = $productcateg['short_desc'];
                        $ProductCategory_array['status'] = $productcateg['status'];
                    }
                    $prod['product_category'] = $ProductCategory_array;

                    // Product New Category
                    // $product_category_array     = array();
                    // $product_sub_category_array = array();
                    // if (isset($product->ProductCategories)) {
                    //     $product_cat = $product->ProductCategories;
                    //     $product_category_array['id']           = $product_cat['id'];
                    //     $product_category_array['title']        = $product_cat['title'];
                    //     $product_category_array['slug']         = $product_cat['slug'];
                    //     $product_category_array['short_desc']   = $product_cat['short_desc'];
                    //     $product_category_array['status']       = $product_cat['status'];
                    //     if (isset($product->ProductCategories)) {
                    //         $product_sub_cat = $product->ProductCategories->subaCategories;
                    //         $product_sub_category_array['id']           = $product_sub_cat['id'];
                    //         $product_sub_category_array['name']         = $product_sub_cat['name'];
                    //         $product_sub_category_array['slug']         = $product_sub_cat['slug'];
                    //     }
                    // }
                    // $prod['product_category_arr'] = $product_category_array;
                    // $prod['product_sub_category_arr'] = $product_sub_category_array;

                    //ProductSubCategory
                    $ProductSubCategory_array = array();
                    if (isset($product->ProductSubCategory)) {
                        $ProductSubCategory = $product->ProductSubCategory;
                        $ProductSubCategory_array['id'] = $ProductSubCategory['id'];
                        $ProductSubCategory_array['title'] = $ProductSubCategory['title'];
                        $ProductSubCategory_array['slug'] = $ProductSubCategory['slug'];
                        $ProductSubCategory_array['short_desc'] = $ProductSubCategory['short_desc'];
                        $ProductSubCategory_array['status'] = $ProductSubCategory['status'];
                    }
                    $prod['product_sub_category'] = $ProductSubCategory_array;

                    //ProductTag
                    $ProductTags_array = array();
                    if (isset($product->ProductTags)) {
                        $producttgs = $product->ProductTags;
                        foreach ($producttgs as $k => $producttg) {
                            $ProductTags_array[$k]['id'] = $producttg['id'];
                            $ProductTags_array[$k]['tag_product_id'] = $producttg['tag_product_id'];
                            $ProductTags_array[$k]['tag_title'] = isset($producttg->tagproduct->title) ? $producttg->tagproduct->title : '';
                            $ProductTags_array[$k]['tag_slug'] = isset($producttg->tagproduct->slug) ? $producttg->tagproduct->slug : '';
                            $ProductTags_array[$k]['tag_description'] = isset($producttg->tagproduct->short_desc) ? $producttg->tagproduct->short_desc : '';
                            $ProductTags_array[$k]['tag_color'] = isset($producttg->tagproduct->color) ? $producttg->tagproduct->color : '';
                        }
                    }
                    $prod['product_tags'] = $ProductTags_array;

                    //UserDetails
                    $ProductUser_array = array();
                    if (isset($product->user)) {
                        $productusr = $product->user;
                        $ProductUser_array['user_id'] = $productusr->id;
                        $ProductUser_array['user_name'] = $productusr->full_name;
                        $ProductUser_array['user_address'] = $productusr->address;
                        $ProductUser_array['user_location'] = $productusr->location;
                        $ProductUser_array['user_location'] = $productusr->phone;
                        $ProductUser_array['user_country'] = $productusr->country;
                        $ProductUser_array['user_city'] = $productusr->phone;
                        $ProductUser_array['user_location'] = $productusr->phone;
                        if ($productusr->profile_photo != '') {
                            $profile_pic = $productusr->profile_photo;
                        } else {
                            $profile_pic = '';
                        }
                        $ProductUser_array['user_email'] = $productusr->email;
                        $ProductUser_array['user_notes'] = $productusr->notes;
                        $ProductUser_array['user_short_notes'] = $productusr->short_notes;
                        $ProductUser_array['user_profile_photo'] = $profile_pic;
                    }
                    $prod['user'] = $ProductUser_array;

                    //ProductReviews
                    $ProductReviews_array = array();
                    $totalStars = 0;
                    $numberOfReviews = 0;
                    $average = 0;
                    if (isset($product->reviews)) {
                        $productrevs = $product->reviews;
                        foreach ($productrevs as $k => $productrev) {
                            $ProductReviews_array[$k]['id'] = $productrev['id'];
                            $ProductReviews_array[$k]['ratings'] = $productrev['ratings'];
                            $ProductReviews_array[$k]['description'] = $productrev['description'];
                            $ProductReviews_array[$k]['user_id'] = $productrev->user->id;
                            $ProductReviews_array[$k]['user_name'] = $productrev->user->full_name;
                            if ($productrev->user->profile_photo != '') {
                                $profile_pic = $productrev->user->profile_photo;
                            } else {
                                $profile_pic = '';
                            }
                            $ProductReviews_array[$k]['user_profile_photo'] = $profile_pic;
                            $numberOfReviews++;
                            $totalStars += $productrev['ratings'];
                        }
                        if ($numberOfReviews != 0) {
                            $average = $totalStars / $numberOfReviews;
                        }
                    }

                    $prod['reviews'] = $ProductReviews_array;
                    $prod['likes'] = count($product['likescount']);
                    $prod['overallratings'] = floor($average);
                    //ProductProject
                    $ProductProject_array = array();
                    if (isset($product->productProject)) {
                        $productprojs = $product->productProject;
                        foreach ($productprojs as $k => $productproj) {

                            $ProductProject_array[$k]['project_id'] = $productproj['project_id'];
                            $ProductProject_array[$k]['project_name'] = $productproj->project->name;
                            $ProductProject_array[$k]['project_slug'] = $productproj->project->slug;
                            $ProductProject_array[$k]['project_desc'] = $productproj->project->desc;
                            $ProductProject_array[$k]['project_short_desc'] = $productproj->project->short_desc;
                            $ProductProject_array[$k]['estimated_budget'] = $productproj->project->estimated_budget;
                            $ProductProject_array[$k]['project_link_url'] = $productproj->project->link_url;
                            $ProductProject_array[$k]['project_link_youtube'] = $productproj->project->link_youtube;
                            $ProductProject_array[$k]['user_id'] = $productproj->project->user->id;
                            $ProductProject_array[$k]['user_name'] = $productproj->project->user->full_name;
                            if ($productproj->project->user->profile_photo != '') {
                                $profile_pic = $productproj->project->user->profile_photo;
                            } else {
                                $profile_pic = '';
                            }
                            $ProductProject_array[$k]['user_profile_photo'] = $profile_pic;

                            //category
                            if (isset($productproj->projeccategory->category)) {
                                $ProductProject_array[$k]['category']['category_id'] = $productproj->projeccategory->category->id;
                                $ProductProject_array[$k]['category']['category_title'] = $productproj->projeccategory->category->title;
                                $ProductProject_array[$k]['category']['category_slug'] = $productproj->projeccategory->category->slug;
                                $ProductProject_array[$k]['category']['category_short_desc'] = $productproj->projeccategory->category->short_desc;
                            } else {
                                $ProductProject_array[$k]['category'] = array();
                            }

                            //product_image
                            $productimagearray = Product_images::where('id', $productproj['id'])->where('image_type', 1)->first();
                            if (isset($productimagearray->id)) {
                                $ProductUser_array[$k]['product_image']['image_id'] = $productimagearray->id;

                                if ($productimagearray->image_name != '') {
                                    $product_img = $productimagearray->image_name;
                                } else {
                                    $product_img = '';
                                }
                                $ProductProject_array[$k]['project_image']['image_url'] = $product_img;

                                $ProductProject_array[$k]['project_image']['image_type'] = $productimagearray->image_type;
                                $ProductProject_array[$k]['project_image']['caption'] = $productimagearray->caption;
                            } else {
                                $ProductProject_array[$k]['project_image'] = array();
                            }

                            //product_reviews
                            $productreviewarray = ProductReviews::where('product_id', $productproj['id'])->get();

                            //product_comments
                            $productcommentarray = ProjectComment::where('project_id', $productproj['project_id'])->count();
                            $ProductProject_array[$k]['product_comment_count'] = $productcommentarray;
                        }
                    }
                    $prod['productproject'] = $ProductProject_array;
                    $productsubcategoryarray = Product::
                            select('product.id', 'product.product_sub_category', 'product.user_id', 'product.price', 'product.website_link', 'product.youtube_link', 'product.youtube_link2', 'product.created_at', 'product.product_category', 'product.name', 'product.slug', 'product.sku', 'product.desc', 'product.is_approved', 'users.full_name', 'users.profile_photo'
                            )
                            ->where('product.id', '!=', $id)
                            ->where('product.product_sub_category', $product['product_sub_category'])
                            ->leftJoin('users', 'users.id', '=', 'product.user_id')
                            ->latest('product.created_at')
                            ->limit(4)
                            ->get()
                            ->toarray();

                    $productsubcategorycount = count($productsubcategoryarray);
                    if (count($productsubcategoryarray) < 4) {
                        $notincludeproduct = array();
                        foreach ($productsubcategoryarray as $psa) {
                            $notincludeproduct[$psa['id']] = $psa['id'];
                        }
                        $toget = 4 - $productsubcategorycount;
                        $productcategoryarray = Product::select('product.id', 'product.product_sub_category', 'product.user_id', 'product.price', 'product.website_link', 'product.youtube_link', 'product.youtube_link2', 'product.created_at', 'product.product_category', 'product.name', 'product.slug', 'product.sku', 'product.desc', 'product.is_approved', 'users.full_name', 'users.profile_photo'
                                        )
                                        ->where('product.id', '!=', $id)
                                        ->whereNotIn('product.id', $notincludeproduct)
                                        ->leftJoin('users', 'users.id', '=', 'product.user_id')
                                        ->where('product.product_category', $product['product_category'])
                                        ->latest('product.created_at')
                                        ->limit($toget)->get()->toarray();
                        $productsubcategoryarrays = array_merge($productsubcategoryarray, $productcategoryarray);
                    }

                    $ProductUser_array = array();
                    if (isset($productsubcategoryarray[0]) && isset($productsubcategoryarrays)) {
                        foreach ($productsubcategoryarrays as $key => $productcatarray) {
                            $ProductUser_array[$key]['product_id'] = $productcatarray['id'];
                            $ProductUser_array[$key]['product_name'] = $productcatarray['name'];
                            $ProductUser_array[$key]['product_slug'] = $productcatarray['slug'];
                            $ProductUser_array[$key]['product_sku'] = $productcatarray['sku'];
                            $ProductUser_array[$key]['product_price'] = $productcatarray['price'];
                            $ProductUser_array[$key]['product_website_link'] = $productcatarray['website_link'];
                            $ProductUser_array[$key]['product_youtube_link'] = $productcatarray['youtube_link'];
                            $ProductUser_array[$key]['product_youtube_link2'] = $productcatarray['youtube_link2'];
                            $ProductUser_array[$key]['product_desc'] = $productcatarray['desc'];
                            $ProductUser_array[$key]['product_approved'] = $productcatarray['is_approved'] == 0 ? 0 : 1;
                            $ProductUser_array[$key]['user_name'] = $productcatarray['full_name'];
                            $ProductUser_array[$key]['user_id'] = $productcatarray['user_id'];
                            if ($productcatarray['profile_photo'] != '') {
                                $profile_pic = $productcatarray['profile_photo'];
                            } else {
                                $profile_pic = '';
                            }
                            $ProductUser_array[$key]['user_profile_photo'] = $profile_pic;
                            //product_image
                            $productimagearray = Product_images::where('id', $productcatarray['id'])->where('image_type', 1)->first();
                            if (isset($productimagearray->id)) {
                                $ProductUser_array[$key]['product_image']['image_id'] = $productimagearray->id;

                                if ($productimagearray->image_name != '') {
                                    $product_img = $productimagearray->image_name;
                                } else {
                                    $product_img = '';
                                }
                                $ProductUser_array[$key]['product_image']['image_url'] = $product_img;

                                $ProductUser_array[$key]['product_image']['image_type'] = $productimagearray->image_type;
                                $ProductUser_array[$key]['product_image']['caption'] = $productimagearray->caption;
                            } else {
                                $ProductUser_array[$key]['product_image'] = array();
                            }

                            //product_category
                            $productcategoryarray = ProductCategory::where('id', $productcatarray['product_category'])->first();
                            if (isset($productcategoryarray->id)) {
                                $ProductUser_array[$key]['product_category']['title'] = $productcategoryarray->title;
                                $ProductUser_array[$key]['product_category']['slug'] = $productcategoryarray->slug;
                                $ProductUser_array[$key]['product_category']['short_desc'] = $productcategoryarray->short_desc;
                            } else {
                                $ProductUser_array[$key]['product_category'] = array();
                            }

                            //product_reviews
                            $productreviewarray = ProductReviews::where('product_id', $productcatarray['id'])->get();
                            $totalStars = 0;
                            $numberOfReviews = 0;
                            $average = 0;
                            if (isset($productreviewarray[0])) {
                                foreach ($productreviewarray as $k => $productreview) {
                                    $numberOfReviews++;
                                    $totalStars += $productreview['ratings'];
                                }
                                if ($numberOfReviews != 0) {
                                    $average = $totalStars / $numberOfReviews;
                                }
                            }

                            $ProductUser_array[$key]['product_over_all_rating'] = floor($average);
                        }
                    }
                    $prod['relatedproducts'] = $ProductUser_array;
                }
                return $this->success(['product' => $prod], 'Ok');
            } else {
                throw new Exception('Invalid Product Id');
            }
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function updateproduct(Request $request) {
        try {
            if (!isset($request->product_id) || $request->product_id == "") {
                throw new Exception('Product id is required');
            }
            if (!isset($request->name) || $request->name == "") {
                throw new Exception('Please enter Product name');
            }
            if (!isset($request->sku) || $request->sku == "") {
                throw new Exception('Please enter Product sku');
            }
            if (!isset($request->product_category) || $request->product_category == "") {
                throw new Exception('Please enter Product category');
            }
       
            if (!isset($request->price) || $request->price == "") {
                throw new Exception('Please enter Product price');
            }
            if (!$this->isCurrency($request->price)) {
                throw new Exception('Product price is not valid');
            }
            if (!isset($request->brand) || $request->brand == "") {
                throw new Exception('Please enter Product brand');
            }
            if (!isset($request->desc) || $request->desc == "") {
                throw new Exception('Please enter Product description');
            }
            if (!isset($request->short_desc) || $request->short_desc == "") {
                throw new Exception('Please enter Product technical specifications');
            }
            
            if(!empty($request->website_link) && !filter_var($request->website_link, FILTER_VALIDATE_URL)) {
                throw new Exception('Link to website is not correct url');
            }
            
            if(!empty($request->youtube_link) && !filter_var($request->youtube_link, FILTER_VALIDATE_URL)) {
                throw new Exception('Youtube link is not correct url');
            }
            
            if(!empty($request->youtube_link2) && !filter_var($request->youtube_link2, FILTER_VALIDATE_URL)) {
                throw new Exception('Youtube link 2 is not correct url');
            }
            
            $user_details = User::getLoggedInUserDetails();
            //check if user is allowed to mark product as featured
            if (isset($request->is_featured) && $request->is_featured == "true") {                
                $this->checkIfUserIsPermitted($user_details, 'FEATURED_PRODUCTS');
            }
            
            //check if user is allowed to create product
            $this->checkIfUserIsPermitted($user_details, 'PRODUCTS');
            
            $product_id = $request->product_id;
            $imageType = 0;
            $store_file = array();
            $documentType = 0;
            $imagealreadyexist = 0;
            $allowedimageTypes = array("image/jpeg", "image/gif", "image/png");
            $alloweddocumentTypes = array("application/pdf");
            //documents check
            if ($request->hasFile('file_pdf')) {
                $files = $request->file('file_pdf');
                foreach ($files as $k => $file) {
                    $extension = $file->clientExtension();
                    $mimeType = $file->getMimeType();
                    $filename = $file->getClientOriginalName();
                    if (!in_array($mimeType, $alloweddocumentTypes)) {
                        $documentType = 1;
                    }
                }
            }

            if ($documentType == 1) {
                throw new Exception('Document should be of type ' . implode(", ", $alloweddocumentTypes));
            }
            //Images check
            if ($request->hasFile('images')) {
                $files = $request->file('images');
                foreach ($files as $k => $file) {
                    $extension = $file->clientExtension();
                    $mimeType = $file->getMimeType();
                    $filename = $file->getClientOriginalName();
                    if (!in_array($mimeType, $allowedimageTypes)) {
                        $imageType = 1;
                    }
                    $store_file[$k] = $mimeType;
                }
            }
            // else{
            // throw new Exception('At least one image is required');
            // }

            $productimgs = Product_images::where('product_id', $product_id)->get();
            if (isset($productimgs[0])) {
                $imagealreadyexist = 1;
                foreach ($productimgs as $productimg) {
                    $store_file[] = $productimg->id;
                }
            }

            if (count($store_file) > 5) {
                throw new Exception('Product images cannot be more than 5');
            }

            if ($imageType == 1) {
                throw new Exception('Product images should be of type ' . implode(", ", $allowedimageTypes));
            }

            //unique sku
            $productsku = Product::where('sku', $request->sku)->where('id', '!=', $product_id)->get();
            if (isset($productsku[0])) {
                throw new Exception('Product sku should be unique');
            }

            $update_product = Product::find($product_id);
            if (empty($update_product)) {
                throw new Exception('Invalid product id, please try again');
            }
            $name = $request->name;
            $sku = $request->sku;
            $desc = $request->desc;
            $short_desc = $request->short_desc;
            $price = $request->price;
            $category = $request->product_category;
            $product_sub_category = $request->product_sub_category;
            $brand_id = $request->brand;
            $website_link = $request->website_link;
            $youtube_link = $request->youtube_link;
            $youtube_link2 = $request->youtube_link2;
            if (isset($request->checked)) {
                $is_checked = 1;
            } else {
                $is_checked = 0;
            }

            if ($update_product->name != $name) {
                $update_product->name = $name;
                //unique slug
                $array = array(0);
                $slug = Product::createProductSlug($name);
                $sug = $slug;
                //Infinite loop to check product slug
                foreach ($array as $key => &$val) {
                    $array[++$key] = $key;
                    $productslug = Product::where('slug', $slug)->where('id', '!=', $product_id)->get();
                    if (isset($productslug[0])) {
                        $slug = $sug . '-' . random_int(1, 99);
                    } else {
                        break;
                    }
                }
                $update_product->slug = $slug;
            }
            if ($update_product->sku != $sku) {
                $update_product->sku = $sku;
            }
            $update_product->product_category = $category;
            $update_product->product_sub_category = $product_sub_category;
            $update_product->price = $price;
            $update_product->brand_id = $brand_id;
            $update_product->desc = $desc;
            $update_product->short_desc = $short_desc;
            $update_product->website_link = $website_link;
            $update_product->youtube_link = $youtube_link;
            $update_product->youtube_link2 = $youtube_link2;
            $update_product->is_checked = $is_checked;
            $update_product->updated_at = date('Y-m-d H:i:s');
            $update_product->featured = isset($request->is_featured) && $request->is_featured == "true" ? 1 : 0;
            $update_product->save();

            if ($request->hasFile('file_pdf')) {
                $files = $request->file('file_pdf');
                foreach ($files as $k => $file) {

                    $data = date('Y/m/d');
                    $hour = date('H');
                    $path = 'product/documents/' . $data . '/' . $hour . '-' . $product_id;
                    $document_image_file_path = imageuploads3($path, $file);

                    $productdoc = new Product_documents();
                    $productdoc->product_id = $product_id;
                    $productdoc->document_name = $document_image_file_path;
                    $productdoc->caption = $request->file_pdf_caption[$k];
                    $productdoc->save();
                }
            }

            if ($request->hasFile('images')) {
                $files = $request->file('images');
                $image_caption_arr = $request->image_caption;
                $image_is_main_arr = $request->image_is_main;
                foreach ($files as $k => $file) {

                    $data = date('Y/m/d');
                    $hour = date('H');
                    $path = 'product/images/' . $data . '/' . $hour . '-' . $product_id;
                    $product_image_file_path = imageuploads3($path, $file);

                    $productimg = new Product_images();
                    $productimg->product_id = $product_id;
                    $productimg->image_name = $product_image_file_path;
                    $productimg->image_type = isset($image_is_main_arr[$k]) ? $image_is_main_arr[$k] : 0;
                    $productimg->caption = isset($image_caption_arr[$k]) ? $image_caption_arr[$k] : "";
                    $productimg->save();
                }
            }

            //compatible products
            if ($request->compatible_product) {
                CompatibleProducts::where('product_id', '=', $product_id)->delete();
                $compatible_products = json_decode($request->compatible_product);
                foreach ($compatible_products as $k => $compatible_product) {
                    $compproduct = new CompatibleProducts();
                    $compproduct->product_id = $product_id;
                    $compproduct->compatible_product_id = $compatible_product;
                    $compproduct->save();
                }
            }
            //Accessories
            if ($request->accessories) {
                ProductAccessories::where('product_id', '=', $product_id)->delete();
                $accessories_products = json_decode($request->accessories);
                foreach ($accessories_products as $k => $accessorie_product) {
                    $accproduct = new ProductAccessories();
                    $accproduct->product_id = $product_id;
                    $accproduct->accessory_product_id = $accessorie_product;
                    $accproduct->save();
                }
            }
            //Tags
            if ($request->tags) {
                ProductTags::where('product_id', '=', $product_id)->delete();
                $tags_products = json_decode($request->tags);
                foreach ($tags_products as $k => $tags_product) {
                    $tagproduct = new ProductTags();
                    $tagproduct->product_id = $product_id;
                    $tagproduct->tag_product_id = $tags_product;
                    $tagproduct->save();
                }
            }

            return $this->success(null, 'Product updated_successfully');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function updatecoverimage(Request $request, $id) {
        try {
            $productimg = Product_images::find($id);
            if (empty($productimg)) {
                throw new Exception('Invalid image id');
            }
            $product_id = $productimg->product_id;
            //Update all Image type to 0 and update cover image
            $updateimagetype = Product_images::where('product_id', $product_id)->update(['image_type' => 0]);
            $updatecoverimage = Product_images::where('id', $id)->update(['image_type' => 1]);

            return $this->success(null, 'Cover image updated successfully');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function deletecoverimage(Request $request, $id) {
        try {
            $productimg = Product_images::find($id);
            if (empty($productimg)) {
                throw new Exception('Invalid Image Id');
            }
            
            $product_id = $productimg->product_id;
            $image_name = $productimg->image_name;
            $image_type = $productimg->image_type;
            
            $productImageCount = Product_images::where('product_id', $product_id)->count();
            if($productImageCount == 1) {
                throw new Exception('Product must have atleast one image');
            }
            
            Product_images::where('id', $id)->delete();
            
//            imagedeletes3($image_name); //deleteimage
            
            //if deleted image was main image then make another image as main
            if($image_type == 1) {
                $productimage = Product_images::where('product_id', $product_id)->first();
                if (!empty($productimage)) {
                    Product_images::where('id', $productimage->id)->update(['image_type' => 1]);
                }
            }

            return $this->success(null, 'Image deleted successfully');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function deletedocument(Request $request, $id) {
        try {
            $productdocument = Product_documents::find($id);
            if (empty($productdocument)) {
                throw new Exception('Invalid document id');
            }
            $product_id = $productdocument->product_id;
            $document_name = $productdocument->document_name;
            Product_documents::where('id', $id)->delete();
            //deletedocument
            imagedeletes3($document_name);

            return $this->success(null, 'Document deleted successfully');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    /**
     * IN USE
     * @param Request $request
     * @return type
     */
    public function addratings(Request $request) {
        try {
            if (!isset($request->user_id) || $request->user_id == "") {
                throw new Exception('User id is required');
            }
            if (!isset($request->product_id) || $request->product_id == "") {
                throw new Exception('Product id is required');
            }
            if (!isset($request->ratings) || $request->ratings == "") {
                throw new Exception('Ratings is required');
            }
            if (!isset($request->description) || $request->description == "") {
                throw new Exception('Description is required');
            }
            $user_id = $request->user_id;
            $product_id = $request->product_id;
            $ratings = $request->ratings;
            $description = $request->description;
            $productreview = new ProductReviews();
            $productreview->user_id = $user_id;
            $productreview->product_id = $product_id;
            $productreview->ratings = $ratings;
            $productreview->description = $description;
            $productreview->save();

            return $this->success(null, 'Ratings saved successfully');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function updateimagecaptions(Request $request, $id) {
        try {
            $productimage = Product_images::find($id);
            if (empty($productimage)) {
                throw new Exception('Invalid image id');
            }
            if (!isset($request->caption) || $request->caption == "") {
                throw new Exception('Image caption is required');
            }
            $caption = $request->caption;
            $productimage->caption = $caption;
            $productimage->save();

            return $this->success(null, 'Image caption saved successfully');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function updatedocumentcaptions(Request $request, $id) {
        try {
            $productdocument = Product_documents::find($id);
            if (empty($productdocument)) {
                throw new Exception('Invalid document id');
            }
            if (!isset($request->caption) || $request->caption == "") {
                throw new Exception('Document caption is required');
            }
            $caption = $request->caption;
            $productdocument->caption = $caption;
            $productdocument->save();

            return $this->success(null, 'Document caption saved successfully');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function notapproved(Request $request) {
        try {
            $approved = 0;
            $currpage = 1;
            if (isset($request->currpage) && $request->currpage != "" && is_numeric($request->currpage)) {
                $currpage = $request->currpage;
            }
            $prlist_count = Product::select('id')->where('is_approved', $approved)->orderBy('id', 'desc')->get()->count();
            if (!isset($request->record_per_page) || $request->record_per_page == "") {
                $record_per_page_all = Config::get('constant.record_per_page');
                $record_per_page = $record_per_page_all['product'];
            } else {
                $record_per_page = $request->record_per_page;
            }

            $page_first_result = ($currpage - 1) * $record_per_page;
            $number_of_page = ceil($prlist_count / $record_per_page);

            $query = Product::select('*')->where('is_approved', $approved)->withcount('likescount');
            $query = $query->orderBy('id', 'desc')->offset($page_first_result)->limit($record_per_page);
            $prlist = $query->get()->toArray();
            $prlist['current_page'] = $currpage;
            $prlist['record_per_page'] = $record_per_page;
            $prlist['number_of_page'] = $number_of_page;

            return $this->success(['product' => $prlist], 'Ok');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function published(Request $request) {
        try {
            $approved = 1;
            $currpage = 1;
            if (isset($request->currpage) && $request->currpage != "" && is_numeric($request->currpage)) {
                $currpage = $request->currpage;
            }
            $prlist_count = Product::select('id')->where('is_approved', $approved)->orderBy('id', 'desc')->get()->count();
            if (!isset($request->record_per_page) || $request->record_per_page == "") {
                $record_per_page_all = Config::get('constant.record_per_page');
                $record_per_page = $record_per_page_all['product'];
            } else {
                $record_per_page = $request->record_per_page;
            }

            $page_first_result = ($currpage - 1) * $record_per_page;
            $number_of_page = ceil($prlist_count / $record_per_page);

            $query = Product::select('*')->where('is_approved', $approved)->withcount('likescount');
            $query = $query->orderBy('id', 'desc')->offset($page_first_result)->limit($record_per_page);
            $prlist = $query->get()->toArray();
            $prlist['current_page'] = $currpage;
            $prlist['record_per_page'] = $record_per_page;
            $prlist['number_of_page'] = $number_of_page;
            
            return $this->success(['product' => $prlist], 'Ok');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }
    
    /**
     * IN USE
     * @param Request $request
     * @return type
     */
    public function like(Request $request)
    {
        try {
            $user_details = User::getLoggedInUserDetails();
            if(isset($request->type) && $request->type == '1') {
                $productLike = ProductLikes::where(['user_id' => $user_details['id'], 'product_id' => $request->product_id])->first();
                if(empty($productLike)) {
                    $productLike = new ProductLikes();
                    $productLike->product_id = $request->product_id;
                    $productLike->user_id = $user_details['id'];
                    $productLike->save();
                }
                
                $msg = "Product marked as favourite";
            } else {
                ProductLikes::where(['user_id' => $user_details['id'], 'product_id' => $request->product_id])->delete();
                $msg = "Product removed from favourite list";
            }
            
            return $this->success(null, $msg);
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function updateProductReviews(Request $request){
        try {
            $product_id = $request->product_id ?? "";
            $user_id    = $request->user_id ?? "";
            if(!empty($product_id) && !empty($user_id)) {
                if(ProductReviews::where([['product_id', "=" , $product_id], ['user_id', "=" , $user_id], ['is_read', "=" , 0]])->update(['is_read' => 1]))
                    return response()->json(['status' => true, 'data' => 'Comment updated successfully']);

            }
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    /**
     *
     * @param Request $request
     */
    public function doDeleteProduct(Request $request) {
        try {
            if (!isset($request->id) || $request->id == "" || !is_numeric($request->id)) {
                throw new Exception('Invalid request, please try again.');
            }
            $user_details = User::getLoggedInUserDetails();
            
            //check if user is allowed to handle products
            $this->checkIfUserIsPermitted($user_details, 'PRODUCTS');
            
            $user_id    = $user_details['id'];
            $id         = $request->id;

            $prd_obj = Product::where('id', $id)->where('user_id', $user_id)->first();
            if (empty($prd_obj)) {
                throw new Exception('Product not deleted, please try again.');
            }
            
            BrandProduct::where('product_id', $id)->delete();
            ProductCategory::where('product_id', $id)->delete();
            ProductAccessories::where('product_id', $id)->delete();
            ProductTags::where('product_id', $id)->delete();
            Product_documents::where('product_id', $id)->delete();
            Product_images::where('product_id', $id)->delete();
            ProductReviews::where('product_id', $id)->delete();
            ProductLikes::where('product_id', $id)->delete();

            if ($prd_obj->delete()) {
                return $this->success(null, 'Product deleted successfully');
            } else {
                throw new Exception('Product not deleted, please try again.');
            }
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

}
