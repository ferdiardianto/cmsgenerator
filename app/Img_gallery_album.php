<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Img_gallery_album extends Model {

	//
	protected $table = 'img_gallery_albums';

	protected $fillable=[
        'album_name',
        'description',
        'id_microsite',
        'id_user'
    ];

}
