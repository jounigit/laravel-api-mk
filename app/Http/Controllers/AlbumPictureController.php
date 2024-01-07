<?php

namespace App\Http\Controllers;

use App\Models\AlbumPicture;
use App\Models\Album;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class AlbumPictureController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AlbumPicture::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        AlbumPicture::create([
            'album_id' => $request->album_id,
            'picture_id' => $request->picture_id,
        ]);
        
        return $this->sendResponse('Data stored successfully.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AlbumPicture  $albumPicture
     * @return \Illuminate\Http\Response
     */
    public function show(int  $id)
    {
       $albumPic = AlbumPicture::find($id);
        return $albumPic->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AlbumPicture  $albumPicture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AlbumPicture $albumPicture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AlbumPicture  $albumPicture
     * @return \Illuminate\Http\Response
     */
    public function destroy(int  $id)
    {
        $albumPicture = AlbumPicture::find($id);
        $status = $albumPicture->delete();
        
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Picture removed from album!' : 'Error removing picture'
        ]);
    }
}
