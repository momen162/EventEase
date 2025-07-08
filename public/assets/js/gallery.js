document.addEventListener("DOMContentLoaded", () => {
  const images = document.querySelectorAll(".gallery-img");
  const modal = document.getElementById("lightbox-modal");
  const modalImg = document.getElementById("lightbox-img");
  const closeBtn = document.querySelector(".close-btn");

  images.forEach(img => {
    img.addEventListener("click", () => {
      modal.style.display = "block";
      modalImg.src = img.src;
    });
  });

  closeBtn.addEventListener("click", () => {
    modal.style.display = "none";
  });

  modal.addEventListener("click", (e) => {
    if (e.target === modal) {
      modal.style.display = "none";
    }
  });
});
