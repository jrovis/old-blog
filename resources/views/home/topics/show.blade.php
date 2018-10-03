@extends('home.layouts.app')

@section('title', $topic->title)

@section('description', $topic->excerpt)

@section('style')
    <link href="https://cdn.bootcss.com/social-share.js/1.0.16/css/share.min.css" rel="stylesheet">
    <link href="{{ asset('vendor/tocify/jquery.tocify.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/tocify/_tocify.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/prism/prism.css') }}" rel="stylesheet">

    <style>
        .ui.tag.label.small.topic-tag {
            padding-top: 0em;
            padding-bottom: 0em;
            padding-right: 0em;
        }
    </style>
@stop

@section('content')
    <div class="twelve wide column">

        <div class="ui segment article-content">

            <div class="extra-padding">
                <h1>
                    <i class="grey file text outline icon"></i>
                    <span style="line-height: 34px;">{{ $topic->title }}</span>

                    @can('update', $topic)
                        <div class="ui right floated buttons">
                            <a class="ui basic label" href="{{ route('p.edit', [hashIdEncode($topic->id)]) }}"><i
                                        class="grey edit icon"></i></a>
                            <a class="ui basic label" href="javascript:;" id="delete-btn" data-method="delete"
                               data-url="" style="cursor:pointer;">
                                <i class="grey trash icon"></i>
                                <form action="{{ route('p.destroy', [hashIdEncode($topic->id)]) }}" method="POST" class="delete-form" style="display:none">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                </form>
                            </a>
                        </div>
                    @else
                        <div class="pull-right">
                            <div class="ui labeled button tiny">
                                <div class="ui compact button tiny kb-star basic " data-act="star" data-id="{{ $topic->id }}">
                                    <i class="thumbs up icon"></i> <span class="state">点赞</span>
                                </div>
                                <a class="ui basic label star_count">{{ $topic->votes_count }}</a>
                            </div>
                        </div>
                    @endcan
                </h1>

                <p class="article-meta">
                    <a class="ui basic image small label" href="{{ $topic->user->link() }}">
                        <img src="{{ $topic->user->avatar }}" width="100px" height="100px">
                        {{ $topic->user->name }}
                    </a>
                    <span class="ui label small basic" data-tooltip="{{ $topic->created_at }}" data-position="right center" data-inverted="">
                        <i class="clock icon"></i>
                        {{ $topic->created_at->diffForHumans() }}
                    </span>
                </p>

                <p class="item-tags">
                    <i class="icon grey tags " style="font-size: 1.2em"></i>

                    @foreach($topic->tags as $tag)
                    <a class="ui tag label small topic-tag" href="{{ route('t.show', ['id' => $tag->id]) }}">
                        {{ $tag->name }}
                        <img class="tagged"
                             src="{{ $tag->image }}">
                    </a>
                    @endforeach
                </p>

                <div class="ui divider"></div>
                <div class="ui readme markdown-body">
                    {!! $topic->body !!}
                </div>
            </div>
        </div>

        <div class="ui message basic">
            <div class="social-share share-component" data-initialized="true">
                <a href="#" class="social-share-icon icon-wechat"></a>
                <a href="#" class="social-share-icon icon-qq"></a>
                <a href="#" class="social-share-icon icon-qzone"></a>
                <a href="#" class="social-share-icon icon-weibo"></a>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="ui message basic text-center voted-box">
            <div class="buttons">
                <topic-vote topic="{{ hashIdEncode($topic->id) }}"></topic-vote>
            </div>

            <div class="voted-users">
                @foreach ($topic->votedUsers as $votedUser)
                <a href="{{ $votedUser->link() }}">
                    <img class="ui image avatar image-33 stargazer" src="{{ $votedUser->avatar }}">
                </a>
                @endforeach
            </div>
        </div>

        <div class="ui threaded comments comment-list">
            <div id="comments"></div>
            <div class="ui divider horizontal grey"><i class="icon comments"></i> 评论数量: {{ $topic->replies_count }}</div>
            {{--评论列表--}}
            <div class="comments-feed"></div>
            <br>

        </div>
    </div>

    <div class="four wide column" style="min-height: 434px;">
        @include('home.topics.partials._show_sidebar', ['user'=> $topic->user, 'topic' => $topic])
    </div>
@stop

@section('javascript')
    <script src="https://cdn.bootcss.com/social-share.js/1.0.16/js/social-share.min.js"></script>

    <script src=" {{ asset('vendor/tocify/jquery-ui.min.js') }}"></script>
    <script src=" {{ asset('vendor/tocify/jquery.tocify.min.js') }}"></script>
    <script src=" {{ asset('vendor/prism/prism.js') }}"></script>

    <script>
        $(function () {
            $('#delete-btn').click(function () {
                swal({
                    title: "",
                    text: " 将要删除话题？",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "取消",
                    confirmButtonText: "删除"
                }).then((result) => {
                    if (result.value) {
                        // e.preventDefault();
                        $('.delete-form').submit();
                    }
                });
            });

            $("#toc").closest('.sticky').visibility({
                type: 'fixed',
            });

            // $("#toc").tocify({
            //     selectors: "h2,h3,h4"
            // });
        });
    </script>
@stop