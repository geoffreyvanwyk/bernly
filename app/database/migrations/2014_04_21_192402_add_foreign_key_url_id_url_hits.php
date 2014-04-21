<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyUrlIdUrlHits extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('url_hits', function(Blueprint $table)
		{
			$table->foreign( 'url_id' )->references( 'id' )->on( 'urls' )->onDelete( 'cascade' );
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('url_hits', function(Blueprint $table)
		{
			$table->dropForeign( 'url_hits_url_id_foreign' );
		});
	}

}
