<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DenullifyRefererColumnUrlHitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::update( "ALTER TABLE url_hits MODIFY referer VARCHAR(2083) NOT NULL" );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        DB::update( "ALTER TABLE url_hits MODIFY referer VARCHAR(2083) NULL" );
	}

}
