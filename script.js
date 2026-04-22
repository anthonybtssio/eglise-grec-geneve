// Initialisation au chargement
document.addEventListener("DOMContentLoaded", function() {
    // 1. Détection du lien actif dans le menu
    const currentPath = window.location.pathname.split("/").pop() || "index.html";
    const navLinks = document.querySelectorAll(".nav-link");
    
    navLinks.forEach(link => {
        const href = link.getAttribute("href");
        if (href === currentPath) {
            link.classList.add("active");
        } else {
            link.classList.remove("active");
        }
    });

    // Gestion des langues (si nécessaire)
    const savedLang = localStorage.getItem('lang') || 'fr';
    // setLang(savedLang); // À activer si vous utilisez le système i18n
});

function setLang(lang) {
    localStorage.setItem('lang', lang);
    location.reload();
}
