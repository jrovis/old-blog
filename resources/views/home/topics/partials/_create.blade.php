<form action="{{ route('p.store') }}" method="POST" class="ui form item-form" accept-charset="UTF-8">
    {{ csrf_field() }}

    <div class="field {{ $errors->has('title') ? 'error' : '' }}">
        <input class="form-control" type="text" name="title" id="title-field" value="{{ old('title') }}" required=""
               placeholder="标题">
    </div>

    <div class="field {{ $errors->has('tags') ? 'has-error' : '' }}">
        <select class="js-example-placeholder-multiple" name="tags[]" multiple="multiple">
        </select>

        @if ($errors->has('tags'))
            <div class="ui error message">
                <div class="header">{{ $errors->first('tags') }}</div>
            </div>
        @endif
    </div>

    @include('home.topics.partials.composing_help_block')

    <div class="field">
           <textarea rows="15" id="editor" name="body" placeholder="请使用 Markdown 编写"
                     required="">{{ old('body') }}</textarea>
    </div>

    <div class="ui message">
        <button type="submit" class="ui button teal publish-btn"><i class="icon send"></i> 发布 </button>
    </div>
</form>
