document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("contactForm");
  const status = document.getElementById("form-status");

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    // Simulate form submission
    status.textContent = "Sending...";
    status.style.color = "black";

    setTimeout(() => {
      status.textContent = "Your message has been sent successfully!";
      status.style.color = "green";
      form.reset();
    }, 1000);
  });
});
