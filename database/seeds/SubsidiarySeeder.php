<?php

use App\Subsidiary;
use Illuminate\Database\Seeder;

class SubsidiarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subsidiaries = array(
            array(
                "id" => 1,
                "title" => "Tea and Coffee Depot",
                "body" => "Established in 2016, Tea and Coffee Depot was launched to provide tea and coffee lovers easier, and a more convenient way of buying and enjoying their much-needed caffeine fix and brewing essentials.",
                "link" => "https://teaandcoffeedepot.com/",
                "image" => "60481e8d2d9cdtcd_image.jpg",
                "alt_text" => "tcd-image",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 2,
                "title" => "Up Dog: The Adventures of Cedric and Josh",
                "body" => "Up Dog: The Adventures of Cedric and Josh is a mobile game application that exhibits the flying skills and life story of the main character named Cedric. Up Dog also illustrates the daily lives of Cedric, Josh, and the rest of the people in the neighborhood.",
                "link" => "http://updogadventures.com/",
                "image" => "60481e94f1099updog_image.jpg",
                "alt_text" => "updog-image",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 3,
                "title" => "MyDoctorFinder",
                "body" => "MyDoctorFinder is a web platform that provides a listing of doctors, hospitals, clinics, and pharmacies in the Philippines. Through MyDoctorFinder, you can now search 25,000+ health care providers based on their specialization and location.",
                "link" => "https://mydoctorfinder.com/",
                "image" => "60481e9d77a68mdf_image.jpg",
                "alt_text" => "mdf-image",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 4,
                "title" => "Beauty and Wellness Haven",
                "body" => "Beauty and Wellness Haven was established in 2018 to cater to the growing e-commerce industry in the Philippines. Its mission is to promote an easy and convenient experience to its customers when it comes to shopping online.",
                "link" => "https://beautyandwellnesshaven.com/",
                "image" => "60481ea53c295bwh_image.jpg",
                "alt_text" => "bwh-image",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 5,
                "title" => "Mom and Baby Hub",
                "body" => "Mom and Baby Hub is an electronic commerce platform developed by PurpleBug that is dedicated to products suitable for pregnant women and babies. It aims to promote a relaxing and hassle-free experience when it comes to online shopping.",
                "link" => "https://momandbabyhub.com/",
                "image" => "60481eabaa196mbh_image.jpg",
                "alt_text" => "mbh-image",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 6,
                "title" => "After Hours",
                "body" => "After Hours is a Philippine-based online platform and social media website, which features memes, relatable contents, and daily ramblings.",
                "link" => "https://www.facebook.com/AfterHoursPhilippines",
                "image" => "60481eb15fd9aafter_hours_image.jpg",
                "alt_text" => "after-hours-image",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 7,
                "title" => "Business Partner On Air",
                "body" => "Business Partner On Air is a radio program (DZRJ 100.3) about business related topics.",
                "link" => "https://www.facebook.com/BusinessPartnerOnAir/",
                "image" => "602b2a5ca49ebbpa_image.jpg",
                "alt_text" => "bpa-image",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 8,
                "title" => "Running Organgs",
                "body" => "<p>An exciting and addicting mobile game application that features the members of the Running Organgs traveling through the most famous tourist destinations in the Philippines, while avoiding each of their most feared enemies.</p>",
                "link" => "https://www.facebook.com/runningorgangs",
                "image" => "60481ecf2bb52ro_image.jpg",
                "alt_text" => "ro-image",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 12,
                "title" => "Granny's Health Corner",
                "body" => "<p>Granny&rsquo;s Health Corner aims to help consumers who have no time to go out. Your medical and health supplies are just a few clicks away from being on your doorstep.</p>",
                "link" => "https://www.facebook.com/Grannys-Health-Corner-100562398298768/",
                "image" => "6048280b55115grannys_health.jpg",
                "alt_text" => "grannys-health",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 11,
                "title" => "Zagidee",
                "body" => "<p>Zagidee is a customer-oriented, cost-effective, and reliable email marketing solution by PurpleBug&reg; that caters to SMEs and other businesses in the Philippines and worldwide.</p>",
                "link" => "https://www.facebook.com/zagidee",
                "image" => "60481e7da0ecczagidee_image.jpg",
                "alt_text" => "zagidee-image",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 14,
                "title" => "First Time Moms",
                "body" => "<p>First-Time Moms is a Facebook group meant to help new moms on their journey to motherhood. It is a safe, cozy, and non-judgmental space where first-time moms can find advices ranging from pregnancy, mom hacks, parenting hacks, tips on how to survive the first-time mom life, and more.</p>",
                "link" => "https://www.facebook.com/groups/393963965143663",
                "image" => "6048280bb14d4first_time_moms.jpg",
                "alt_text" => "first-time-moms",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 17,
                "title" => "Moms for Moms",
                "body" => "<p>Moms for Moms is a community of parents helping other parents, especially first-time moms. Discover parenting tips, childcare news, and lifestyle trends that moms need to know. This is the modern mother&rsquo;s all-in-one guide and support group where they can share thoughts and experiences.</p>",
                "link" => "https://www.facebook.com/MomsForMomsPhilippines",
                "image" => "6048280cc4e00moms_for_moms.jpg",
                "alt_text" => "moms-for-moms",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
        );

        Subsidiary::insert($subsidiaries);
    }
}
