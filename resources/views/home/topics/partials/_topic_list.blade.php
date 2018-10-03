@if(count($topics))
    <div class="ui feed">

        @foreach($topics as $topic)
        <div class="event">
            <div class="label">
                <a href="{{ $topic->user->link() }}z">
                    <img src="{{ $topic->user->avatar }}">
                </a>
            </div>
            <div class="content">
                <div class="summary">
                    <a href="{{ $topic->link() }}" class="title"> {{ $topic->title }} </a>
                </div>
                <div class="date">
                    <a href="{{ $topic->user->link() }}"><i class="user icon"></i>{{ $topic->user->username }}</a>
                    <span data-tooltip="{{ $topic->created_at }}" data-position="top center" data-inverted=""><i class="time icon"></i>{{ $topic->created_at->diffForHumans() }}</span>
                    <span><i class="unhide icon"></i>{{ $topic->views_count }}</span>
                </div>

                @if(count($topic->tags))
                <div class="meta">
                    <i class="icon tags"></i>
                    @foreach($topic->tags as $tag)
                    <a class="ui label small" href="{{ route('t.show', ['id' => $tag->id]) }}">{{ $tag->name }}</a>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="item-meta">
                <a class="ui label basic light grey" href="{{ $topic->link() }}"><i class="thumbs up icon"></i> {{ $topic->votes_count }} </a>
                <a class="ui label basic light grey" href="{{ $topic->link() }}"><i class="comment icon"></i> {{ $topic->replies_count }} </a>
            </div>
        </div>
        @endforeach

    </div>

@else
    <div class="empty-block">暂无数据 ~_~ </div>
@endif