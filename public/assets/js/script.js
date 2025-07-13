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
