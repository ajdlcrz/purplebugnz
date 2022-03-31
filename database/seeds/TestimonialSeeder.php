<?php

use App\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $testimonials = array(
            array(
                "id" => 1,
                "service_id" => 1,
                "image" => "602a3b085c099bow.jpg",
                "name" => "Bow",
                "position" => "Wow",
                "body" => "<p>The content maps are okay and great! Good job to the Purple Bug Team!</p>",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 8,
                "service_id" => 2,
                "image" => "6098dba53a5a1true_value.png",
                "name" => "True Value",
                "position" => "Carlo Cadorniga - Marketing Manager",
                "body" => "<p>\"PurpleBug is really good at what they do, and I am glad to have stayed with them all these years. The team really goes the extra mile. It's as if the guys are right here with me in the office. Keep on innovating, guys!\"</p>",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
        );

        Testimonial::insert($testimonials);
    }
}
