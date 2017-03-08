<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Category_article extends Model {

	//
	protected $table = 'category_articles';

	protected $fillable=[
        'category_name',
        'status',
        'id_microsite',
        'id_user'
    ];




}
