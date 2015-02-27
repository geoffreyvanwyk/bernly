<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameUsersUrlsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_urls', function(Blueprint $table)
		{
			$table->rename( 'url_user' );
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users_urls', function(Blueprint $table)
		{
            $table->rename( 'users_urls' );
		});
	}

}
