<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Http\Resources\PictureResource;
use App\Http\Resources\PictureCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Image;
use File;

class PictureController extends BaseController
{
     /**
     * Public variables.
     * */
    
    public $THUMBS_DIR = "/home/marjakol/public_html/images/thumbs";
    public $MIDDLES_DIR = "/home/marjakol/public_html/images/middles";
    public $BIGS_DIR = "/home/marjakol/public_html/images";
     
     /**
     * Dev variables.
     */
    // public $BIGS_DIR = "/images";
    // public $MIDDLES_DIR = "/home/jouni/Kolu/backend/images/middles";
    // public $THUMBS_DIR = "/home/jouni/Kolu/backend/images/thumbs";
    
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response    //return new PictureCollection(Picture::all());
     */
    public function index()
    {
       /** */
        // echo dirname(base_path()) . "/images";
        // echo "\n";
        // echo  base_path();
        // echo "\n";
        // echo __DIR__ ;
        // echo "\n";
        // echo dirname(__DIR__);
        // echo "\n"; 
        return Picture::all();
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response  // $images_dir = "https://marjakolu.fi/images/"; //$request->image->move($thumbs_dir, $imageName);
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
      
        $uploaded_file = $request->file('image');
        $imageName = time().'.'.$request->image->extension();
       
        $savedToFolders = $this->handleUpload($uploaded_file, $imageName);
        // $request->image->move(public_path('images'), $imageName);
    
        $picture = Picture::create([
            'title' => $imageName,
            'image' => $imageName,
        ]);
        $newPic = new PictureResource($picture);

        return $this->sendResponse($newPic, 'Picture stored successfully.', 201);
    }
        
    /**
     * @param string $dir
     * @return void
     */
    private function isDirectory($dir) {
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0777, true, true);
        }
    }
    
    /**
     * @param mixed $uploaded_file
     * @param string $filename
     * @return void
     */
    private function handleUpload($uploaded_file, $imageName)
    {
        // Make directories
        $this->isDirectory($this->THUMBS_DIR);
        $this->isDirectory($this->MIDDLES_DIR);
        $this->isDirectory($this->BIGS_DIR);

        // Resize images here
        $this->resizeImageAndSave($uploaded_file, $this->THUMBS_DIR, $imageName, 300);
        $this->resizeImageAndSave($uploaded_file, $this->MIDDLES_DIR, $imageName, 600);
        $this->resizeImageAndSave($uploaded_file, $this->BIGS_DIR, $imageName, 1600);
    }
    
    /**
     * @param mixed $uploaded_file
     * @param string $destinationPath
     * @param string $imageName
     * @param int $size
     * @return void
     */
    private function resizeImageAndSave($uploaded_file, $destinationPath, $imageName, $size)
    {
        $img = Image::make($uploaded_file->path());
        $img->resize($size, $size, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'. $imageName);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int  $id)
    {
        return Picture::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Picture $picture)
    {
        $reqData = $request->all();
        $picture->update($reqData);
        $updatedPic = new PictureResource($picture);

        return $this->sendResponse($updatedPic, 'Picture updated successfully.');
    }
    
    public function removeImage($path, $image)
    {  
        if(\File::exists($path.'/'.$image)){
            \File::delete($path.'/'.$image);
            return response()->json('Picture removed successfully.', 201);
        }else{
            return response()->json("Picture $path.'/'.$image does  not exist.", 202);
        }/* */
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Picture $picture)
    {
        $del = $picture->delete();
        
        if (!$del) {
            return $this->sendError('Could not delete picture!');
        }
        $img1 = $this->THUMBS_DIR.'/'.$picture->image;
        $img2 = $this->MIDDLES_DIR.'/'.$picture->image;
        $img3 = $this->BIGS_DIR.'/'.$picture->image;
        
        /*$remove = File::delete([
            '$img1',
            '$img2',
            '$img3'
            ]);*/

         $remove1 = $this->removeImage($this->THUMBS_DIR, $picture->image);
         $remove2 = $this->removeImage($this->MIDDLES_DIR, $picture->image); 
         $remove3 = $this->removeImage($this->BIGS_DIR, $picture->image);

        if ($remove1 && $remove2 && $remove3) {
            return response()->json('Picture removed successfully.', 201);
        }
        return $this->sendError('Could not delete picture!');
    }
}
