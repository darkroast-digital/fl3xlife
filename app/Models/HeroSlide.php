<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'image',
        'heading',
        'subtitle',
        'description',
        'link_name',
        'link',
        'button_display'
    ];
}
