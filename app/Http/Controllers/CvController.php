<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use App\Http\Resources\CvResource;
use App\Http\Resources\CvCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class CvController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Cv::all();
       // return new CvCollection(Cv::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cv = Cv::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

	    $newCv = new CvResource($cv);

        return $this->sendResponse($newCv, 'Cv stored successfully.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int  $id)
    {
        return Cv::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cv  $cv
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cv $cv)
    {
        $reqData = $request->all();
        $cv->update($reqData);
        $updatedCv = new CvResource($cv);

        return $this->sendResponse($updatedCv, 'Cv updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cv  $cv
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cv $cv)
    {
        $status = $cv->delete();
        
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Cv deleted!' : 'Error deleting Cv'
        ]);
    }
}
