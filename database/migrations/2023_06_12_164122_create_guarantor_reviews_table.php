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
        Schema::create('guarantor_reviews', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->float('rating')->default(0);
            $table->bigInteger('guarantor_id')->unsigned();
            $table->text('review');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('guarantor_id')->references('id')->on('guarantors');

            $table->index(['user_id', 'guarantor_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guarantor_reviews');
    }
};
