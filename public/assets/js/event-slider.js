document.addEventListener("DOMContentLoaded", () => {
  const scrollContainer = document.getElementById("eventTypeScroll");
  const nextBtn = document.getElementById("eventTypeNext");
  const prevBtn = document.getElementById("eventTypePrev");

  let itemWidth = 120; // Adjust based on your item + gap size
  let autoScrollInterval;

  // Manual controls
  nextBtn.addEventListener("click", () => {
    scrollContainer.scrollBy({ left: itemWidth, behavior: "smooth" });
  });

  prevBtn.addEventListener("click", () => {
    scrollContainer.scrollBy({ left: -itemWidth, behavior: "smooth" });
  });

  // Auto-scroll function
  function autoScroll() {
    autoScrollInterval = setInterval(() => {
      scrollContainer.scrollBy({ left: itemWidth, behavior: "smooth" });

      // Loop back if near the end
      if (
        scrollContainer.scrollLeft + scrollContainer.offsetWidth >=
        scrollContainer.scrollWidth - itemWidth
      ) {
        scrollContainer.scrollTo({ left: 0, behavior: "smooth" });
      }
    }, 2000);
  }

  // Start auto scroll
  autoScroll();

  // Optional: Pause auto-scroll on hover
  scrollContainer.addEventListener("mouseover", () => clearInterval(autoScrollInterval));
  scrollContainer.addEventListener("mouseleave", autoScroll);
});
