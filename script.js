// Gestion des langues
const i18n = {
    fr: { /* ... contenu existant ... */ },
    en: { /* ... contenu existant ... */ },
    ar: { /* ... contenu existant ... */ }
};

function setLang(lang) {
    // ... votre fonction existante ...
    localStorage.setItem('lang', lang);
    location.reload(); // Recharger pour appliquer les changements si nécessaire
}

// Animation au Scroll (Reveal)
function reveal() {
    var reveals = document.querySelectorAll(".reveal");
    for (var i = 0; i < reveals.length; i++) {
        var windowHeight = window.innerHeight;
        var elementTop = reveals[i].getBoundingClientRect().top;
        var elementVisible = 150;
        if (elementTop < windowHeight - elementVisible) {
            reveals[i].classList.add("active");
        }
    }
}

window.addEventListener("scroll", reveal);

// Initialisation au chargement
document.addEventListener("DOMContentLoaded", function() {
    // 1. Détection du lien actif dans le menu
    let currentPath = window.location.pathname.split("/").pop();
    if (!currentPath || currentPath === "/") currentPath = "index.html";
    
    const navLinks = document.querySelectorAll(".nav-link");
    navLinks.forEach(link => {
        const href = link.getAttribute("href");
        if (href === currentPath) {
            link.classList.add("active");
        } else {
            link.classList.remove("active");
        }
    });

    // 2. Lancer le reveal pour les éléments déjà visibles
    reveal();

    // 3. Ajouter la classe reveal aux sections principales pour l'animation
    const sections = document.querySelectorAll("main > div, .info-card, .registration-container, form");
    sections.forEach(section => {
        section.classList.add("reveal");
    });
});
