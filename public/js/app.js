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
    e.target.focus();
    $(e.target).tooltip('show')
}

/*!
* Start Bootstrap - Simple Sidebar v6.0.3 (https://startbootstrap.com/template/simple-sidebar)
* Copyright 2013-2021 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-simple-sidebar/blob/master/LICENSE)
*/
//
// Scripts
//

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            console.log('hello')
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});
