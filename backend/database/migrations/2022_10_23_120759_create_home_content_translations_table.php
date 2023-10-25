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
        Schema::create('home_content_translations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->string('locale')->index();
            $table->foreignId('home_content_id')->constrained('home_contents')->onDelete('cascade');
            $table->unique(['home_content_id', 'locale']);
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
        Schema::dropIfExists('home_content_translations');
    }
};
