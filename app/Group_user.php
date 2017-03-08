<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Group_user extends Model {

	//
	protected $table = 'group_users';

	protected $fillable=[
        'nama_group',
        'hak_akses'
    ];

}
