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
        Schema::table('posts', function (Blueprint $table) {

            $table->unsignedBigInteger('user_id')->nullable(); // create column for user id as foreign key
            // -> nullable => as default value => null
            $table->foreign('user_id')->references('id')->on('users'); // constrains
        });
    }

};
