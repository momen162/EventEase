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
