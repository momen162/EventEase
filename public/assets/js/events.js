document.addEventListener('DOMContentLoaded', function () {
  const filters = document.querySelectorAll('input[name="eventStatus"]');
  const cards = document.querySelectorAll('.event-card');

  const map = {
    all: 'all',
    live: 'ongoing',
    upcoming: 'upcoming'
  };

  filters.forEach(filter => {
    filter.addEventListener('change', () => {
      const selected = filter.value;

      cards.forEach(card => {
        const status = card.dataset.status;

        if (map[selected] === 'all' || status === map[selected]) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
});
