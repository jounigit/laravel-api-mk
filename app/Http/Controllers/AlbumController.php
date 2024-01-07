<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Http\Resources\AlbumResource;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Cviebrock\EloquentSluggable\Services\SlugService;

class AlbumController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            \DB::connection()->getPDO();
            dump('Database connected: ' . \DB::connection()->getDatabaseName());
            } catch (\Exception $e) {
                dump('Database connected: ' . 'None');
        }
        return Album::with('pictures')->get();
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
        $album = Album::create([
            'title' => $request->title,
            'slug' => SlugService::createSlug(Album::class, 'slug', $request->title),
            'year' => $request->year,
            'content' => $request->content,
            'en_title' => $request->en_title,
            'en_content' => $request->en_content,
        ]);

	    $newAlbum = new AlbumResource($album);

        return $this->sendResponse($newAlbum, 'Album stored successfully.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int  $id)
    {
        //return new AlbumResource(Album::findOrFail($id));
        //return new AlbumResource($album);
        //$album = Album::where('id', $id)->with('pictures')->get();
        //return $album->toJson();
        return Album::where('id', $id)->with('pictures')->first();
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function bySlug(string  $slug)
    {
        //return new AlbumResource($album);
        return Album::where('slug', $slug)->with('pictures')->first();
        //$album = Album::where('slug', $slug)->with('pictures')->first();
        //return $album->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Album $album)
    {
        $reqData = $request->all();
        if ($album->title !== $request->title) {
            $reqData['slug'] = SlugService::createSlug(Album::class, 'slug', $request->title);
        }
        
        //$reqData['en_slug'] = SlugService::createSlug(Album::class, 'en_slug', $request->en_title);
        $album->update($reqData);
        $updatedAlbum = new AlbumResource($album);

        return $this->sendResponse($updatedAlbum, 'Album updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album)
    {
        $status = $album->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Album deleted!' : 'Error deleting Album'
        ]);
    }
}
