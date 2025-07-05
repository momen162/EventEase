document.addEventListener('DOMContentLoaded', () => {
  const slides = document.querySelectorAll('.slide-link');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const dotContainer = document.getElementById('sliderDots');
  let currentIndex = 0;
  let slideInterval;

  // Generate dot indicators
  slides.forEach((_, i) => {
    const dot = document.createElement('div');
    dot.classList.add('slider-dot');
    if (i === 0) dot.classList.add('active');
    dot.addEventListener('click', () => {
      stopAutoSlide();
      showSlide(i);
      startAutoSlide();
    });
    dotContainer.appendChild(dot);
  });

  const dots = document.querySelectorAll('.slider-dot');

  function showSlide(index) {
    slides.forEach(slide => {
      slide.classList.remove('active');
      slide.style.display = 'none';
    });
    slides[index].classList.add('active');
    slides[index].style.display = 'block';

    dots.forEach(dot => dot.classList.remove('active'));
    dots[index].classList.add('active');

    currentIndex = index;
  }

  function nextSlide() {
    const newIndex = (currentIndex + 1) % slides.length;
    showSlide(newIndex);
  }

  function prevSlide() {
    const newIndex = (currentIndex - 1 + slides.length) % slides.length;
    showSlide(newIndex);
  }

  function startAutoSlide() {
    slideInterval = setInterval(nextSlide, 3000);
  }

  function stopAutoSlide() {
    clearInterval(slideInterval);
  }

  if (slides.length > 0) {
    showSlide(currentIndex);
    startAutoSlide();

    nextBtn.addEventListener('click', () => {
      stopAutoSlide();
      nextSlide();
      startAutoSlide();
    });

    prevBtn.addEventListener('click', () => {
      stopAutoSlide();
      prevSlide();
      startAutoSlide();
    });
  }
});


//FAQ

document.addEventListener('DOMContentLoaded', () => {
  const faqItems = document.querySelectorAll('.faq-item');

  faqItems.forEach(item => {
    const question = item.querySelector('.faq-question');
    const answer = item.querySelector('.faq-answer');
    const icon = item.querySelector('.icon');

    question.addEventListener('click', () => {
      const isOpen = item.classList.contains('active');

      // Close all other FAQs
      faqItems.forEach(faq => {
        faq.classList.remove('active');
        faq.querySelector('.faq-answer').style.maxHeight = null;
        faq.querySelector('.faq-answer').style.opacity = 0;
        faq.querySelector('.icon').textContent = '+';
      });

      // Open this one if it wasn't already open
      if (!isOpen) {
        item.classList.add('active');
        answer.style.maxHeight = answer.scrollHeight + "px";
        answer.style.opacity = 1;
        icon.textContent = '–';
      }
    });
  });
});
