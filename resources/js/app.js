function copyToClipboard(data) {
    var dummy = document.createElement("textarea");

    document.body.appendChild(dummy);

    dummy.value = data;

    if (navigator.userAgent.match(/ipad|ipod|iphone/i)) {

        dummy.contentEditable = true;

        dummy.readOnly = true;

        var range = document.createRange();

        range.selectNodeContents(dummy);

        var selection = window.getSelection();

        selection.removeAllRanges();

        selection.addRange(range);

        el.setSelectionRange(0, 999999);

    }

    else {

        dummy.select();

    }

    document.execCommand("copy");

    document.body.removeChild(dummy);

}

function showTooltip(e) {
    $('[data-toggle=tooltip]').tooltip('hide')
    e.target.focus();
    $(e.target).closest('[data-toggle=tooltip]').tooltip('show')
}

$(document).ready(function() {
    $('[role=form-submit]').click(function (e) {
        e.preventDefault();

        const target = $(this).attr('target-form');

        $(target).submit();
    })

    $('[back-link]').on('click', function(e) {
        e.preventDefault();

        history.back()
    })
})
