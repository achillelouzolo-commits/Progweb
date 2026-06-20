function showSection(id) {
  document.querySelectorAll('.section').forEach(sec => {
    sec.classList.add('d-none');
  });

  document.getElementById(id).classList.remove('d-none');
}