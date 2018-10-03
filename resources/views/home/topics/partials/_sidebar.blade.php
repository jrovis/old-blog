<div class="ui stackable cards">
    <div class="ui card tag-active-user-card stackable">
        <div class="content">
            <span class="">我关注的标签</span>
        </div>
        <div class="extra content">
            <div class="ui middle aligned divided list">
                <a class="item" href="/#/php">
                    <div class="right floated content">
                        <div class="ui label basic circular">0</div>
                    </div>
                    <img class="ui avatar image tagged" src="{{ asset('/images/tags/php.png') }}">
                    <div class="content color-black">
                        PHP
                    </div>
                </a>
            </div>

        </div>
    </div>

    <div class="ui card tag-active-user-card stackable">
        <div class="content">
            <span class="">名人堂</span>
        </div>
        <div class="extra content">
            <div class="ui middle aligned divided list">

                @foreach($activeUsers as $activeUser)
                <a class="item" href="{{ $activeUser->link() }}">
                    <div class="right floated content">
                        <div class="ui label basic circular">0</div>
                    </div>
                    <img class="ui avatar image" src="{{ $activeUser->avatar }}">
                    <div class="content color-black">
                        {{ $activeUser->username }}
                    </div>
                </a>
                @endforeach

            </div>
        </div>
    </div>
</div>