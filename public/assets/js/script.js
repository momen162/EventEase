// Example: mobile nav toggle or other dynamic features
document.addEventListener("DOMContentLoaded", () => {
  console.log("EventEase ready");
});


// Fade in footer on scroll (optional)
document.addEventListener('DOMContentLoaded', () => {
  const footer = document.querySelector('.footer');
  footer.style.opacity = 0;
  footer.style.transition = 'opacity 1s ease';

  window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
      footer.style.opacity = 1;
    } else {
      footer.style.opacity = 0.8;
    }
  });
});
