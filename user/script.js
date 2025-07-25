function toggleSearch() {
  const input = document.querySelector(".search-input");
  input.classList.toggle("active");
  if (input.classList.contains("active")) {
    input.focus();
  } else {
    input.value = "";
  }
}
