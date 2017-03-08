<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicrositesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('microsites', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('website_name');
			$table->string('slogan');
			$table->string('author',100);
			$table->string('email',100);
			$table->string('themes');
			$table->string('subdomain',100);
			$table->string('user_id',50);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('microsites');
	}

}
