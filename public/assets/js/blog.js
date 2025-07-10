document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll(".read-more-btn");

  buttons.forEach(button => {
    button.addEventListener("click", function () {
      const card = this.closest(".blog-card");
      card.classList.toggle("expanded");
      this.textContent = card.classList.contains("expanded") ? "Read Less" : "Read More";
    });
  });
});
