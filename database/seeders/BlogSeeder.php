<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use App\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 7; $i++) {
            Blog::create([
                'title' => "Blog Post Title $i",
                'author' => "Author $i",
                'short_description' => "This is a short preview of blog $i. Lorem ipsum...",
                'full_content' => "This is the full content of blog $i. Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
                'image' => "blog$i.jpg",
            ]);
        }
    }
}

