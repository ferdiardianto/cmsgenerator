<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class video_gallery extends Model {

	//
	protected $table = 'video_gallerys';

	protected $fillable=[
        'title',
        'video_url',
        'embed_url',
        'description',
        'large_img',
        'thumb_img',
        'id_microsite',
        'id_user'
    ];

}
