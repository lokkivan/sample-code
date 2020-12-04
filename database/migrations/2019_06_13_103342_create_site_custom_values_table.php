<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteCustomValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_custom_values', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('site_id')->nullable(false);
            $table->string('name', 255)->nullable(false);
            $table->text('value')->nullable(false);
            $table->timestamps();

            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_custom_values');
    }
}
