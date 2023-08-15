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

    // JavaScript function to add favorite
 $("body").on("click", ".add_movie", function(event) {
        event.preventDefault();
        var movieID = $(this).attr('mid');
        var accountID = $(this).attr('accountID');
        $.ajax({
            url: "process/index_process.php?action=add_favorite",
            method: "POST",
            data: { movieID: movieID, accountID: accountID },
            success: function(data) {
                alert(data);
            }
        });
    });
    
    
    
    //update session    
    function updateSession(movieID, mname) {
    $.ajax({
        url: 'process/index_process.php',
        type: 'POST',
        data: { movieID: movieID, mname: mname },
        success: function(response) {
            console.log(response);
            // Navigate to details.php after session update
            window.location.href = '../details.php?movieID=' + movieID;
        }
    });
}
    
});