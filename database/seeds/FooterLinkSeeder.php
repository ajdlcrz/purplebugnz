<?php

use App\FooterLink;
use Illuminate\Database\Seeder;

class FooterLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $footer_links = array(
            array(
                "id" => 1,
                "title" => "About Us",
                "url" => "https://purplebug.net/about-us",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 2,
                "title" => "Services",
                "url" => "https://purplebug.net/services",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 3,
                "title" => "Careers",
                "url" => "https://purplebug.net/careers",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 4,
                "title" => "Blogs",
                "url" => "https://purplebug.net/blogs",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 5,
                "title" => "Contact Us",
                "url" => "https://purplebug.net/contact-us",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
        );

        FooterLink::insert($footer_links);
    }
}
