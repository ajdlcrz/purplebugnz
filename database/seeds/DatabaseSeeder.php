<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            CareerSeeder::class,
            CategorySeeder::class,
            ContentSeeder::class,
            FooterLinkSeeder::class,
            PartnerSeeder::class,
            RoleSeeder::class,
            ServiceSeeder::class,
            SubsidiarySeeder::class,
            TeamSeeder::class,
            TeamPhotoSeeder::class,
            TestimonialSeeder::class,
        ]);

        \App\User::create([
            'role_id' => 1,
            'name' => 'PurpleBug',
            'email' => 'admin@purplebug.net',
            'department' => 'IT Department',
            'password' => bcrypt('admin123456pb')
        ]);

        foreach (\App\Blog::get() as $blog) {
            \App\Insight::create([
                'title' => $blog->title,
                'banner' => $blog->banner,
                'alt_text' => $blog->alt_text,
                'seo' => $blog->seo,
                'details' => '<p>Study # 1:<br />Digital Marketing and COVID-19<br />Summary:<br />This report illustrates the findings of PurpleBug&rsquo;s very own social listening service, Online Reputation &amp; Sentiments Management or ORSM, on COVID-19. It also offers a discussion on several key brands that have gone viral during the lockdown: What have they done in capturing the attention of quarantined Filipinos. Lastly, the report offers insights on the next steps in relation to the much anticipated &ldquo;New Normal&rdquo; once the lockdown is relaxed.<br />Publish Date: May 2020</p>
                 <p>Study #2:<br />CONSUMER PURCHASING BEHAVIOR: Pre/During/After COVID-19<br />Summary:<br />This report is centered around people&rsquo;s purchasing behavior, taking into consideration the influence of the still ongoing COVID-19 pandemic that has forced them to stay at home for months and months. It includes the presentation of the results of an in-house survey done by PurpleBug, delving deeper into Filipino consumers&rsquo; purchase behavior and psyche as affected by the COVID-19 pandemic. The report tackles into detail their spending habits, perceptions, and purchase channel preferences.<br />Publish Date: July 2020</p>
                 <p>Study #3:<br />HOW THE PANDEMIC HAS CHANGED MEDIA CONSUMPTION IN THE PHILIPPINES<br />Summary:<br />This report illustrates how the media consumption of Pinoys have changed because of the COVID-19 pandemic. It specifically covers the changes in their access methods &nbsp;to the internet: pre vs. during quarantine. It also tackles their platform-specific media consumption (Facebook, Twitter, Instagram, Youtube, TikTok, Snapchat, Spotify) as well as their interest-specific media consumption (news, learning, social media, movies, gaming).<br />Publish Date: January 2021</p>
                 <p>Study #4:<br />E-COMMERCE &amp; THE FILIPINO CONSUMER<br />Summary:<br />This report covers the general behavior of Pinoy online shoppers in terms of their main reasons for shopping online, budget limitations, and shop biases. There is also a thorough discussion on the general behavior of non-online shoppers, particularly on why don&rsquo;t shop online and what will make them shop online. Lastly, this report also presents key insights concerning the activities of Pinoy shoppers before adding to their carts and after making their purchases.<br />Publish Date: July 2021</p>',
                'created_at' => $blog->created_at,
            ]);
        }

        /*
        factory(App\Category::class, 5)->create();
        factory(App\Partner::class, 2)->create();
        factory(App\Service::class, 10)->create();
        factory(App\Subsidiary::class, 10)->create();
        factory(App\Team::class, 10)->create();
        factory(App\Blog::class, 20)->create();
        factory(App\Testimonial::class, 20)->create();
        factory(App\Career::class, 10)->create();
        factory(App\User::class, 10)->create();
        factory(App\Applicant::class, 10)->create();
        factory(App\Insight::class, 10)->create();
        */
    }
}
