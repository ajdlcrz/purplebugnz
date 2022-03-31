<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = array(
            array(
                "id" => 1,
                "title" => "Social Media",
                "slug" => "social-media",
                "status" => 1,
                "deleted_at" => NULL,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 2,
                "title" => "Press Release",
                "slug" => "press-release",
                "status" => 1,
                "deleted_at" => NULL,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 3,
                "title" => "Digital Marketing",
                "slug" => "digital-marketing",
                "status" => 1,
                "deleted_at" => NULL,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 4,
                "title" => "Technology",
                "slug" => "technology",
                "status" => 1,
                "deleted_at" => NULL,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
        );

        Category::insert($categories);
    }
}
