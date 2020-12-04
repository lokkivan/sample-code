<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLayoutFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layout_files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('layout_id')->nullable(false);
            $table->string('file_name')->nullable(false);

            $table->foreign('layout_id')->references('id')->on('layouts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('layout_files');
    }
}
