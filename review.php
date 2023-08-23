<?php
session_start(); 

$movieID = $_GET['movieID'];
$movieName = urldecode($_GET['movieName']);
$accountID = $_SESSION['accountID']; 
?>
<!DOCTYPE html>
<html>
<head>
     <?php include "pagesParts/head.php"; ?>
    <?php include "db_connection.php"; ?> 
    <script>
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
    $(document).ready(function() {
      $('.review-submit').on('click', function() {
        var description = $('.review').val();
        $.ajax({
          url: 'process/review_process.php',
          type: 'POST',
          data: {
            movieID: <?php echo $movieID; ?>,
            accountID: <?php echo $accountID; ?>,
            description: description,
            rate: rate
          },
          success: function(response) {
            alert('Review <?php echo $movieName;?>  submitted successfully');
          }
        });
      });
    });
    </script> 
</head>
<body>
    <div class="review-form">
        <div class="review-container movie-info">
            <div class="review-info"><?php echo $movieName; ?></div>
        </div>
        <div class="horizontal-line"></div>
        <div class="container rating">
            <div class="section-heading">Your Rating</div>
           <div class="container">
              <div class="row">
                <div class="col-lg-12">
                  <div class="star-rating">
                    <span class="fa fa-star-o" data-rating="1"></span>
                    <span class="fa fa-star-o" data-rating="2"></span>
                    <span class="fa fa-star-o" data-rating="3"></span>
                    <span class="fa fa-star-o" data-rating="4"></span>
                    <span class="fa fa-star-o" data-rating="5"></span>
                    <input type="hidden" name="whatever1" class="rating-value" value="2.56">
                  </div>
                </div>
              </div>
            </div>
        </div>
        <textarea class="review" placeholder="Write your review here"></textarea>
        <button class="review-submit">Submit</button>
    </div>
</body>
</html>
