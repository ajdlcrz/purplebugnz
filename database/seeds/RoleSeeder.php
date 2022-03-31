<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = array(
            array(
                "id" => 1,
                "name" => "admin",
                "modules" => "[{\"name\":\"homepage\",\"url\":\"homepage\",\"icon\":\"homepage.png\"},{\"name\":\"about-us\",\"url\":\"about-us\",\"icon\":\"about-us.png\"},{\"name\":\"products-&-services\",\"url\":\"services\",\"icon\":\"prod-services.png\"},{\"name\":\"blogs\",\"url\":\"blogs\",\"icon\":\"blogs.png\"},{\"name\":\"careers\",\"url\":\"careers\",\"icon\":\"careers.png\",\"sub_pages\":[\"applicants\",\"jobs\"]},{\"name\":\"our-teams\",\"url\":\"our-teams\",\"icon\":\"our-teams.png\"},{\"name\":\"contact-us\",\"url\":\"contact-us\",\"icon\":\"contact-us.png\"},{\"name\":\"insights\",\"url\":\"insights\",\"icon\":\"blogs.png\"},{\"name\":\"influencers\",\"url\":\"influencers\",\"icon\":\"our-teams.png\"}]",
                "description" => "Administrator",
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 2,
                "name" => "HR",
                "modules" => "[{\"name\":\"careers\",\"url\":\"careers\",\"icon\":\"careers.png\",\"sub_pages\":[\"applicants\",\"jobs\"]}]",
                "description" => "Human Resources",
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 3,
                "name" => "marketing",
                "modules" => "[{\"name\":\"blogs\",\"url\":\"blogs\",\"icon\":\"blogs.png\"},{\"name\":\"insights\",\"url\":\"insights\",\"icon\":\"blogs.png\"},{\"name\":\"influencers\",\"url\":\"influencers\",\"icon\":\"our-teams.png\"}]",
                "description" => "Marketing",
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
        );

        Role::insert($roles);
    }
}
