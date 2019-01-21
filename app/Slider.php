<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'photo',
        'title',
        'content',
        'button_text',
        'button_link'
    ];

    protected $table = 'sliders';
}
