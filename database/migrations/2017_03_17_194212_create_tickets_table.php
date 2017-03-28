<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned()->onDelete('cascade');
            $table->boolean('paid')->default(false);
            $table->timestamps();

        });

        Schema::table('ticket', function(Blueprint $table) {
           $table->foreign('customer_id')->references('id')->on('customer');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket');
    }
}
