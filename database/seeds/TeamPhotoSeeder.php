<?php

use App\TeamPhoto;
use Illuminate\Database\Seeder;

class TeamPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $team_photos = array(
            array(
                "id" => 17,
                "image" => "1581581723976.JPEG",
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 16,
                "image" => "elai.JPEG",
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 15,
                "image" => "IMG_4897.jpg",
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 14,
                "image" => "IMG_6472.JPG",
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 12,
                "image" => "viber_image_2020-01-22_14-33-14.jpg",
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 13,
                "image" => "PB Happy.jpg",
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 18,
                "image" => "25348331_10210418333560154_6859335946249816529_n.jpg",
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 19,
                "image" => "24774796_10210362578606315_5068959208266906810_n.jpg",
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 20,
                "image" => "22815140_10210058038352999_4964594501655194981_n.jpg",
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 21,
                "image" => "22228155_10209909959891130_5137764144006713892_n.jpg",
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 22,
                "image" => "21761584_10209815562891264_4284335329707163770_n.jpg",
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 23,
                "image" => "20171013_153519.jpg",
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
        );

        TeamPhoto::insert($team_photos);
    }
}
