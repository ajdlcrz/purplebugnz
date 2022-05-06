@extends('cms.layouts.app')

@section('content')
<div class="dashboard mt-4">
        <div class="row no-gutters">
            <div class="col-md-11">
                {{-- Start Dashboard Header --}}
                <div class="dashboard-header mb-5">
                    <div class="title">
                        <h1>Dashboard</h1>
                    </div>
                </div>
                {{-- End Dashboard Header --}}

                {{-- Start Recent Activities --}}
                <div class="recent-activities mb-5">
                    <div class="title-viewmore d-flex mb-3">
                        <h2><span class="icon-activities-alt"></span> Recent Activities</h2>
                        <a href="{{ route("activities") }}">View More</a>
                    </div>

                    <table class="table">
                        <tbody>
                            @foreach ($latestActivities as $activity)
                            <tr>
                                <td class="d-flex" style="25%">
                                    <strong style="flex: 1;">{{ $activity->causer->name }}</strong>
                                    <span style="flex: 3; color: #707070"> {{ $activity->description }}</span>
                                </td>
                                <td style="50%">{{ $activity->causer->role->description }}</td>
                                <td style="25%" class="text-right">{{ $activity->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- End Recent Activities --}}

                {{-- Start Recently Added Users --}}
                <div class="recent-users mb-5">
                    <div class="title-viewmore d-flex mb-3">
                        <h2><span class="icon-users-alt"></span> Recently Added Users</h2>
                        <a href="{{ route("users.index") }}">View More</a>
                    </div>

                    <table class="table">
                        <tbody>
                            @foreach ($latestAddedUser as $userActivity)
                            <tr>
                                <td width="auto">
                                    <strong>{{ $userActivity->subject->name }}</strong>
                                </td>
                                <td width="auto">{{ $userActivity->subject->role->description }}</td>
                                <td width="auto"><span class="icon-circle"></span> Active </td>
                                <td width="auto">
                                    added by &nbsp;
                                    <span style="color: #8a3d92">
                                        {{ $userActivity->causer->name }}
                                    </span>
                                </td>
                                <td width="auto" class="text-right">{{ $userActivity->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- End Recently Added Users --}}

                {{-- Start Recently Added Pages --}}
                {{-- <div class="recent-pages mb-5">
                    <div class="title-viewmore d-flex mb-3">
                        <h2><span class="icon-pages-alt"></span> Recently Added Blogs</h2>
                        <a href="{{ route("blogs.index") }}">View More</a>
                    </div>

                    <table class="table">
                        <tbody>
                            @foreach ($latestAddedBlog as $blogActivity)
                            <tr>
                                <td class="d-flex" style="25%">
                                    <strong style="flex: 1;">{{ $blogActivity->causer->name }}</strong>
                                    <span style="flex: 3; color: #707070"> {{ $blogActivity->description }}</span>
                                </td>
                                <td style="50%">{{ $blogActivity->subject->title }}</td>
                                <td style="25%" class="text-right">{{ $blogActivity->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> --}}
                {{-- End Recently Added Pages --}}
            </div>
        </div>
</div>
@endsection
