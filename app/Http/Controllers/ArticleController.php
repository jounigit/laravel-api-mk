<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class ArticleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Article::all();
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $album = Article::create([
            'title' => $request->title,
            'year' => $request->year,
            'media' => $request->media,
            'author' => $request->author,
            'file' => $request->file,
        ]);

	    $newArt = new ArticleResource($article);

        return $this->sendResponse($newArt, 'Article stored successfully.', 201);
    }
}
