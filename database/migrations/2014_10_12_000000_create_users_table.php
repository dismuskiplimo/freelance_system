<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username');
            $table->enum('user_type', ['CLIENT','WRITER','ADMIN']);
            $table->string('email')->unique();
            $table->string('paypal_email')->nullable();
            $table->date('dob')->nullable();
            $table->integer('balance')->default(0);
            $table->boolean('is_admin')->default(0);
            $table->string('password');
            $table->string('image')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('academic_level_id')->nullable();
            $table->string('school')->nullable();
            $table->string('field_of_specialization')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('about')->nullable();
            $table->string('professional_bio', 240)->nullable();
            $table->string('my_details')->nullable();
            $table->string('academic_experience',240)->nullable();
            $table->integer('views')->default(0);
            $table->integer('orders_complete')->default(0);
            $table->timestamp('last_seen')->useCurrent();
            $table->boolean('active')->default(1);
            $table->integer('attempts_left')->default(3);
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
