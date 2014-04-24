<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetDefaultRefererColumnUrlHits extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::update( "ALTER TABLE url_hits MODIFY referer VARCHAR(2083) NOT NULL DEFAULT 'Unknown'" );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        DB::update( "ALTER TABLE url_hits MODIFY referer VARCHAR(2083) NOT NULL" );
	}

}
