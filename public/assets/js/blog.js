document.addEventListener("DOMContentLoaded", function () {
  // Handle Read More Toggle
  const buttons = document.querySelectorAll(".read-more-btn");

  buttons.forEach(button => {
    button.addEventListener("click", function () {
      const content = this.parentElement;
      const full = content.querySelector(".blog-full");
      const snippet = content.querySelector(".blog-snippet");

      if (full.style.display === "none") {
        full.style.display = "block";
        snippet.style.display = "none";
        this.textContent = "Read Less";
      } else {
        full.style.display = "none";
        snippet.style.display = "block";
        this.textContent = "Read More";
      }
    });
  });

  // Display Today's Date
  const todayDate = document.getElementById("today-date");
  const today = new Date();
  todayDate.textContent = today.toDateString(); // e.g. Wed Jul 10 2025
});
