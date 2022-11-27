<!DOCTYPE html>
<html lang="en">
@include("layout.header")
<body>
@section('title','Tutorials')
@include("layout.menu")




<!--============================= Main Content =============================-->
{!! $tutorial->description !!}




<!--============================= Scripts =============================-->
<a href="#" class="back-to-top" style="display: none;"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>

<script>            
jQuery(document).ready(function() {
  var offset = 220;
  var duration = 500;
  jQuery(window).scroll(function() {
    if (jQuery(this).scrollTop() > offset) {
      jQuery('.back-to-top').fadeIn(duration);
    } else {
      jQuery('.back-to-top').fadeOut(duration);
    }
  });
  
  jQuery('.back-to-top').click(function(event) {
    event.preventDefault();
    jQuery('html, body').animate({scrollTop: 0}, duration);
    return false;
  })
});
</script> 


<script>
  $('.testimonial').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    autoplay:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:2
        }
    }
})
</script>

<script>
  // Get the HTML element you need.
const imageOverlay = document.getElementById('image-overlay')
const playButton = document.getElementById('play')

// Add the event listener for the play button.
playButton.addEventListener('click', play)

// The function that is called when the button is clicked.
function play(e) {
  e.preventDefault();

  // Hide the overlay and button and start playing the video.
  playButton.style.display = 'none';
  imageOverlay.style.display = 'none';

  const tag = document.createElement('script');
  tag.src = "https://www.youtube.com/player_api";
  const firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  let player;
  window.onYouTubePlayerAPIReady = function () {
    player = new YT.Player('ytplayer', {
      height: '315',
      width: '560',
      videoId: 'D0UnqGm_miA',
      events: {
        'onReady': onPlayerReady,
      },
      playerVars: {
        // 'controls': 0, // If you would like to hide the controls, uncomment this line.
      },
    });
  }

  function onPlayerReady() {
    player.playVideo();
  }
}
</script>
@include("layouts.footer")