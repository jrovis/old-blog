<div class="item header">
    <div class="ui segment">
        <div class="ui three statistics">
            <div class="ui huge statistic">
                <div class="value">{{ $topic->votes_count }} </div>
                <div class="label">点赞</div>
            </div>
            <div class="ui huge statistic">
                <div class="value">{{ $topic->views_count }} </div>
                <div class="label">浏览</div>
            </div>
            <div class="ui huge statistic">
                <div class="value">{{ $topic->replies_count }} </div>
                <div class="label">评论</div>
            </div>
        </div>

        <br>

    </div>
</div>

<div class="ui stackable cards">
    <div class="ui  card column author-box grid" style="margin-top: 20px;">
        <div class="ui fluid" style="margin-top: 20px;">
            <div class="ui teal ribbon label"><i class="trophy icon"></i> 贡献 0 </div>
        </div>

        <a href="{{ $user->link() }}" class="avatar-link">
            <img class="ui centered circular tiny image " src="{{ $user->avatar }}">
        </a>

        <div class="extra content ui center aligned container">
            <a class="header" href="{{ $user->link() }}">{{ $user->username }}</a>
            <div class="description">{{ $user->introduction }}</div>
        </div>
        <div class="extra content">
            <button class=" ui basic teal button fluid follow" data-act="follow" data-uname="{{ $user->username }}"><span class="state">关注</span></button>
            {{--<a href="https://tiicle.com/messages/to/1" class="ui basic button fluid" style="margin-top: 6px;">--}}
                {{--<i class="icon envelope"></i> 私信--}}
            {{--</a>--}}
        </div>
    </div>
</div>

<div class="ui sticky" style="padding-top: 20px; width: 262px !important;">
    <div class="ui card column author-box grid tocify" id="toc"></div>
</div>
