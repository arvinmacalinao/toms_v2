<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToUserLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('to_user_logs', function (Blueprint $table) {
            $table->bigIncrements('ul_id');
            $table->date('ul_date');
            $table->string('ul_page_title', 255);
            $table->Integer('u_id')->unsigned()->nullable();
            $table->foreign('u_id')->references('u_id')->on('to_users');
            $table->text('ul_url');
            $table->Integer('r_id')->unsigned()->nullable();
            $table->foreign('r_id')->references('r_id')->on('to_roles');
            $table->text('ul_agent')->nullable();
            $table->string('ul_ip');
            $table->string('ul_method');
            $table->Integer('rg_id')->unsigned()->nullable();
            $table->foreign('rg_id')->references('rg_id')->on('to_regions');
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
        Schema::dropIfExists('to_user_logs');
    }
}
