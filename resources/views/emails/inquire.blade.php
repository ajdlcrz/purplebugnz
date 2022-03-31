@component('mail::message')
<div style="display: flex; justify-content: center;"><h1 style="margin: 0 auto;">PurpleBug Inquiry</h1></div>
<br><br>

## Subject:
{{ $service ? $service->title : $inquiry->contact_subject }}
## Name:
{{ $inquiry->name }}
## Contact:
{{ $inquiry->contact }}
## Email:
{{ $inquiry->email }}
## Message:
{{ $inquiry->message }}

<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
