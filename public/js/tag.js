function formatTag (tag) {
    return "<div class='select2-result-repository clearfix'>" +
    "<div class='select2-result-repository__meta'>" +
    "<div class='select2-result-repository__title'>" +
    tag.name ? tag.name : "InNote"   +
    "</div></div></div>";
}


function formatTagSelection (tag) {
    return tag.name || tag.text;
}


$(".js-example-placeholder-multiple").select2({
    tags: true,
    placeholder: ' 请选择标签',
    // minimumInputLength: 1,
    language: "zh-CN",         // 中文
    ajax: {
        url: api_get_tag_like,
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                q: params.term
            };
        },

        processResults: function (data, params) {
            return {
                results: data
            };
        },

        cache: true
    },

    templateResult: formatTag,

    templateSelection: formatTagSelection,

    escapeMarkup: function (markup) { return markup; }
});