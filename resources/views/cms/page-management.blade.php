@extends('cms.layouts.app')

@section('content')
<div class="page-management mt-4">
    <div class="row no-gutters">
        <div class="col-md-11">
            {{-- Start Header --}}
            <div class="page-management-header">
                <div class="header-title mb-4">
                    <h1>Page Management</h1>
                </div>

                <div class="content">
                    <div class="pages-container">
                        @foreach (auth()->user()->role->modules as $module)
                        <a class="card" href="{{ url("/cms/pages/{$module['url']}") }}">
                            <div class="card-body">
                                <div class="page-logo">
                                    <img src="{{ asset('/cms-assets/'. $module['icon']) }}" alt="">
                                </div>

                                <div class="page-name">
                                    <h2>{{ ucwords(str_replace('-', ' ', $module['name'])) }}</h2>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>

                    <hr>

                    @if (auth()->user()->role_id === 1)
                    <div class="footer-links-container">
                        <a class="btn btn-light" href="{{ url("/cms/pages/footer-links") }}">
                            <img src="{{ asset('/cms-assets/link.png') }}" alt=""> Footer Links
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            {{-- End Header --}}
        </div>
    </div>
</div>
@endsection
