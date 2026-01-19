<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
     protected $fillable = [
        "slider_image_1",
        "slider_image_2",
        "slider_image_3",
        "main_heading",
        "main_pera",
        "logo",
        "Section_3_Image",
        "Section_3_Text",
        "Section_3_Text2",
        "ORcode",
    ];
}
