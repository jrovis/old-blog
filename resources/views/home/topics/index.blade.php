@extends('home.layouts.app')

@section('content')
    <div class="twelve wide column right-side stacked segments">

        <div class="ui segment">
            <div class="content extra-padding">
                <h1>
                    <a class="ui animated button icon teal" href="{{ route('p.create') }}">
                        <div class="visible content"> &nbsp;&nbsp;记录编码技巧 </div>
                        <div class="hidden content"><i class="plus icon"></i></div>
                    </a>
                </h1>

                <div class="ui attached tabular menu stackable">
                    <a class="item {{ active_class(( !if_query('filter', 'recent'))) }}" href="{{ route('p.index', ['filter' => 'heat']) }}"><i class="icon fire"></i> 热门 </a>
                    <a class="item {{ active_class(if_query('filter', 'recent')) }}" href="{{ route('p.index', ['filter' => 'recent']) }}"><i class="icon feed"></i> 最新 </a>
                </div>

                @include('home.topics.partials._topic_list', ['topics' => $topics])

                {!! $topics->render() !!}

            </div>
        </div>

    </div>

    <div class="four wide column stackable">
        @include('home.topics.partials._sidebar')
    </div>
@stop