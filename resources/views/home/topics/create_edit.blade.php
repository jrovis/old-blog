@extends('home.layouts.app')

@section('title')
    {{ isset($topic) ? '编辑话题' : '新建话题' }}
@stop

@section('style')
    <link href="{{ asset('css/tags-select.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="fourteen wide column">
        <div class="ui segment">
            <div class="content extra-padding">

                @include('common.error')

                @if (! isset($topic))
                    @include('home.topics.partials._create')
                @else
                    @include('home.topics.partials._edit', ['topic' => $topic])
                @endif

            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        $(document).ready(function () {
            var simplemde = new SimpleMDE({
                spellChecker: false,
                autosave: {
                    enabled: true,
                    delay: 5000,
                    unique_id: "topic_content{{ isset($topic) ? $topic->id . '_' . str_slug($topic->updated_at) : '' }}"
                },
                forceSync: true,
                tabSize: 4,
                toolbar: [
                    "bold", "italic", "heading", "|", "quote", "code", "table",
                    "horizontal-rule", "unordered-list", "ordered-list", "|",
                    "link", "image", "|", "side-by-side", 'fullscreen', "|",
                    {
                        name: "guide",
                        action: function customFunction(editor) {
                            var win = window.open('https://github.com/riku/Markdown-Syntax-CN/blob/master/syntax.md', '_blank');
                            if (win) {
                                //Browser has allowed it to be opened
                                win.focus();
                            } else {
                                //Browser has blocked it
                                alert('Please allow popups for this website');
                            }
                        },
                        className: "fa fa-info-circle",
                        title: "Markdown 语法！"
                    },
                    {
                        name: "publish",
                        action: function customFunction(editor) {
                            $('#topic-submit').click();
                        },
                        className: "fa fa-paper-plane",
                        title: "发布话题"
                    }
                ]
            });

            simplemde.codemirror.on("refresh", function () {
                $(window).trigger('resize');
            });
            simplemde.codemirror.on("paste", function () {
                $(window).trigger('resize');
            });

            inlineAttachment.editors.codemirror4.attach(simplemde.codemirror, {
                uploadUrl: '{{ route('p.upload_image') }}',
                extraParams: {
                    '_token': '{{ csrf_token() }}'
                },
                onFileUploadResponse: function (xhr) {
                    var result = JSON.parse(xhr.responseText),
                        filename = result.file_path;
                    //this.settings.jsonFieldName

                    if (result && filename) {
                        var newValue;
                        if (typeof this.settings.urlText === 'function') {
                            newValue = this.settings.urlText.call(this, filename, result);
                        } else {
                            newValue = this.settings.urlText.replace(this.filenameTag, filename);
                        }

                        var text = this.editor.getValue().replace(this.lastValue, newValue);
                        this.editor.setValue(text);
                        this.settings.onFileUploaded.call(this, filename);
                    }
                    return false;
                }
            });
        });
    </script>

    <script>
        var api_get_tag_like = '{{ route('api.get_tag_like') }}';

        $('select.search.dropdown').dropdown();
    </script>
    <script src="{{ asset('/js/tag.js') }}"></script>
@stop