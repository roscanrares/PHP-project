const toggleButton = document.querySelector(".toggle-bar");
const navLinks = document.querySelector(".nav-links");

toggleButton.addEventListener("click", () => {
  if (navLinks.style.display === "block") {
    navLinks.style.display = "none";
  } else {
    navLinks.style.display = "block";
  }
});

document.addEventListener("DOMContentLoaded", () => {
  const toggleButton = document.querySelector(".toggle-bar");
  const navLinks = document.querySelector(".nav-links");

  if (toggleButton && navLinks) {
    toggleButton.addEventListener("click", () => {
      if (navLinks.style.display === "block") {
        navLinks.style.display = "none";
      } else {
        navLinks.style.display = "block";
      }
    });
  }
});
