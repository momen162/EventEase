// js for banner slider

// Hero Slider Script
let slideIndex = 0;
const heroSlides = document.querySelectorAll('.hero-slider .slide');

function rotateHeroSlides() {
  heroSlides.forEach(slide => slide.classList.remove('active'));
  heroSlides[slideIndex].classList.add('active');
  slideIndex = (slideIndex + 1) % heroSlides.length;
}

setInterval(rotateHeroSlides, 3000); // Change every 3 seconds
rotateHeroSlides(); // Show first slide

// javascript for filter option

document.addEventListener('DOMContentLoaded', () => {
  const filterRadios = document.querySelectorAll('input[name="eventStatus"]');
  const cards = document.querySelectorAll('.event-card');

  filterRadios.forEach(radio => {
    radio.addEventListener('change', () => {
      const selected = radio.value;

      cards.forEach(card => {
        const status = card.getAttribute('data-status');

        if (selected === 'all' || selected === status) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
});


//javascript for search filtering
document.addEventListener('DOMContentLoaded', () => {
  const filterRadios = document.querySelectorAll('input[name="eventStatus"]');
  const cards = document.querySelectorAll('.event-card');
  const searchBtn = document.getElementById('triggerSearch');
  const searchInput = document.getElementById('searchInput');

  function filterEvents() {
    const selectedStatus = document.querySelector('input[name="eventStatus"]:checked').value;
    const keyword = searchInput.value.toLowerCase();

    cards.forEach(card => {
      const status = card.getAttribute('data-status');
      const textContent = card.textContent.toLowerCase();

      const matchStatus = (selectedStatus === 'all' || selectedStatus === status);
      const matchKeyword = textContent.includes(keyword);

      card.style.display = (matchStatus && matchKeyword) ? 'block' : 'none';
    });
  }

  filterRadios.forEach(radio => {
    radio.addEventListener('change', filterEvents);
  });

// Search button click

  searchBtn.addEventListener('click', filterEvents);

  // Trigger on pressing Enter key

  searchInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
      e.preventDefault(); 
      filterEvents();
    }
  });
});







// real time filtering by debounce function

document.addEventListener('DOMContentLoaded', () => {
  const filterRadios = document.querySelectorAll('input[name="eventStatus"]');
  const cards = document.querySelectorAll('.event-card');
  const searchBtn = document.getElementById('triggerSearch');
  const searchInput = document.getElementById('searchInput');

  // Debounce function
  function debounce(fn, delay) {
    let timeout;
    return function () {
      clearTimeout(timeout);
      timeout = setTimeout(() => fn.apply(this, arguments), delay);
    };
  }

  function filterEvents() {
    const selectedRadio = document.querySelector('input[name="eventStatus"]:checked');
    const selectedStatus = selectedRadio ? selectedRadio.value : 'all';
    const keyword = searchInput.value.trim().toLowerCase();

    cards.forEach(card => {
      const status = card.getAttribute('data-status');
      const text = card.textContent.toLowerCase();
      const matchStatus = selectedStatus === 'all' || selectedStatus === status;
      const matchKeyword = text.includes(keyword);
      card.style.display = (matchStatus && matchKeyword) ? 'block' : 'none';
    });
  }

  // Use debounce for input typing
  const debouncedFilter = debounce(filterEvents, 300);

  // Event listeners
  filterRadios.forEach(radio => {
    radio.addEventListener('change', filterEvents);
  });

  searchBtn.addEventListener('click', filterEvents);

  searchInput.addEventListener('input', debouncedFilter); // Real-time with debounce

  searchInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
      e.preventDefault();
      filterEvents();
    }
  });
});





