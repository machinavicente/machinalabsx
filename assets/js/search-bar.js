document.addEventListener('DOMContentLoaded', (event) => {
  const searchBar = document.getElementById('search_bar');
  if (searchBar !== null) {
    searchBar.addEventListener('input', (e) => {
      const searchTerm = e.target.value.toLowerCase(); // Convertir a minúsculas
      document.querySelectorAll('.card').forEach((item) => {
        const itemText = item.textContent.toLowerCase(); // También convertir a minúsculas
        if (itemText.includes(searchTerm)) {
           item.style.display = 'block'; // Muestra el elemento
        } else {
          item.style.display = 'none'; // Oculta el elemento
        }
      });
    });
  }
});