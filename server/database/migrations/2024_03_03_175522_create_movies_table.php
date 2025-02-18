<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 1024);
            $table->string('origin_name', 1024);
            $table->string('slug')->unique();
            $table->text('content')->nullable();
            $table->string('thumb_url', 2048)->nullable();
            $table->string('poster_url', 2048)->nullable();
            $table->enum('type', ['single', 'series', 'cartoon', 'tvshows', 'unknow']);
            $table->enum('status', ['trailer', 'ongoing', 'completed']);
            $table->string('trailer_url', 2048)->nullable();
            $table->string('episode_time')->nullable();
            $table->string('episode_current')->nullable();
            $table->string('episode_total')->nullable();
            $table->string('quality')->nullable()->default('HD');
            $table->string('language')->nullable()->default('Vietsub');
            $table->string('notify', 512)->nullable();
            $table->string('showtimes', 512)->nullable();
            $table->string('year')->index()->nullable();
            $table->boolean('is_show_in_theater')->default(false);
            $table->boolean('is_recommended')->default(false);
            $table->boolean('is_copyright')->default(false);
            $table->boolean('is_sensitive_content')->default(false);

            $table->integer('view_total')->default(0);
            $table->integer('view_day')->default(0);
            $table->integer('view_week')->default(0);
            $table->integer('view_month')->default(0);
            $table->integer('rating_count')->default(0);
            $table->decimal('rating_star', 3, 1)->default(0);

            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('user_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
