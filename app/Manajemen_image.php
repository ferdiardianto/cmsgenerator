<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Manajemen_image extends Model {

	//
	protected $table = 'manajemen_images';

	protected $fillable=[
        'caption',
        'author',
        'img_origin',
        'img_preview',
        'img_thumb',
        'img_icon',
        'id_user',
        'id_microsite'
    ];


}
