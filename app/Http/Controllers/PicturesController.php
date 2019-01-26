<?php

namespace App\Http\Controllers;

define('IMG_PATH', base_path() . '/public_html/images/uploads/');

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use Image;

use App\User;

use Session;

class PicturesController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    public function updateProfilePicture(Request $request){
    	if($request->hasFile('image') && $request->file('image')->isValid()){
    		$this->validate($request,[
    			'image' => 'mimes:jpg,jpeg,png,bmp',
    		]);

    		$user = User::find(Auth::user()->id);

            if(!$user){
                Session::flash('error', 'Cannot load page, user not found');
                return redirect()->back();
            }

    		if(!empty(Auth::user()->image && !empty(Auth::user()->thumbnail))){
	    		$user = User::find(Auth::user()->id);

                if(!$user){
                    Session::flash('error', 'Cannot load page, user not found');
                    return redirect()->back();
                }
	    		
	    		$image_path = IMG_PATH . $user->image;
	    		$thumb_path = IMG_PATH . $user->thumbnail;

	    		$user->image = "";
	    		$user->thumbnail = "";

	    		@unlink($image_path);
	    		@unlink($thumb_path);

	    	}

    		$file = $request->file('image');
    		
    		$fileName = 'image_'. time() . '.' . $file->getClientOriginalExtension();

			$path = IMG_PATH . $fileName;

			$thumbnail = 'thumb_' .$fileName;

			$thumbnailPath = IMG_PATH . $thumbnail;


			Image::make($file)->fit(400,400)->save($path);

			Image::make($file)->fit(30,30)->save($thumbnailPath);

		    $user->thumbnail = $thumbnail;
		    $user->image = $fileName;

			$user->update();
    	}

    	return redirect()->back();
    }

    public function removeProfilePicture(){
    	if(!empty(Auth::user()->image && !empty(Auth::user()->thumbnail))){
    		$user = User::find(Auth::user()->id);

            if(!$user){
                Session::flash('error', 'Cannot load page, user not found');
                return redirect()->back();
            }
    		
    		$image_path = IMG_PATH . $user->image;
    		$thumb_path = IMG_PATH . $user->thumbnail;

    		$user->image = "";
    		$user->thumbnail = "";

    		@unlink($image_path);
    		@unlink($thumb_path);

            $user->update();

    		Session::flash('success', 'Profile picture removed');
    	}

    	return redirect()->back();
    }
}
