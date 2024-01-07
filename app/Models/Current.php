<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Current extends Model
{
    use HasFactory,Sluggable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'place', 'address', 'content', 'en_title', 'en_content', 'from_date', 'to_date', 'is_publish'
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
     * Get the pictures for the current.
     */
    public function pictures()
    {
        return $this->belongsToMany(Picture::class);
    }
}
