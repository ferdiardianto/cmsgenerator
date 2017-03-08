<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class group_microsite extends Model {

	//
	protected $table = 'group_microsites';

	protected $fillable=[
        'id_microsite',
        'id_group_user'
    ];

}
