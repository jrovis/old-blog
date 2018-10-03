@extends('home.layouts.app')

@section('title', $tag->name)

@section('content')
    <div class="twelve wide column right-side">
        <div class="ui segment">
            <div class="content extra-padding">
                <div>
                    <h1 class="pull-left">
                        <img class="ui middle aligned tiny image tagged" src="{{ $tag->image }}" >
                        <a class="ui tag label large">{{ $tag->name }}</a>
                    </h1>

                    <div class=" ui compact floating subscribe button subscribe-wrap  pull-right basic" data-act="unsubscribe" data-id="{{ $tag->id }}">
                        <span class="state">关注</span>
                    </div>
                </div>
                <div style="clear: both"></div>

                <div class="ui attached tabular  menu stackable">
                    <a class="item {{ active_class(( !if_query('filter', 'recent') && !if_query('filter', 'star'))) }}" href="{{ route('t.show', ['id' =>$tag->id, 'filter' => 'heat']) }}" data-tab="first"><i class="icon fire"></i> 热门 </a>
                    <a class="item {{ active_class(if_query('filter', 'star')) }}" href="{{ route('t.show', ['id' =>$tag->id, 'filter' => 'star']) }}"><i class="icon thumbs up"></i> 点赞排行 </a>
                    <a class="item {{ active_class(if_query('filter', 'recent')) }}" href="{{ route('t.show', ['id' =>$tag->id, 'filter' => 'recent']) }}"><i class="icon feed"></i> 最新 </a>
                </div>

                @include('home.topics.partials._topic_list', ['topics' => $topics])

                {!! $topics->render() !!}
            </div>
        </div>
    </div>

    <div class="four wide column">
        @include('home.tags._show_sidebar')
    </div>
@stop