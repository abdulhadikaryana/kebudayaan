$(document).ready(function() {
    $('#menu-2').mouseenter(function() {
        $('#sub-menu').show(300);
    })
    $('#menu-2').mouseleave(function() {
        $('#sub-menu').hide(300);
    })
});
$(function(){
    var url = window.location.pathname,
        urlRegExp = new RegExp(url.replace(/\/$/,'') + "$"); // create regexp to match current url pathname and remove trailing slash if present as it could collide with the link in navigation in case trailing slash wasn't present there
    // now grab every link from the navigation
    $('#menu-row-3 a').each(function(){
        // and test its normalized href against the url pathname regexp
        if(urlRegExp.test(this.href.replace(/\/$/,''))){
            $(this).addClass('active-menu');
        }
    });

});
