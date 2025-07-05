document.addEventListener('DOMContentLoaded', () => {
  const slideLinks = document.querySelectorAll('.slide-link');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  let currentIndex = 0;
  let slideInterval;

  function showSlide(index) {
    slideLinks.forEach(link => link.classList.remove('active'));
    slideLinks[index].classList.add('active');
  }

  function nextSlide() {
    currentIndex = (currentIndex + 1) % slideLinks.length;
    showSlide(currentIndex);
  }

  function prevSlide() {
    currentIndex = (currentIndex - 1 + slideLinks.length) % slideLinks.length;
    showSlide(currentIndex);
  }

  function startAutoSlide() {
    slideInterval = setInterval(nextSlide, 3000);
  }

  function stopAutoSlide() {
    clearInterval(slideInterval);
  }

  prevBtn.addEventListener('click', () => {
    stopAutoSlide();
    prevSlide();
    startAutoSlide();
  });

  nextBtn.addEventListener('click', () => {
    stopAutoSlide();
    nextSlide();
    startAutoSlide();
  });

  showSlide(currentIndex);
  startAutoSlide();
});
