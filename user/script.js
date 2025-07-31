function toggleDropdown() {
  const menu = document.getElementById("roleDropdown");
  menu.style.display = menu.style.display === "block" ? "none" : "block";
}

window.addEventListener("click", function (e) {
  const dropdown = document.getElementById("roleDropdown");
  const icon = document.querySelector(".account");

  if (!dropdown.contains(e.target) && e.target !== icon) {
    dropdown.style.display = "none";
  }
});
