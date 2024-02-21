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
        Schema::create('rss_feeds', function (Blueprint $table) {
            $table->id();
            $table->text("rss_feed_link")->nullable();
            $table->unsignedInteger("refresh_interval")->nullable();
            $table->enum("interval_type", ['minutes', 'hours', 'days'])->nullable();
            $table->datetime("session_started_at")->nullable();
            $table->datetime("session_ended_at")->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });

        Schema::create('rss_feed_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rss_feed_id');
            $table->string("title")->nullable();
            $table->text("link")->nullable();
            $table->datetime("published_at")->nullable();
            $table->enum("status", ['old', 'new'])->default('new');
            $table->timestamps();
            $table->foreign('rss_feed_id')->references('id')->on('rss_feeds')->constrained()->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rss_feeds');
        Schema::dropIfExists('rss_feed_details');
    }
};
