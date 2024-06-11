<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\AutoPost;
use App\Models\AutoPostHasModel;

use App\Models\CraigslistPost;

class AutoPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (env('APP_TEST') == 1) {
            $this->craigslistPosts();
        }
    }

    public function craigslistPosts()
    {
        $craigslistPosts = CraigslistPost::limit(10)->get();
        $model_type = get_class(new CraigslistPost());

        foreach ($craigslistPosts as $craigslistPost) {
            $this->create($model_type, $craigslistPost->id);
        }

        return;
    }

    public function create($model_type, $model_id)
    {
        AutoPost::factory()->create([
            'post_type' => $model_type,
            'post_id' => $model_id,
        ]);
    }
}
