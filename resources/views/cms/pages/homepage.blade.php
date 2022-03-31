@extends('cms.layouts.app')

@section('content')
<homepage :sections="{{ $contents }}"></homepage>
@endsection
