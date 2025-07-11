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
