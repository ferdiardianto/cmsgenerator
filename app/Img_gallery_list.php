<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Img_gallery_list extends Model {

	//
	protected $table = 'img_gallery_lists';

	protected $fillable=[
        'id_album',
        'id_image'
    ];

}
