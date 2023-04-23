let slideIndex = 1;
let slideTimer = null;

showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  if (slideTimer) {
    clearTimeout(slideTimer);
    slideTimer = null;
  }
  showSlides((slideIndex += n));
}

// Thumbnail image controls
function currentSlide(n) {
  if (slideTimer) {
    clearTimeout(slideTimer);
    slideTimer = null;
  }
  showSlides((slideIndex = n));
}

function startSlideTimer() {
  if (slideTimer) {
    clearTimeout(slideTimer);
  }
  slideTimer = setTimeout(function () {
    plusSlides(1);
    startSlideTimer();
  }, 5000); // Change this value to set the time between automatic slide changes
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  if (n > slides.length) {
    slideIndex = 1;
  }
  if (n < 1) {
    slideIndex = slides.length;
  }
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex - 1].style.display = "block";
  dots[slideIndex - 1].className += " active";

  // Start the slide timer
  startSlideTimer();
}
