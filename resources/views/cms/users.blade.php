@extends('cms.layouts.app')

@section('content')
<user-management :roles="{{ $roles }}"></user-management>
@endsection