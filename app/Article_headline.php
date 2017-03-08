<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Article_headline extends Model {

	//
	protected $table = 'article_headlines';

	protected $fillable=[
        'id_article',
        'id_microsite',
        'id_user'
    ];
}
