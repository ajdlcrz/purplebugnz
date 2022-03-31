<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Content extends Model implements Searchable
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $casts = ['contents' => 'json'];

    public static function homebannerPath($banner)
    {
        if (isset($banner["image"])) {
            return "/storage/homepage/banners/{$banner['image']}";
        }

        return  "/img/placeholders/homeBanner-header.png";
    }

    // searchables 🔎🔎🔎
    public function getSearchResult(): SearchResult
    {
        $url = $this->page;
        $title = $this->contents['heading'] ?? ucwords(str_replace('_', ' ', $this->section));

        if ($this->page == 'homepage') {
            $url = '';
        }
        if ($this->page == 'about') {
            $url = 'about-us';
        }
        if ($this->page == 'teams') {
            $url = 'our-team';
        }
        if ($this->page == 'contact') {
            $url = 'contact-us';
        }

        if ($this->section == 'partners') {
            $url = url('/#ourPartners');
        }

        if ($this->section == 'footer_banner') {
            $title = 'Why Purplebug';
            $url = url('/#whyPurplebug');
        }

        if ($this->section == 'our_approach') {
            $url = url('/about-us#approach');
        }

        if ($this->section == 'why_purplebug') {
            $url = url('/about-us#why');
        }

        if ($this->section == 'who_we_are') {
            $url = url('/our-team#whoWeAre');
        }

        if ($this->section == 'executives') {
            $url = url('/our-team#executivesList');
        }

        if ($this->section == 'contact_details') {
            $url = url('/contact-us#contactDetails');
        }

        return new SearchResult(
            $this,
            $title,
            url($url)
        );
    }

    public function scopeSearchable($query)
    {
        return $query->whereNotIn('section', ['banners', 'join_our_team', 'seo']);
    }
}
