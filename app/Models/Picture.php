<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 
        'en_title', 
        'year', 
        'technique', 
        'en_technique', 
        'size', 
        'content', 
        'en_content', 
        'photographer', 
        'image', 
        'pic_order'
    ];
    
    /**
     * Get the albums picture belongs.
     */
    public function albums()
    {
        return $this->belongsToMany(Album::class);
    }
}