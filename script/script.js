//make current web page active 
$(document).ready(function() {
    // Get the current page URL
    var currentPageURL = window.location.href;

    // Loop through each nav link and check if its href matches the current page URL
    $('.navbar-nav li a').each(function() {
        var linkURL = $(this).attr('href');
        if (currentPageURL.indexOf(linkURL) !== -1) {
            $(this).parent().addClass('active'); 
        }
    });
});