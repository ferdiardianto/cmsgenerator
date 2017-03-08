<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Cover_headline extends Model {

	//
	protected $table = 'cover_headlines';

	protected $fillable=[
        'image',
        'caption',
        'id_microsite',
        'id_user'
    ];
}
