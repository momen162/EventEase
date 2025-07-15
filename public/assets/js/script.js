// Example: mobile nav toggle or other dynamic features
document.addEventListener("DOMContentLoaded", () => {
  console.log("EventEase ready");
});

//Here we will add script.js code for hamburger click

 function toggleMenu() {
    document.getElementById('navMenu').classList.toggle('show');
    document.getElementById('loginSection').classList.toggle('show');
  }








  function openAuthModal() {
  document.getElementById('authModal').style.display = 'flex';
}
function closeAuthModal() {
  document.getElementById('authModal').style.display = 'none';
}
function switchAuthTab(tab) {
  const loginForm = document.getElementById('loginForm');
  const registerForm = document.getElementById('registerForm');
  if (tab === 'login') {
    loginForm.style.display = 'block';
    registerForm.style.display = 'none';
  } else {
    loginForm.style.display = 'none';
    registerForm.style.display = 'block';
  }
}













document.addEventListener('DOMContentLoaded', function () {
  const toggle = document.querySelector('.dropdown-toggle');
  const menu = document.querySelector('.dropdown-menu');

  if (toggle && menu) {
    toggle.addEventListener('click', function (e) {
      e.stopPropagation();
      this.parentElement.classList.toggle('show');
    });

    window.addEventListener('click', function (e) {
      if (!toggle.contains(e.target) && !menu.contains(e.target)) {
        toggle.parentElement.classList.remove('show');
      }
    });
  }
});




// View Details Toggle
document.querySelectorAll('.toggle-details').forEach(button => {
  button.addEventListener('click', function () {
    const details = this.closest('.event-card').querySelector('.event-details');
    if (details.style.display === 'block') {
      details.style.display = 'none';
      this.innerHTML = `<i class="bi bi-eye"></i> View Details`;
    } else {
      details.style.display = 'block';
      this.innerHTML = `<i class="bi bi-eye-slash"></i> Hide Details`;
    }
  });
});

