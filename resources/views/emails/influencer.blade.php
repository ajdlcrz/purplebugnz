@component('mail::message')
<div style="display: flex; justify-content: center;"><h1 style="margin: 0 auto;">New Influencer</h1></div>
<br><br>

- <strong>Name:</strong> {{ $influencer->name }}
- <strong>Email:</strong> {{ $influencer->email }}
- <strong>Contact No.:</strong> {{ $influencer->contact_number }}
- <strong>Age:</strong> {{ $influencer->age }}
- <strong>Sex:</strong> {{ $influencer->sex }}
- <strong>Total Followers (est.):</strong> {{ $influencer->total_followers }}
- <strong>Content Categories:</strong>
@foreach ($influencer->content_category as $key => $contentType)
@if ($contentType && $key !== 'others')  - <small><strong>{{ Str::title($key) }}</strong></small>
@elseif ($key == 'others' && !empty($influencer->content_category['others']))  - <small><strong>Others:</strong> {{ $contentType }}</small>
@endif
@endforeach
- <strong>Facebook:</strong>
  - <small><strong>Page URL:</strong> {{ $influencer->facebook['page_url'] }}</small>
  - <small><strong>Post Rate:</strong> {{ $influencer->facebook['post_rate'] }}</small>
- <strong>Instagram:</strong>
  - <small><strong>Page URL:</strong> {{ $influencer->instagram['page_url'] }}</small>
  - <small><strong>Post Rate:</strong> {{ $influencer->instagram['post_rate'] }}</small>
  - <small><strong>Video Post Rate:</strong> {{ $influencer->instagram['video_post_rate'] }}</small>
- <strong>YouTube:</strong>
  - <small><strong>Page URL:</strong> {{ $influencer->youtube['page_url'] }}</small>
  - <small><strong>Post Rate:</strong> {{ $influencer->youtube['post_rate'] }}</small>
- <strong>TikTok:</strong>
  - <small><strong>Page URL:</strong> {{ $influencer->tiktok['page_url'] }}</small>
  - <small><strong>Post Rate:</strong> {{ $influencer->tiktok['post_rate'] }}</small>

<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
