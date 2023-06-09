<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('guarantors', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->float('rating')->default(0);
            $table->integer('successful_deals')->default(0);
            $table->integer('dissatisfied_deals')->default(0);
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
        Schema::dropIfExists('guarantors');
    }
};
