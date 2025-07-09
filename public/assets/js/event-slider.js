document.addEventListener("DOMContentLoaded", () => {
  const track = document.getElementById("eventTypeTrack");
  const scrollWrapper = document.getElementById("eventTypeScroll");
  const prevBtn = document.getElementById("eventTypePrev");
  const nextBtn = document.getElementById("eventTypeNext");

  let autoScrollInterval;
  let itemWidth;
  let index = 0;

  const items = track.children;
  const totalItems = items.length;

  // Clone first and last few items for infinite effect
  function cloneItems() {
    const clonesBefore = [];
    const clonesAfter = [];

    for (let i = 0; i < 5; i++) {
      clonesBefore.push(items[totalItems - 1 - i].cloneNode(true));
      clonesAfter.push(items[i].cloneNode(true));
    }

    clonesBefore.reverse().forEach(clone => track.insertBefore(clone, track.firstChild));
    clonesAfter.forEach(clone => track.appendChild(clone));
  }

  // Set item width and track transform
  function updateDimensions() {
    const item = track.querySelector(".event-type-item");
    itemWidth = item.offsetWidth + 40; // item + gap
    index = 5; // skip cloned items
    track.style.transform = `translateX(-${itemWidth * index}px)`;
  }

  // Scroll handler
  function scrollToIndex() {
    track.style.transition = "transform 0.5s ease";
    track.style.transform = `translateX(-${itemWidth * index}px)`;
  }

  // Reset transform if at clone boundary
  function checkInfiniteLoop() {
    if (index >= totalItems + 5) {
      index = 5;
      track.style.transition = "none";
      track.style.transform = `translateX(-${itemWidth * index}px)`;
    }
    if (index < 5) {
      index = totalItems + 4;
      track.style.transition = "none";
      track.style.transform = `translateX(-${itemWidth * index}px)`;
    }
  }

  // Auto Scroll
  function startAutoScroll() {
    autoScrollInterval = setInterval(() => {
      index++;
      scrollToIndex();
    }, 2000);
  }

  function stopAutoScroll() {
    clearInterval(autoScrollInterval);
  }

  // Init
  cloneItems();
  updateDimensions();
  startAutoScroll();

  // Resize support
  window.addEventListener("resize", updateDimensions);

  // Manual controls
  nextBtn.addEventListener("click", () => {
    stopAutoScroll();
    index++;
    scrollToIndex();
  });

  prevBtn.addEventListener("click", () => {
    stopAutoScroll();
    index--;
    scrollToIndex();
  });

  // Infinite reset on transition end
  track.addEventListener("transitionend", checkInfiniteLoop);

  // Pause on hover
  scrollWrapper.addEventListener("mouseover", stopAutoScroll);
  scrollWrapper.addEventListener("mouseleave", startAutoScroll);
});
