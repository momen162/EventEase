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




