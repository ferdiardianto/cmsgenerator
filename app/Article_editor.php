<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Article_editor extends Model {

	protected $table = 'article_editors';

	protected $fillable=[
        'id_article',
        'id_microsite',
        'id_user'
    ];

}
