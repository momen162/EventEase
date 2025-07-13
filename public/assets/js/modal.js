document.addEventListener("DOMContentLoaded", function () {
  const openBtn = document.getElementById("openTermsModal");
  const closeBtn = document.getElementById("closeTermsModal");
  const modal = document.getElementById("termsModal");

  openBtn.addEventListener("click", function (e) {
    e.preventDefault();
    modal.style.display = "block";
  });

  closeBtn.addEventListener("click", function () {
    modal.style.display = "none";
  });

  window.addEventListener("click", function (e) {
    if (e.target === modal) {
      modal.style.display = "none";
    }
  });
});











function openAuthModal() {
  document.getElementById("authModal").style.display = "flex";
  switchAuthTab('login'); // default tab
}

function closeAuthModal() {
  document.getElementById("authModal").style.display = "none";
}

function switchAuthTab(tab) {
  const loginForm = document.getElementById("loginForm");
  const registerForm = document.getElementById("registerForm");

  document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));

  if (tab === 'login') {
    loginForm.style.display = 'block';
    registerForm.style.display = 'none';
    document.querySelectorAll('.tab-btn')[0].classList.add('active');
  } else {
    loginForm.style.display = 'none';
    registerForm.style.display = 'block';
    document.querySelectorAll('.tab-btn')[1].classList.add('active');
  }
}
