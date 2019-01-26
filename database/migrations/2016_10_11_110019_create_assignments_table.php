<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function(Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->integer('assignment_type_id');
            $table->integer('sub_discipline_id');
            $table->text('instructions');
            $table->integer('pages');
            $table->timestamp('deadline')->nullable();
            $table->float('price', 12, 2)->nullable();
            $table->string('type_of_service');
            $table->integer('academic_level_id');
            $table->integer('format_id');
            $table->integer('user_id');
            $table->integer('writer_id')->default(0)->nullable();
            $table->enum('status', ['AUCTION','PROGRESS', 'COMPLETE'])->default('AUCTION');
            $table->integer('bids')->default(0);
            $table->integer('views')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('assignments');
    }
}
