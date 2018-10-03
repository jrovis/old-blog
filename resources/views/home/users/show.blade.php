@extends('home.layouts.app')

@section('title', $user->username . ' 个人中心')

@section('content')
    <div class="four wide column">
        <div class="ui stackable cards">
            <div class="ui card">
                <div class="image">
                    <img src="{{ $user->avatar }}">
                </div>
                <div class="content">
                    <div class="header">
                        {{ $user->username }}
                    </div>
                    @if ($user->githubData())
                    <p class="meta">
                        {{ '@' . $user->githubData()->login }}

                        <a href="{{ $user->githubData()->html_url }}" target="_blank">
                            <i class="icon github alternate grey"></i>
                        </a>
                    </p>
                    @endif

                    <div class="description"> {{ $user->introduction }}</div>
                </div>

                <div class="extra content">
                    <i class="marker icon"></i> {{ $user->githubData() ? $user->githubData()->location : '' }}
                </div>

                <div class="extra content">
                    <button class="ui basic teal button fluid follow" data-act="follow" data-id="{{ $user->id }}"><span
                                class="state">关注</span></button>
                </div>
            </div>

            <div class="ui card tag-active-user-card popular-card">
                <div class="content">
                    <span class="">最受欢迎</span>
                </div>
                <div class="extra content">
                    <div class="ui middle aligned divided  list">
                        <a class="item" href="">
                            <span class="ui label tiny"><i class="thumbs up icon"></i> 0 </span>
                            暂无数据~
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="twelve wide column">
        <div class="ui stacked segment">
            <div class="ui teal ribbon label"><i class="trophy icon"></i> 贡献 0 </div>

            <div class="content extra-padding">
                <div class="ui attached tabular menu stackable">

                    {{--<a class="item active" data-tab="first" href=""><i class="icon feed"></i> 动态</a>--}}

                    <a class="item active" data-tab="first" href=""><i class="icon file text outline"></i> 话题 <span class="counter">{{ $user->topics_count }}</span> </a>

                    <a href="" class="item "><i class="icon user"></i> 关注者 <span class="counter">{{ $user->followings_count }}</span> </a>

                    <a href="" class="item "><i class="icon thumbs up"></i> 赞过 <span class="counter">{{ $user->voted_count }}</span> </a>

                </div>

                @include('home.users._topics', ['topics' => $user->topics()->with('tags')->undeleted()->recent()->paginate(10)])

            </div>
        </div>
    </div>
@stop