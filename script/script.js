$(document).ready(function() {
    // Make current web page active
    var currentPageURL = window.location.href;
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
            url: "process/index_process.php",
            method: "POST",
            data: { action: "add_favorite", movieID: movieID, accountID: accountID },
            success: function(respond) {
                alert("Movie added successfully");
            },
            error: function(){
                alert("error");
            }
        });
    });

    // SetRatingStar function and related code
    var rate = 0;
    var $star_rating = $('.star-rating .fa');

    var SetRatingStar = function() {
        return $star_rating.each(function() {
            if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
                return $(this).removeClass('fa-star-o').addClass('fa-star');
            } else {
                return $(this).removeClass('fa-star').addClass('fa-star-o');
            }
        });
    };

    $star_rating.on('click', function() {
        rate = $(this).data('rating');
        $star_rating.siblings('input.rating-value').val(rate);
        return SetRatingStar();
    });

    SetRatingStar();

  /*for search page*/

document.getElementById('searchInput').addEventListener('input', function() {
    var search = this.value;
    document.getElementById('hints').innerText = 'Search: ' + search;

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'process/search_process.php?search=' + search, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var movies = JSON.parse(xhr.responseText);
            var searchResult = document.querySelector('.search-result');
            searchResult.innerHTML = '';
            movies.forEach(function(movie) {
                var resultItem = '<div class="result-item">';
                resultItem += '<div class="movie-item">';
                resultItem += '<div class="poster"><img src="graphics/' + movie.poster + '.jpg" alt="Movie Poster" data-movie-id="' + movie.movieID + '" data-movie-name="' + movie.mname + '"></div>';
                resultItem += '<div class="info">';
                resultItem += '<div class="name"><strong>' + movie.mname + '</strong></div>';
                resultItem += '<div class="releaseDate"> ' + movie.releaseDate + '</div>';
                resultItem += '<div class="runtime"><strong>Runtime:</strong> ' + movie.runtime + '</div>';
                resultItem += '<div class="director"><strong>Director:</strong> ' + movie.director + '</div>';
                resultItem += '<div class="starring"><strong>Starring:</strong> ' + movie.starring + '</div>';
                resultItem += '</div>';
                resultItem += '</div>';
                resultItem += '</div>';
                searchResult.innerHTML += resultItem;
            });

            var posters = document.querySelectorAll('.poster img');
            posters.forEach(function(poster) {
                poster.addEventListener('mouseover', function() {
                    this.style.cursor = 'pointer';
                    this.style.border = '2px solid red';
                });
                poster.addEventListener('mouseout', function() {
                    this.style.border = 'none';
                });
                poster.addEventListener('click', function() {
                    var movieID = this.getAttribute('data-movie-id');
                    var movieName = this.getAttribute('data-movie-name');

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'process/search_process.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            window.location.href = 'details.php';
                        }
                    };
                    xhr.send('movieID=' + movieID + '&mname=' + movieName);
                });
            });
        }
    };
    xhr.send();
    });
});
    


