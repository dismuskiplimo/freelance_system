<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->float('amount', 12,2);
            $table->enum('type', ['INCOMING', 'OUTGOING']);
            $table->enum('status', ['PENDING','COMPLETE','REJECTED'])->default('PENDING');
            $table->integer('to_id')->nullable();
            $table->integer('from_id')->nullable();
            $table->integer('assignment_id')->nullable();
            $table->boolean('frozen')->default(0);
            $table->string('details');
            $table->datetime('matures_at')->nullable();
            $table->datetime('transferred_at')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('transactions');
    }
}
