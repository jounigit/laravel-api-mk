<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Album extends Model
{
    use HasFactory,Sluggable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'year', 'content', 'en_title', 'en_content'
    ];
    
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    
    
    /**
     * Get the pictures for the album.
     */
    public function pictures()
    {
        return $this->belongsToMany(Picture::class);
    }
}
