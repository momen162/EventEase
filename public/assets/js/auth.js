function openAuthModal() {
  document.getElementById('authModal').style.display = 'flex';
}

function closeAuthModal() {
  document.getElementById('authModal').style.display = 'none';
}

function switchAuthTab(tab) {
  document.getElementById('loginTab').classList.remove('active');
  document.getElementById('registerTab').classList.remove('active');
  document.getElementById('loginForm').classList.remove('active');
  document.getElementById('registerForm').classList.remove('active');

  if (tab === 'login') {
    document.getElementById('loginTab').classList.add('active');
    document.getElementById('loginForm').classList.add('active');
  } else {
    document.getElementById('registerTab').classList.add('active');
    document.getElementById('registerForm').classList.add('active');
  }
}