@if (count($topics))

    <div class="ui divided feed">

        @foreach ($topics as $topic)

        <div class="event">
            <div class="label">
                <a>
                    <img src="{{ $user->avatar }}">
                </a>
            </div>
            <div class="content">
                <div class="date">
                    <a>{{ $user->username }}</a>
                    <span data-tooltip="{{ $topic->created_at }}" data-position="top center" data-inverted=""><i class="time icon"></i>{{ $topic->created_at->diffForHumans() }}</span>
                </div>

                <div class="summary">
                    <a href="{{ $topic->link() }}">
                        <h3>{{ $topic->title }}</h3>
                    </a>
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
        </div>

        @endforeach
    </div>

@else
    <div class="empty-block">暂无数据 ~_~ </div>
@endif

{{-- 分页 --}}
{!! $topics->render() !!}