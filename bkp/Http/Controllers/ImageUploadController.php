<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;

use Storage;

  
class ImageUploadController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function imageUpload()
    {

        return view('image');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function imageUploadPost(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time().'.'.$request->image->extension();  
        $path = Storage::disk('s3')->put('images', $request->image);
        $path = Storage::disk('s3')->url($path);
		return response()->json(['path' => $path]);
    }
}