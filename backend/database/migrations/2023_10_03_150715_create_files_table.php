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
        Schema::create('files', function (Blueprint $table)
        {
            $table->id();
            $table->string('icon')->nullable();
            $table->string('file')->nullable(); // voice, video
            $table->boolean('is_active')->default(1);
            $table->boolean('appear_for_free_package')->default(1);
            $table->string('type')->nullable(); //voice, video
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
        Schema::dropIfExists('files');
    }
};
