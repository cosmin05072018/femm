// Selectăm elementul #accordionSidebar
var sidebar = document.getElementById('accordionSidebar');
// Adăugăm clasa toggled pe click sau pe schimbarea dimensiunii ecranului
if (window.innerWidth <= 768) {
    sidebar.classList.add('toggled');
}
