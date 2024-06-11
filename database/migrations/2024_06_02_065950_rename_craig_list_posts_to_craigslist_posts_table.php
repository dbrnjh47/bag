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
        Schema::rename("craig_list_posts", "craigslist_posts");

        Schema::dropIfExists('craig_list_posts');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {


        Schema::rename("craigslist_posts", "craig_list_posts");



        Schema::dropIfExists('craigslist_posts');
    }
};
