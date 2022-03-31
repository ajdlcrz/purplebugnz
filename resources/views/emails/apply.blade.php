@component('mail::message')
<div style="display: flex; justify-content: center;"><h1 style="margin: 0 auto;">PurpleBug Careers</h1></div>
<br><br>

## Job Title:
{{ $career ? $career->title : '' }}
## Name:
{{ $applicant->name }}
## Contact:
{{ $applicant->contact }}
## Email:
{{ $applicant->email }}
## Address:
{{ $applicant->address }}

<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
