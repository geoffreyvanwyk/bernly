<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersUrlsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_urls', function(Blueprint $table)
        {
            $table->increments( 'id' );
            
            $table->integer( 'user_id' )->unsigned();
            $table->integer( 'url_id' )->unsigned();
            
            
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );
            $table->foreign( 'url_id' )->references( 'id' )->on( 'urls' )->onDelete( 'cascade' );
            $table->unique( array( 'user_id', 'url_id' ) );
            
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
        Schema::drop('users_urls');
    }

}
