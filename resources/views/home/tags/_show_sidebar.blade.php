<div class="ui stackable cards">
    <div class="ui card orange container center aligned">
        <div class="tag-statistic">
            <div class="ui statistic">
                <div class="value">
                    {{ $tag->topics_count }}
                </div>
                <div class="label">话题</div>
            </div>
            <div class="ui statistic">
                <div class="value">
                    {{ $tag->followers_count }}
                </div>
                <div class="label">关注用户</div>
            </div>
        </div>
    </div>

    <div class="ui card tag-active-user-card">
        <div class="content">
            <span class="">最佳贡献</span>
        </div>
        <div class="extra content">
            <div class="ui middle aligned divided list"></div>
        </div>
    </div>
</div>
