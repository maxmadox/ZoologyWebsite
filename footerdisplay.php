<footer class="zoology-footer">
  <div class="footertop">
   
    <div class="footer-item top-left">
      <h4>Address</h4>
      <p>Kirodimal Govt. Arts & Science College <br> Raigarh, Chhattisgarh 496001</p>
    </div>

    <div class="footer-item top-center">
      <h4>Contact</h4>
      <p>Email: <a href="mailto:kgcraigarh1958@gmail.com">kgcraigarh1958@gmail.com</a></p>
      <p>Phone: +91 0776 2222966</p>
    </div>

    <div class="footer-item top-right">
      <h4>Quick Links</h4>
      <ul>
        <li><a href="resources.php">Resources</a></li>
        <li><a href="courses.php">Courses</a></li>
        <li><a href="faculty.php">Faculty</a></li>
      </ul>
    </div>
</div>
    <div class="footerbottom">

 
    <div class="footer-item bottom-left">
      &copy; 2025 Zoology Department,<br> Kirodimal Govt. Arts & Science College, Raigarh
    </div>

    <div class="footer-item bottom-center">
      <div class="footer-department">Zoology Department</div>
    </div>

    <div class="footer-item bottom-right">
      <div class="footer-social">
        <a href="#" aria-label="Instagram"><img src="content/social/instagram.svg" alt="Instagram"></a>
        <a href="#" aria-label="LinkedIn"><img src="content/social/linkedin.svg" alt="LinkedIn"></a>
        <a href="#" aria-label="Facebook"><img src="content/social/facebook.svg" alt="Facebook"></a>
        <a href="#" aria-label="YouTube"><img src="content/social/youtube.svg" alt="YouTube"></a>
      </div>
    </div>
  </div>
</footer>



</body>
</html>

<script>
const hamburger = document.querySelector('.hamburger');
const mobileMenu = document.querySelector('.mobile-nav');

if (hamburger && mobileMenu) {
    hamburger.addEventListener('click', () => {
        mobileMenu.classList.toggle('active');
    });
}
</script>



<script>
const slider = document.querySelector('.intro-faculty-list');


let isDown = false;
let startX;
let scrollLeft;

slider.addEventListener('mousedown', (e) => {
  isDown = true;
  slider.classList.add('active');
  startX = e.pageX - slider.offsetLeft;
  scrollLeft = slider.scrollLeft;
});

slider.addEventListener('mouseleave', () => { isDown = false; slider.classList.remove('active'); });
slider.addEventListener('mouseup', () => { isDown = false; slider.classList.remove('active'); });

slider.addEventListener('mousemove', (e) => {
  if (!isDown) return;
  e.preventDefault();
  const x = e.pageX - slider.offsetLeft;
  const walk = (x - startX) * 2; 
  slider.scrollLeft = scrollLeft - walk;
});


slider.addEventListener('wheel', (e) => {
  e.preventDefault();
  slider.scrollLeft += e.deltaY; 
});
</script>



<script>
const slides = document.querySelectorAll('.index-gallery-slide');
let currentIndex = 0;
let slideInterval = setInterval(nextSlide, 2000); 

function nextSlide() {
    slides[currentIndex].classList.remove('active');
    currentIndex = (currentIndex + 1) % slides.length;
    slides[currentIndex].classList.add('active');
}

function prevSlide() {
    slides[currentIndex].classList.remove('active');
    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
    slides[currentIndex].classList.add('active');
}


if(slides.length) slides[0].classList.add('active');


let startX = 0;
let endX = 0;
const slider = document.querySelector('.index-gallery-slider');

slider.addEventListener('touchstart', (e) => {
    startX = e.touches[0].clientX;
});

slider.addEventListener('touchend', (e) => {
    endX = e.changedTouches[0].clientX;
    if (startX - endX > 50) { 
        nextSlide();
        resetInterval();
    } else if (endX - startX > 50) { 
        prevSlide();
        resetInterval();
    }
});

function resetInterval() {
    clearInterval(slideInterval);
    slideInterval = setInterval(nextSlide, 2000);
}
</script>
