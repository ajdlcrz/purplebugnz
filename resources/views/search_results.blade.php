@extends('layouts.app')

@section('content')
<search-results keyword="{{ request('keyword') }}"></search-results>
@endsection