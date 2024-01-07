<?php

namespace App\Http\Controllers;

use App\Models\CurrentPicture;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class CurrentPictureController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CurrentPicture::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        CurrentPicture::create([
            'current_id' => $request->current_id,
            'picture_id' => $request->picture_id,
        ]);
        
        return $this->sendResponse('Data stored successfully.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CurrentPicture  $currentPicture
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
       $currentPic = CurrentPicture::find($id);
        return $currentPic->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CurrentPicture  $currentPicture
     * @return \Illuminate\Http\Response
     */
    public function destroy(int  $id)
    {
        $currentPicture = CurrentPicture::find($id);
        $status = $currentPicture->delete();
        
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Picture removed from current!' : 'Error removing picture'
        ]);
    }
}
