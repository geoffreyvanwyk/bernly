<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlHitsTable extends Migration {

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
            $table->string('referer', 2083)->nullable()->default( 'Web browser address bar'  );
            
            $table->foreign( 'url_id' )->references( 'id' )->on( 'urls' )->onDelete( 'cascade' );
            
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
