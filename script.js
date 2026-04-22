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

    // 2. Logique d'installation PWA
    let deferredPrompt;
    const installContainer = document.getElementById('installContainer');
    const btnInstall = document.getElementById('btnInstall');

    window.addEventListener('beforeinstallprompt', (e) => {
        // Empêcher Chrome d'afficher la bannière automatique
        e.preventDefault();
        // Garder l'événement pour plus tard
        deferredPrompt = e;
        // Afficher notre propre bouton
        if (installContainer) installContainer.style.display = 'block';
    });

    if (btnInstall) {
        btnInstall.addEventListener('click', async () => {
            if (deferredPrompt) {
                // Afficher la boîte de dialogue d'installation
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                // On cache le bouton après le choix
                deferredPrompt = null;
                if (installContainer) installContainer.style.display = 'none';
            }
        });
    }

    // Cacher le bouton si l'app est déjà installée
    window.addEventListener('appinstalled', () => {
        if (installContainer) installContainer.style.display = 'none';
        deferredPrompt = null;
    });
});

function setLang(lang) {
    localStorage.setItem('lang', lang);
    location.reload();
}
