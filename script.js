// Initialisation au chargement
document.addEventListener("DOMContentLoaded", function() {
    // 1. Détection du lien actif
    const currentPath = window.location.pathname.split("/").pop() || "index.html";
    document.querySelectorAll(".nav-link").forEach(link => {
        if (link.getAttribute("href") === currentPath) link.classList.add("active");
    });

    // 2. Logique PWA (Android & iOS)
    let deferredPrompt;
    const btnInstall = document.getElementById('btnInstall');

    // Détection iOS
    const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
    const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone;

    // Afficher le bouton sur iOS s'il n'est pas déjà installé
    if (isIOS && !isStandalone && btnInstall) {
        btnInstall.style.display = 'block';
        btnInstall.addEventListener('click', () => {
            alert("Pour installer l'appli sur votre iPhone :\n\n1. Appuyez sur l'icône 'Partager' en bas de votre écran (le carré avec une flèche).\n2. Faites défiler et choisissez 'Sur l'écran d'accueil'.");
        });
    }

    // Logique pour Android / Chrome
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        if (btnInstall) btnInstall.style.display = 'block';
    });

    if (btnInstall && !isIOS) {
        btnInstall.addEventListener('click', async () => {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                if (outcome === 'accepted') btnInstall.style.display = 'none';
                deferredPrompt = null;
            }
        });
    }
});

function setLang(lang) {
    localStorage.setItem('lang', lang);
    location.reload();
}
