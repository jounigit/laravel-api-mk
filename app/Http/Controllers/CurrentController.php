<?php

namespace App\Http\Controllers;

use App\Models\Current;
use App\Http\Resources\CurrentResource;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Cviebrock\EloquentSluggable\Services\SlugService;

class CurrentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Current::with('pictures')->get();
         // $albums = Album::with('pictures')->get();
         // return response()->json($albums);
         // return AlbumResource::collection(Album::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $doc = Current::create([
            'title' => $request->title,
            'slug' => SlugService::createSlug(Current::class, 'slug', $request->title),
            'place' => $request->place,
            'address' => $request->address,
            'content' => $request->content,
            'en_title' => $request->en_title,
            'en_content' => $request->en_content,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'is_published' => $request->is_published,
        ]);

	    $newDoc = new AlbumResource($doc);

        return $this->sendResponse($newDoc, 'Current stored successfully.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int  $id)
    {
        return Current::where('id', $id)->with('pictures')->first();
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function bySlug(string  $slug)
    {
        return Current::where('slug', $slug)->with('pictures')->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Current  $current
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Current $current)
    {
        $reqData = $request->all();
        if ($current->title !== $request->title) {
            $reqData['slug'] = SlugService::createSlug(Current::class, 'slug', $request->title);
        }
        
        $current->update($reqData);
        $updated = new CurrentResource($current);

        return $this->sendResponse($updated, 'Current updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Current  $current
     * @return \Illuminate\Http\Response
     */
    public function destroy(Current $current)
    {
        $status = $current->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Current deleted!' : 'Error deleting Current'
        ]);
    }
}
