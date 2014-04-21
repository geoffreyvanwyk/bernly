<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlHits extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('url_hits', function(Blueprint $table)
		{
			$table->increments('id');
			
			$table->integer('url_id')->unsigned();
			$table->string('referrer', 2083);
			
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
		Schema::drop('url_hits');
	}

}
