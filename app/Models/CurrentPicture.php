<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrentPicture extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'current_picture';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'current_id', 'picture_id',
    ];
}
