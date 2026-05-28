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
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('content');
            $table->unsignedBigInteger('tagged_movie_id')->nullable()->after('image_path');
            $table->string('tagged_movie_title')->nullable()->after('tagged_movie_id');
            $table->string('tagged_movie_type')->nullable()->after('tagged_movie_title');
            $table->integer('rating')->nullable()->after('tagged_movie_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['image_path', 'tagged_movie_id', 'tagged_movie_title', 'tagged_movie_type', 'rating']);
        });
    }
};
