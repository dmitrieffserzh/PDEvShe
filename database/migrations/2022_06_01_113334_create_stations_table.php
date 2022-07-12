<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create( 'stations', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'name' );
            $table->string( 'slug' );
            $table->string( 'title' );
            $table->text( 'content' );
        } );
    }

    public function down() {
        Schema::dropIfExists( 'stations' );
    }
};
