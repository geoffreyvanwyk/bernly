<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('urls', function(Blueprint $table)
		{
			$table->increments('id');
			/* 
			1. HTTP standard RFC 2616 section 3.2.1 (http://www.faqs.org/rfcs/rfc2616.html) places no limit on
			length of URL.
			
			2. Internet Explorer has a limit of 2083. (http://support.microsoft.com/kb/q208427), which is the 
			shortest of all web browsers (http://www.boutell.com/newfaq/misc/urllength.html).
			*/
			$table->string('long_url', 2083);
			$table->string('short_url', 2083);
			
			/* Creates a created_at timestamp and a updated_at timestamp. */
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
		Schema::drop('urls');
	}

}
