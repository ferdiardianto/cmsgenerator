<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

	//
	protected $table = 'articles';

	protected $fillable=[
        'title',
        'id_category',
        'content',
        'teaser',
        'origin_img',
        'prev_img',
        'thumb_img',
        'icon_img',
        'id_user',
        'id_microsite',
        'status',
        'tag',
        'date_schedule'
    ];

}
