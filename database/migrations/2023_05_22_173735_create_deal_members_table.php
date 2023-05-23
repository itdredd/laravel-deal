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
        Schema::create('deal_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('deal_id');
            $table->unsignedInteger('user_id');
            $table->timestamp('last_read')->nullable();
            $table->timestamps();
            $table->unique(['deal_id' , 'user_id']);
        });

        Schema::table('deals', function (Blueprint $table) {
            $table->dropColumn('members_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deal_members');
    }
};
