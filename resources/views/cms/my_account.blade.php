@extends('cms.layouts.app')

@section('content')
<my-account :roles="{{ $roles }}"></my-account>
@endsection