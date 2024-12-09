// fungsi navbar responsif
document.addEventListener("DOMContentLoaded", function () {
  const toggleButton = document.querySelector(".tombol");
  const menu = document.querySelector(".menu");
  const dropdownToggles = document.querySelectorAll(".dropdown-toggle");

  toggleButton.addEventListener("click", function () {
    menu.classList.toggle("aktif");
  });

  dropdownToggles.forEach((toggle) => {
    toggle.addEventListener("click", function (e) {
      e.preventDefault();
      this.parentElement.classList.toggle("active");
    });
  });
});

// fungsi navbar responsif end

// script.js
document.addEventListener("DOMContentLoaded", () => {
  console.log("Portal berita siap digunakan.");
});
