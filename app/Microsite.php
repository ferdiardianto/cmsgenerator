<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Microsite extends Model  {

	//
	protected $table = 'microsites';

	protected $fillable=[
        'website_name',
        'subdomain',
        'slogan',
        'author',
        'email',
        'description'
    ];
}
