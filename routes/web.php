<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');
Route::get('/about-us', 'AboutController@about');
Route::get('/our-team', 'TeamController@team');
Route::get('/search', 'HomeController@search');
Route::get('/searchList', 'HomeController@searchList');

Route::get('/services', 'ServiceController@services');
Route::get('/service/{service:slug}', 'ServiceController@service');
Route::post('/service/inquire', 'InquiryController@serviceInquire');
Route::post('/service/influencer-register', 'InquiryController@storeInfluencer');

Route::get('/blogs-list', 'BlogController@blogsList');
Route::get('/blogs', 'BlogController@blogs')->name('blogs.landing');
Route::get('/blog/{blog:slug}', 'BlogController@blog')->name('blogs.inner');

Route::get('/insights-list', 'InsightController@insightslist');
Route::get('/insights', 'InsightController@insights')->name('insights.landing');
Route::get('/insight/{insight:slug}', 'InsightController@insight')->name('insights.inner');
Route::post('/insight/insight-inquire', 'InsightInquiryController@inquire')->name('insight.inquire');

Route::get('/contact-us', 'ContactController@contact');
Route::post('/inquire', 'InquiryController@inquire')->name('inquire');

Route::get('/careers-list', 'CareerController@careersList');
Route::get('/careers', 'CareerController@careers');
Route::get('/career/{career:slug}', 'CareerController@career');
Route::get('/career/{career:slug}/apply', 'CareerController@careerForm');
Route::post('apply', 'ApplicantController@apply');

Route::post('subscribe', 'SubscriberController@subscribe');

Route::get('privacy-policy', 'HomeController@policy');
Route::get('terms-and-conditions', 'HomeController@terms');

// == == == == CMS == == == ==
Route::prefix('cms')->group(function () {
    Route::get('/', ['as' => '', 'uses' => 'Auth\LoginController@showLoginForm']);
    Route::post('/', ['as' => 'login', 'uses' => 'Auth\LoginController@login']);
    Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

    Route::middleware(['auth'])->group(function () {
        Route::get('help', 'CmsController@faqs')->name("help");
        Route::get('faqs-management', 'CmsController@faqs');
        Route::post('faqs', 'CmsController@storeFaq');
        Route::put('faqs/{faq}', 'CmsController@updateFaq');

        // == == == == MY ACCOUNT == == == ==
        Route::get('my-account', 'CmsController@myAccount')->name("my-account");
        Route::put('my-account', 'CmsController@updatePassword');

        // == == == == ADMIN PAGES == == == ==
        Route::middleware(['is_admin'])->group(function () {
            Route::get('/dashboard', 'CmsController@index')->name('dashboard');

            // == == == == ACTIVITY LOGS == == == ==
            Route::get('activities', 'CmsController@activities')->name('activities');
            Route::get('activities/export/{column}/{order}', 'CmsController@exportActivities');
            Route::get('activities/records', 'CmsController@activityLogs');

            // == == == == USER MANAGEMENT == == == ==
            Route::get('users/records', 'UserController@records');
            Route::resource('users', 'UserController')->except(['show', 'create', 'edit']);
        });

        // == == == == PAGES MANAGEMENT == == == ==
        Route::prefix('pages')->group(function () {
            Route::get('/', 'CmsController@pages')->name('page.management');
            Route::put('update-banner/{page}', 'ContentController@updateBanner'); //
            Route::put('update-seo/{page}', 'ContentController@updateSeo'); //

            // == == == == HOMEPAGE == == == ==
            Route::middleware(['homepage_access'])->group(function () {
                Route::get('homepage', 'HomeController@editContent')->name('page.homepage');
                Route::put('homepage/{section}', 'HomeController@updateContent');

                Route::get('partners/records', 'PartnerController@records');
                Route::resource('partners', 'PartnerController')->only(['store', 'update', 'destroy']);
            });

            // == == == == ABOUT US == == == ==
            Route::middleware(['aboutus_access'])->group(function () {
                Route::get('about-us', 'AboutController@editContent')->name('page.about');
                Route::put('about-us/{section}', 'AboutController@updateContent');
                Route::get('about-contents', 'AboutController@getContents');

                Route::get('subsidiaries/records', 'SubsidiaryController@records');
                Route::resource('subsidiaries', 'SubsidiaryController')->only(['store', 'update', 'destroy']);
            });

            // == == == == PRODUCTS & SERVICES == == == ==
            Route::middleware(['services_access'])->group(function () {
                Route::put('service-offer/{service}', 'ServiceController@updateOffers');
                Route::delete('service-offer/{service}/delete/{offer}', 'ServiceController@deleteOffer');

                Route::put('services-facts/{service}', 'ServiceController@updateFacts');

                Route::get('services/edit/{service}', 'ServiceController@editService');
                Route::get('services-contents', 'ServiceController@getContents');
                Route::get('services/records', 'ServiceController@records');
                Route::resource('services', 'ServiceController');
                Route::resource('services/{service}/testimonials', 'TestimonialController')->only(['store', 'update', 'destroy']);
            });

            // == == == == BLOGS & CATEGORIES == == == ==
            Route::middleware(['blogs_access'])->group(function () {
                Route::get('categories-list', 'CategoryController@categoryLists');
                Route::resource('categories', 'CategoryController')->only(['store', 'update', 'destroy']);

                Route::get('blogs/edit/{blog}', 'BlogController@editBlog');
                Route::get('blogs-contents', 'BlogController@getContents');
                Route::get('blogs/records', 'BlogController@records');
                Route::resource('blogs', 'BlogController')->except(['show']);
            });

            // == == == == INSIGHTS == == == ==
            Route::middleware(['insights_access'])->group(function () {
                Route::get('insights/edit/{insight}', 'InsightController@editInsight');
                Route::get('insights-contents', 'InsightController@getContents');
                Route::get('insights/records', 'InsightController@records');
                Route::resource('insights', 'InsightController')->except(['show']);
                //INSIGHT INQUIRY
                Route::get('insights-report', 'InsightController@index');
                Route::get('insights-report/fetch', 'InsightController@getInsightRecord');
                Route::get('insights-report/export/{column}/{order}', 'InsightController@exportToExcel');
            });

            // == == == == CAREERS == == == ==
            Route::middleware(['careers_access'])->group(function () {
                Route::get('careers', 'CareerController@index')->name('page.careers');
                Route::get('careers-contents', 'CareerController@getContents');

                Route::get('applicants', 'CareerController@index');
                Route::put('applicants/{applicant}', 'ApplicantController@update');
                Route::get('applicants/export', 'ApplicantController@exportApplicant');
                Route::get('download-resume/{applicant}', 'ApplicantController@downloadResume');
                Route::get('applicants/records', 'ApplicantController@applicants');

                Route::get('jobs', 'CareerController@index');
                Route::post('jobs', 'CareerController@storeJob');
                Route::put('jobs/{job}', 'CareerController@updateJob');
                Route::delete('jobs/{job}', 'CareerController@destroyJob');
                Route::get('jobs/export/{column}/{order}', 'CareerController@exportJobs');
                Route::get('jobs/records', 'CareerController@jobs');
            });

            // == == == == OUR TEAMS == == == ==
            Route::middleware(['teams_access'])->group(function () {
                Route::get('our-teams', 'TeamController@index')->name('page.teams');
                Route::get('teams-contents', 'TeamController@getContents');
                Route::put('our-teams/{section}', 'TeamController@updateContent');

                Route::post('our-teams/add-photo', 'TeamController@addPhoto');
                Route::delete('our-teams/{photo}/delete-photo', 'TeamController@deletePhoto');
                Route::get('our-teams/photos', 'TeamController@listPhotos');

                Route::get('our-teams/employees', 'TeamController@employees');
                Route::patch('our-teams/updateAllEmployees', 'TeamController@updateAllEmployees');
                Route::resource('employees', 'TeamController')->only(['store', 'update', 'destroy']);
            });

            // == == == == CONTACT US == == == ==
            Route::middleware(['contacts_access'])->group(function () {
                Route::get('contact-us', 'ContactController@index')->name('page.contact');
                Route::get('contact-contents', 'ContactController@getContents');
                Route::put('contact-update', 'ContactController@updateContacts');
                Route::delete('contact-delete/{contact}', 'ContactController@deleteContact');
            });

            // == == == == INFLUENCERS == == == ==
            Route::middleware(['influencers_access'])->group(function () {
                Route::prefix('influencers')->group(function () {
                    Route::get('records', 'InfluencerController@records');
                    Route::get('export/{column}/{order}', 'InfluencerController@export');
                });
                Route::resource('influencers', 'InfluencerController')->only('index');
            });

            // == == == == FOOTER LINKS == == == ==
            Route::get('footer-links/records', 'FooterLinkController@records');
            Route::resource('footer-links', 'FooterLinkController')->except(['show', 'create', 'edit']);
        });
    });
});
