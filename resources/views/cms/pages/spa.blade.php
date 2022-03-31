@extends('cms.layouts.app')

@section('content')
<cms-view :attributes="{{ $attr ?? 'null' }}"></cms-view>
@endsection