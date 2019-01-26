<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function(Blueprint $table){
            $table->increments('id');
            $table->integer('assignment_id');
            $table->integer('writer_id');
            $table->integer('client_id');
            $table->string('title');
            $table->text('content');
            $table->enum('reaction', ['POSITIVE', 'NEGATIVE']);
            $table->integer('stars')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ratings');
    }
}
