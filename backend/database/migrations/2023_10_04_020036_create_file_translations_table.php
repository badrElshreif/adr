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
        Schema::create('file_translations', function (Blueprint $table)
        {
            $table->id();
            $table->string('name');
            $table->text('hint')->nullable();
            $table->string('locale')->index();
            $table->foreignId('file_id')->constrained('files')->onDelete('cascade');
            $table->unique(['file_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_translations');
    }
};
