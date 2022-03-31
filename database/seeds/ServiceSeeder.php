<?php

use App\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = array(
            array(
                "id" => 1,
                "title" => "Social Media Management",
                "slug" => "social-media-management",
                "description" => "<p style=\"text-align: left;\">We have the experience and expertise. PurpleBug crafts relevant and effective digital marketing solutions to strengthen your business presence and activity in the world of social media.</p>",
                "banner" => "social_media_management.jpg",
                "alt_text" => "social-media-management",
                "offers" => "[{\"id\":\"rioglry60\",\"heading\":\"Up-to-date Content Development Strategies\",\"body\":\"<p>The digital world evolves fast. Our strategists ensure that our social media marketing strategies are up-to-date and will stay effective through the changing times. Hence, we stay on top of the trends and deliver exceptional results.<\\/p>\"},{\"id\":\"tuzbpvt4b\",\"heading\":\"Alignment to Business Objectives\",\"body\":\"<p>We believe that content should meet your brand&rsquo;s purpose. It should be able to connect you with your customers the way you want it to. Whether it's boosting brand awareness, engaging with customers, gaining leads, or building a strong online presence, your social media content should always fulfill your business objectives.<\\/p>\"},{\"id\":\"2boduhggv\",\"heading\":\"Engaging Content\",\"body\":\"<p>Brand loyalty is very important for your company; hence it is important that your customers to feel connected to your brand. Our way of creating &ldquo;thumb stopper&rsquo; content is addressing your target consumers&rsquo; needs and wants. Engaging social media content means telling a great story and to telling it well.&nbsp;<\\/p>\"},{\"id\":\"cm6fimwce\",\"heading\":\"Aligned Branding\",\"body\":\"<p>Your brand is your promise to your customers. We understand that brand alignment is crucial to delivering consistent messaging and brand perception. When it comes to branding, we ensure that we develop content tailored to your company's values, objectives, beliefs, mission, and vision.&nbsp;<\\/p>\"},{\"id\":\"93a6ub1tt\",\"heading\":\"Measurable Results\",\"body\":\"<p>Measuring the results of your social media efforts can help you understand what adjustments you need to do. It can also help you better reassess campaign strategies depending on your goals. This, in turn, will positively affect the overall campaign.<\\/p>\"}]",
                "facts" => "<ul>\n<li>Almost all marketers use social media for their business, making it the most popular form of B2B marketing tactic. It is also efficient in getting leads, with more than half of marketers saying that social media increased their sales online. This is a combination of blogging, organic search, and paid search.&nbsp;</li>\n<li>Your social media followers aren&rsquo;t the only ones talking about your brand. 96 percent of social media users that talk about you, don&rsquo;t even follow your brand&rsquo;s social media profile.</li>\n</ul>",
                "seo" => "{\"meta_title\":\"Social Media Management | Digital Services | Purplebug\",\"meta_description\":\"Aside from its search engine optimization services, PurpleBug aims to be one of the best social media marketing companies in the Philippines by being the social media provider of several brands. Its social media management services consist of content creation, online advertising, and more.\",\"meta_keywords\":\"Social Media Management, Digital Services, Purplebug\"}",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 2,
                "title" => "Website and App Development",
                "slug" => "website-and-app-development",
                "description" => "<p>PurpleBug provides website and app development services, creating sites tailor-fitted to your needs and brand image.&nbsp;</p>",
                "banner" => "website_and_app_development.jpg",
                "alt_text" => "website-and-app-development",
                "offers" => "[{\"id\":\"84wo72i73\",\"heading\":\"Tailor-Made and Complete Elements\",\"body\":\"<p>Just like suits made to order, we believe that your brand deserves a tailor-fitted website that will suit your requirements and image. We build websites from scratch &ndash; an expertise we are very proud of. You need a customized website to highlight yourself from the market so customers can easily identify your brand.<\\/p>\"},{\"id\":\"u6qisva3k\",\"heading\":\"User-Friendly Navigation\",\"body\":\"<p>One of the most important elements for a great website is having a user-friendly navigation. A well-defined navigation route throughout your website helps your visitors locate your services and products, ensuring better customer experience and a higher conversion rate.&nbsp;<\\/p>\"},{\"id\":\"3jc276e28\",\"heading\":\"Eye-Catching Web Design and Layout\",\"body\":\"<p>PurpleBug takes pride in its outstanding creativity and skill to discern the right combination of visual images, content, and fitting tools to create for your website. We design websites according to your brand&rsquo;s image, while keeping it secure with a quality user interface and natural navigation.<\\/p>\"},{\"id\":\"km9xlwut1\",\"heading\":\"Effective Calls to Action\",\"body\":\"<p>A great website should allow users to easily reach a company&rsquo;s desired call to action. We understand that by placing calls to action strategically throughout your website can increase the number of users that turn into actual buyers. With our website and app development services, will equip your brand&rsquo;s online home with attention-grabbing, accessible, and easy to read calls to action to meet your desired results.&nbsp;<\\/p>\"},{\"id\":\"cs7sek89q\",\"heading\":\"Powerful Storytelling\",\"body\":\"<p>A website serves as a brand&rsquo;s online home. This is why your website should instantly tell your visitors who you are, what you do, and why they should avail of your services. The key is to have a clear and customer-oriented content to help you identify yourself apart from the saturated market and gain more leads.&nbsp;<\\/p>\"}]",
                "facts" => "<ul>\n<li>Texts attract more attention than pictures when building a website. Users will simply scan photos on a website and are more likely to look for useful information about your brand. Hence, it is more effective to use texts if you want to get a point across.</li>\n<li>&nbsp;It is more effective to place your ads on the top or left part of your website because they are in the &ldquo;viewing pattern.&rdquo;</li>\n</ul>",
                "seo" => "{\"meta_title\":\"Development | Digital Services | PurpleBug\",\"meta_description\":\"PurpleBug creates custom websites and applications based on client's needs. Contact Us and start your Business Online.\",\"meta_keywords\":\"Development,Digital Services,PurpleBug\"}",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 3,
                "title" => "Digital Ads",
                "slug" => "digital-ads",
                "description" => "<p>Ads that connect. Ads that deliver. PurpleBug makes sure you effectively spend the advertising budget on suitable digital media placements, ensuring you reach your actual market and generate measurable results.&nbsp;</p>",
                "banner" => "digital_ads.jpg",
                "alt_text" => "digital-ads",
                "offers" => "[{\"id\":\"cimqmysa2\",\"heading\":\"Targeted Ads\",\"body\":\"<p>At PurpleBug, we only target your ads to qualified audiences for your products and services. We make sure to have your brand highlighted and your content marketing considered by your target consumers at every stage of the buying cycle. Our expertise of maximizing social media channels such as Facebook, Twitter, Instagram, or YouTube benefits you with flexible and effective options.&nbsp;<\\/p>\"},{\"id\":\"cf1locjyy\",\"heading\":\"Flexibility Across Channels\",\"body\":\"<p>Digital ads&rsquo; key to success is being &ldquo;multi-channeled.&rdquo; With digital advertising, your message can reach thousands and even millions of your target audiences through multiple platforms. This strategy allows customers to see your content they way you want them to, boosting your marketing tactics.<\\/p>\"},{\"id\":\"hbtiy9xhp\",\"heading\":\"Measurable Data\",\"body\":\"<p>We develop our marketing strategies based on detailed data. In order to ensure we are giving you topnotch digital marketing services; we immediately measure results after each campaign. These measurements allow us to use digital ads budget efficiently, improve conversion rates, choose the right channels, plan more effective campaigns, and improve your business&rsquo; return of investment.<\\/p>\"},{\"id\":\"ef9uj7dcq\",\"heading\":\"Massive Reach and Engagement\",\"body\":\"<p>As people are starting to watch TV less, customers are now mostly online so you should be, too. Through our digital ads services, we can help you gain access to a global audience reach your target consumers on the go, wherever they are, whenever they are online.&nbsp;<\\/p>\"},{\"id\":\"m9w1w836k\",\"heading\":\"Top-of-Mind Awareness\",\"body\":\"<p>Digital ads have a major advantage when it comes to top-of-mind awareness as it is the initial step for building brand loyalty and product preferences. We carry out digital advertising campaigns effectively &ndash; bridging buyer and seller. This is why our clients have built stronger connection and relationships with their customers.&nbsp;<\\/p>\"}]",
                "facts" => "<ul>\n<li>You have 70% more chance of converting users into potential customers when you retarget your digital ads&rsquo; target audience. Retargeting those users who have previously visited your page again creates more opportunity for your products and services to become more recognizable to those who are close to completing a purchase. Hence increasing your profit.</li>\n<li>A more accurate way of determining the success of your digital ads is through measuring their click-through rates. Since the main goal of digital ads is to generate impressions, this is far more beneficial in measuring their performance as it is focused on driving sales.&nbsp;</li>\n</ul>",
                "seo" => "{\"meta_title\":\"Digital Ads | Digital Services | PurpleBug\",\"meta_description\":\"PurpleBug offers various Digital Ads strategies for our clients. We provide in depth analysis and help our clients in choosing the right platform and targeting based on campaign's objectives.\",\"meta_keywords\":\"Digital Ads,Digital Services,PurpleBug\"}",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 4,
                "title" => "Chatbot Development",
                "slug" => "chatbot-development",
                "description" => "<p>Effortless, automated conversations. PurpleBug offers a strategic and cost-efficient online customer service solution that is able to automate repetitive tasks, delivering value faster to your customers.&nbsp;</p>",
                "banner" => "chatbot_development.jpg",
                "alt_text" => "chatbot-development",
                "offers" => "[{\"id\":\"ba6qy6evl\",\"heading\":\"Inbox Automation\",\"body\":\"<p>Our Chatbot Development services lets you automate your overflowing inbox. You won&rsquo;t need to worry about spending hours answering inquiries, your chatbot can do it for you! We make sure to provide you with a well-built chatbot so you can answer up to 80% of your customers&rsquo; routine questions.&nbsp;<\\/p>\"},{\"id\":\"1yxy1ue2z\",\"heading\":\"Higher Rates of Customer Conversion\",\"body\":\"<p>Once you have a chatbot for your business, it is guaranteed that you will have higher rates of customer conversion. Chatbots are a smart addition to your business since they ask qualifying questions based on the answers they receive, and will provide relevant information back. This in turn speeds up the time it will take for a customer to complete a purchase, increasing the conversion rate.&nbsp;<\\/p>\"},{\"id\":\"86o4x06qh\",\"heading\":\"Improved Customer Service\",\"body\":\"<p>Chatbots are one major way on how you can increase customer satisfaction. To keep up with the fast-paced industry, you want to be able to immediately respond to your customers&rsquo; simple queries. With improved communication, they allow your customers to easily get to know your brand through stimulated conversations.&nbsp;<\\/p>\"},{\"id\":\"stism0fae\",\"heading\":\"Personalized and Engaging Conversations\",\"body\":\"<p>We develop our chatbots to provide real-time assistance to your customers. We offer interactive communication where our chatbots can also ask questions to understand your customers&rsquo; real problems. We understand that it Is important to keep your customers fully engaged with your brand. That is why our chatbots can also offer your customers rich content such as product pages, blogs, images, and the like to further help your customers.&nbsp;<\\/p>\"},{\"id\":\"n7fi8j707\",\"heading\":\"24\\/7 Customer Support\",\"body\":\"<p>Customer service is the most important factor to your business&rsquo; success. It is a requirement to have good customer service 24\\/7 to greatly boost your customer satisfaction. Since chatbots don&rsquo;t need to sleep, they are capable of giving instant replies to your customers 24\\/7. With chatbots, you can save time and costs, streamlining your business&rsquo; operations.&nbsp;<\\/p>\"}]",
                "facts" => "<ul>\n<li>63 percent of customers would consider interacting with a business&rsquo; chatbot to obtain quick answers.&nbsp;</li>\n<li>&nbsp;Consumers loathe bad chatbot experience. Customers wouldn&rsquo;t use a company&rsquo;s chatbot after a bad experience. They also find it more frustrating if a business&rsquo; chatbot couldn&rsquo;t answer their queries vs. a human.</li>\n</ul>",
                "seo" => "{\"meta_title\":\"Chatbot Automation | Digital Services | PurpleBug\",\"meta_description\":\"Effortless, automated conversations. PurpleBug offers a strategic and cost-efficient online customer service solution that is able to automate your business queries.\",\"meta_keywords\":\"Chatbot Automation,Digital Services,PurpleBug\"}",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 5,
                "title" => "Search Engine Optimization",
                "slug" => "search-engine-optimization",
                "description" => "<p>Better visibility. Increased brand activity. PurpleBug combines on-page and off-page search engine optimization services and activities to further improve your company's search engine results page and site rankings.</p>",
                "banner" => "search_engine_optimization.jpg",
                "alt_text" => "search-engine-optimization",
                "offers" => "[{\"id\":\"vz2af4sni\",\"heading\":\"Organic Search\",\"body\":\"<p>Organic search is most often the main source of website traffic. At PurpleBug, we ensure that your brand is easily found by search engines through regular and organic search. Our efforts of maintaining your brand on top of the rankings leads to higher chances of users clicking links related to you, leading to higher organic website traffic.<\\/p>\"},{\"id\":\"x5lo6b9yy\",\"heading\":\"Increased Engagement, Quality Traffic and Conversions\",\"body\":\"<p>Search engines&rsquo; organic rankings are based entirely on its algorithm, which determines the best results for any query. This means that once your business&rsquo; website is deemed worthy by search engines such as Google and Yahoo!, you will continue to attract traffic for years.&nbsp;<\\/p>\"},{\"id\":\"qancdm836\",\"heading\":\"Credibility\",\"body\":\"<p>As a quality SEO service provider, we establish a strong foundation for websites with a clean and efficient user experience. We provide complete elements that builds your authority in popular search engines such as quality backlinks, positive user behavior, and optimized on-page elements and content.<\\/p>\"},{\"id\":\"dg1w5wcyh\",\"heading\":\"Improved User Experience\",\"body\":\"<p>Quality SEO includes a positive user experience. PurpleBug understands the complex algorithms of popular search engines such as Google and Yahoo!. Few realize that to have better organic ranking and search results visibility, a website should be user-friendly. This is because search engines interpret whether users have favorable or unfavorable experience with a website. Your customers need to find what they are looking for. If they can&rsquo;t, your website&rsquo;s performance will suffer.<\\/p>\"},{\"id\":\"ragmrwu44\",\"heading\":\"Cost Management\",\"body\":\"<p>Inbound leads lower the cost of lead generation by a significant amount vs. outbound leads. With quality SEO, you won&rsquo;t need to keep spending to continuously attract quality traffic to your website. SEO also lowers advertising cost. Unlike PPC ads which involve a cost every time a user clicks and visits your page, quality SEO secures your valuable spot in the search results page free of charge. Your website will continue to stay above the SERP as long as users click your search links.<\\/p>\"}]",
                "facts" => "<ul>\n<li>Meta titles are the single most important on-page element that has the most impact on your website&rsquo;s SEO performance. These clickable elements direct your target audience to your website and landing page. In less than 55 characters, you should already let users and search engines know how relevant your website is for a particular topic.</li>\n<li>&nbsp;According to Forbes, 93% of all online activities start with a search engine. People highly rely on the internet for almost all of their daily needs for information. It is no surprise that almost all online activities also begin with search engines.</li>\n</ul>",
                "seo" => "{\"meta_title\":\"Search Engine Optimization | Digital Services | PurpleBug\",\"meta_description\":\"SEO requires digital marketing expertise, web design and development, and more. Let PurpleBug boost your brand's seo with its team of seo experts.\",\"meta_keywords\":\"Search Engine Optimization,Digital Services,PurpleBug\"}",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 6,
                "title" => "Digital Regional News Network",
                "slug" => "digital-regional-news-network",
                "description" => "<p>We help brands connect to the provinces. PurpleBug delivers relevant, results-oriented, and cost-effective online PR services to your company through our Digital Regional News Network service.&nbsp;</p>",
                "banner" => "digital_regioanl_news_network.jpg",
                "alt_text" => "digital-regioanl-news-network",
                "offers" => "[{\"id\":\"wsauvh4aj\",\"heading\":\"Targeted Localized Content\",\"body\":\"<p>PurpleBug allows you to connect to a network of regional newspapers, allowing you to benefit from targeted localized content and diversified creatives options. We personalize and adjust your content to the culture of your target audience, creating sensible value for them.<\\/p>\"},{\"id\":\"nbsx5xofg\",\"heading\":\" Effective Content Creation and Direction\",\"body\":\"<p>We establish specific directions for content. We plan, understand your consumer funnel, and create stories. As content strategists, we understand how to tell your stories. Our extensive knowledge also lets us know which stories work well with distinct situations.&nbsp;<\\/p>\"},{\"id\":\"zk0knc9qb\",\"heading\":\" Cost-Efficient Local Advertising\",\"body\":\"<p>The cheapest way to advertise your small business depends on a number of factors. These factors include the profiles of audience you are trying to reach, their locations, audience size, and your ads&rsquo; designs. With local advertising, you are able to target a specific demographic and target your ad to a specific age or occupation. This ensures that potential clients will always find you, no matter what your market&rsquo;s niche is.&nbsp;<\\/p>\"},{\"id\":\"rmk92mf7z\",\"heading\":\"Strategies Based on Local Trends\",\"body\":\"<p>We understand that location is one of the most reliable ways to view an audience. This is because their mindsets, intentions, and concerns are different for each region. By looking at trends data by region, you can spot differences and uncover new opportunities.<\\/p>\"},{\"id\":\"mmtu2up9b\",\"heading\":\"Improved Engagement\",\"body\":\"<p>PurpleBug lets you engage with your community by giving residents the opportunity to leave feedback and testimonials on local directories and your company&rsquo;s social media pages. Having positive referrals will not only encourage more clients to use your products\\/services but will establish your business as a recognized name in the town or city<\\/p>\"},{\"id\":\"twlwgi4gf\",\"heading\":\"Manual Results Analysis\",\"body\":\"<p>PurpleBug also tracks campaign performances through manual monitoring of the newspapers&rsquo; output. We also create a campaign report and analysis to further understand which campaigns worked. These reports and analyses serve as the foundation of our campaigns, making them effective and beneficial for your business.&nbsp;<\\/p>\"}]",
                "facts" => "<ul>\n<li>Advertising in newspapers is considered the most believable and trustworthy than any other form of media. This is because print media is always the primary choice when it comes to seeking reliable information.&nbsp;</li>\n</ul>",
                "seo" => "{\"meta_title\":\"Digital Regional News Network | Digital Services | PurpleBug\",\"meta_description\":\"PurpleBug have network of regional newspaper companies that delivers results oriented and cost effective pr services to your company.\",\"meta_keywords\":\"Digital Regional News Network,Digital Services,PurpleBug\"}",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 7,
                "title" => "Influencer Circle",
                "slug" => "influencer-circle",
                "description" => "<p>Right information. Right people. Right message. PurpleBug delivers relevant, results-oriented, and cost-effective influencer marketing and online PR services for your company.&nbsp;</p>",
                "banner" => "influencer_circle.jpg",
                "alt_text" => "influencer-circle",
                "offers" => "[{\"id\":\"4bqxcdcs3\",\"heading\":\"Improved Brand Awareness\",\"body\":\"<p>Influencer marketing greatly expands your reach and brand positioning. Your target audience will begin to know more about you, who you are, your story, and the products you offer. During this time of crisis, consumers are actively seeking information relevant to their needs, most often if they&rsquo;re planning on making a potential purchase. These said, influencers play a big part in brand awareness, which takes up the widest part in the sales funnel. PurpleBug lets you work with social media influencers who can execute a wide variety of marketing activities such as giveaways and product seeding to create brand awareness.<\\/p>\"},{\"id\":\"ulnokhs6l\",\"heading\":\"Increased Credibility\",\"body\":\"<p>Let authentic and reliable people talk about your brand and have them share your message through their experiences. An influencer&rsquo;s opinions evoke a strong degree of credibility and confidence from friends and followers. This is because people follow influencers for inspirations and trust their recommendations. By having an influencer advertise your brand, you'll gain your target customers&rsquo; attention, and put your message in front of an actively engaged audience.&nbsp;<\\/p>\"},{\"id\":\"hoslet47f\",\"heading\":\"Quicker Customer Acquisition\",\"body\":\"<p>We have a wide variety of influencers for different niches. Working with influencers with particular niches that are aligned with your brand lets you communicate your message to relevant audiences. We value focus and relevance for your brand, which are the keys to influencer marketing.<\\/p>\"},{\"id\":\"4avqbtl8v\",\"heading\":\"Targeted Marketing\",\"body\":\"<p>Interest is across different locations. Leverage on regional behavior when customizing and optimizing your campaign to be more relatable to your audiences. Our list of influencers lets you reach your customers with the language and dialects that they speak &ndash; whether in the form of exciting stories from content creators or informational articles from reputable local news sources.&nbsp;<\\/p>\"},{\"id\":\"kwxepvho4\",\"heading\":\"Winning Partnerships\",\"body\":\"<p>Influencers have strong brand relationships based on purchase history and positive brand affinity. Connecting and engaging with an influencer can be the start of a powerful relationship. Your brand&rsquo;s connection to influencers makes way for possible joint-ventures, live events, continuous recommendations to their fans, and other more long-term opportunities.&nbsp;<\\/p>\"}]",
                "facts" => "<ul>\n<li>More than half of social media influencers worldwide use Instagram as their main social platform for brand collaboration. One of the primary reasons why influencer marketing succeeds on Instagram is because social media influencers can connect with their target audience on a more personal level.&nbsp;</li>\n</ul>",
                "seo" => "{\"meta_title\":\"Influencer Circle | Digital Services | PurpleBug\",\"meta_description\":\"PurpleBug offers Influencse Circle as part of our holistic strategy. We can help you choose the right influencers and content creators that can represent your Business online and endorse your brand in the right platform and targeting.\",\"meta_keywords\":\"Influencer Circle,Digital Services,PurpleBug\"}",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 8,
                "title" => "Online Reputation and Sentiments Management",
                "slug" => "online-reputation-and-sentiments-management",
                "description" => "<p>We listen, we communicate, we monitor. PurpleBug uses tools to provide you real insights that will keep your digital communication channels healthy and spotless.&nbsp;</p>",
                "banner" => "online_reputation_sentiments_management.jpg",
                "alt_text" => "online-reputation-sentiments-management",
                "offers" => "[{\"id\":\"58aebxa4c\",\"heading\":\" Keyword Research & Analysis\",\"body\":\"<p>Keyword research and analysis are the blueprint for your online marketing efforts, driving every decision you make. We know which relevant keywords lead customers to your site. We can drive quality traffic, sales, and an ROI to your page to connect you to potential customers.&nbsp;<\\/p>\"},{\"id\":\"1xdui4hct\",\"heading\":\"Valuable Sentiment Segregation\",\"body\":\"<p>Understanding people&rsquo;s emotions is essential for your business since customers are able to express their thoughts and feelings about your brand more openly than ever before. By automatically analyzing customer feedback from survey responses to social media conversations, we are able to listen attentively to your customers. Based on these, we can help you tailor your products and services to meet your customers&rsquo; needs.<\\/p>\"},{\"id\":\"s2ql580vn\",\"heading\":\"Streamlined and Complete Brand Monitoring\",\"body\":\"<p>PurpleBug&rsquo;s Online Reputation and Sentiments Management service covers brand monitoring through tools and manual checking, content discovery, competitor research, influencer marketing, and insights from web and social media platforms. Once sentiments have been properly categorized, we will carefully formulate each response and sentiment to address all issues to maintain your brand&rsquo;s spotless online reputation.<\\/p>\"},{\"id\":\"3bp5ufzy3\",\"heading\":\"Spotless Brand Image\",\"body\":\"<p>We make it our goal to rid your brand of negative sentiments online as we understand that these can greatly affect your brand&rsquo;s customer loyalty. At PurpleBug, we value your brand&rsquo;s hard-earned respect and trust, helping you build a perfect brand image. We constantly monitor the responses to any form of communication online to help you create the image your company deserves.&nbsp;<\\/p>\"},{\"id\":\"uxjuoqpxr\",\"heading\":\"Increased Sales\",\"body\":\"<p>A brand that is advocated by real people online and has great online reputation eliminates the doubts that can ruin the completion of a purchase. Online reviews have greatly affected consumer decision-making process over the years. At the same time, social media has been taken over by users who affect your potential customers with their opinions and recommendations, greatly impacting the trends in demand for your products.&nbsp;<\\/p>\"}]",
                "facts" => "<ul>\n<li>88 percent of consumers trust online reviews as much as they trust a personal recommendation from somebody they know.&nbsp;</li>\n<li>Consumers consider reviews more than discounts and price information.</li>\n</ul>",
                "seo" => "{\"meta_title\":\"Online Reputation and Sentiments Management | Digital Services | PurpleBug\",\"meta_description\":\"Online Reputation and Sentiments Management | Digital Services | PurpleBug\",\"meta_keywords\":\"Online Reputation and Sentiments Management, Digital Services, PurpleBug\"}",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
            array(
                "id" => 9,
                "title" => "Creatives Development",
                "slug" => "creatives-development",
                "description" => "<p>Your most reliable partner in developing digital content. PurpleBug&rsquo;s Creatives Development service promotes innovative digital content focused on providing graphics design support for your business.</p>",
                "banner" => "creatives_development.jpg",
                "alt_text" => "creatives-development",
                "offers" => "[{\"id\":\"0hb4bqm0u\",\"heading\":\"Increased Visibility\",\"body\":\"<p>People prefer visual content over plain text. Content with images gets more views plain text posts. With this, having a unique way to market your brand&rsquo;s products or services will make you stand out among your competitors. Moreover, effective visuals that cater to the purchase motivators of your target audience has great potential of drawing in new customers and keeping your brand successful.<\\/p>\"},{\"id\":\"f3hllw7at\",\"heading\":\"Improved Storytelling\",\"body\":\"<p>Social media posts accompanied by effective creatives are powerful mediums in a way that they influence customers&rsquo; subconscious responses. Well thought out creatives have the ability to communicate your brand&rsquo;s mission, vision, and goals. They also have the ability to attract empathy, an emotional response that connects your brand to your target consumers.&nbsp;<\\/p>\"},{\"id\":\"vpnf7j4c4\",\"heading\":\"Enhanced Brand Recognition\",\"body\":\"<p>Promoting your brand on social media has been shown to increase brand recognition. Top this off with relevant and consistent visual content, you can communicate with your target consumers on familiar grounds. May it be your logo or consistency in style, it's crucial for your brand to be consistent, relevant, and clear. This constant interaction creates solid brand identity, strengthening brand recall.&nbsp;<\\/p>\"},{\"id\":\"vasijqzor\",\"heading\":\"Strategic Visual Content\",\"body\":\"<p>PurpleBug&rsquo;s Creatives Development service is more than just creating a logo for your brand. We create visual content based on carefully planned campaigns, right ideas, and effective strategies. We present an offer in a way that effectively represents your brand while achieving your campaign goals.&nbsp;<\\/p>\"},{\"id\":\"0xwldq3bu\",\"heading\":\"Targeted Marketing\",\"body\":\"<p>Graphic design is an important tool that enhances how you communicate with your customers. It serves as a medium to convey your ideas in a way that is not only effective, but also attractive to your audiences. Humans are visual beings. We process information based on what we see. Studies show that people remember 80% of what they see and 20% of what they read. We aim to showcase your brand to the fullest of its potential to your customers.&nbsp;<\\/p>\"}]",
                "facts" => "<ul>\n<li>51% of marketing professionals cite video as the type of content with the best ROI. Leveraging video on social media is necessary to capture and satisfy a captive, content-hungry audience.</li>\n<li>Motion graphics can improve your business the same way as other visual contents. They're a unique way to communicate. They blend the best of visual communication with motion storytelling and audio to create an engaging piece of content that helps brands share their story, reach people in different ways, and present their message in a compelling way.</li>\n</ul>",
                "seo" => "{\"meta_title\":\"Creatives Development | Digital Services | PurpleBug\",\"meta_description\":\"PurpleBug\\u2019s Creatives Development service provides most reliable digital content that your business needs.\",\"meta_keywords\":\"Creatives Development, Digital Services, PurpleBug\"}",
                "status" => 1,
                "created_at" => NOW(),
                "updated_at" => NOW(),
            ),
        );

        Service::insert($services);
    }
}