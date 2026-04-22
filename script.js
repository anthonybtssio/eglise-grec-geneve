// Dictionnaire de traduction complet (Toutes les pages)
const i18n = {
    fr: {
        'welcome-title': "Bienvenue à l'Église Antiochienne",
        'card-schedule-title': "Horaires des messes",
        'card-location-title': "Localisation",
        'card-event-title': "Prochain événement",
        'nav-home': "Accueil",
        'nav-schedule': "Horaire",
        'nav-location': "Localisation",
        'nav-events': "Événements",
        'nav-docs': "Documents",
        'nav-contact': "Contact",
        'nav-about': "À propos",
        'nav-register': "Inscription"
    },
    en: {
        'welcome-title': "Welcome to the Antiochian Church",
        'card-schedule-title': "Mass Schedule",
        'card-location-title': "Location",
        'card-event-title': "Next Event",
        'nav-home': "Home",
        'nav-schedule': "Schedule",
        'nav-location': "Location",
        'nav-events': "Events",
        'nav-docs': "Documents",
        'nav-contact': "Contact",
        'nav-about': "About",
        'nav-register': "Register"
    },
    ar: {
        'welcome-title': "مرحباً بكم في الكنيسة الأنطاكية",
        'card-schedule-title': "مواقit القداسات",
        'card-location-title': "الموقع",
        'card-event-title': "الحدث القادم",
        'nav-home': "الرئيسية",
        'nav-schedule': "المواعيد",
        'nav-location': "الموقع",
        'nav-events': "الفعاليات",
        'nav-docs': "وثائق",
        'nav-contact': "اتصل بنا",
        'nav-about': "من نحن",
        'nav-register': "التسجيل"
    }
};

function setLang(lang) {
    localStorage.setItem('lang', lang);
    applyLang(lang);
}

function applyLang(lang) {
    const t = i18n[lang];
    if (!t) return;
    
    // Appliquer aux textes avec data-i18n
    document.querySelectorAll('[data-i18n]').forEach(el => {
        const key = el.getAttribute('data-i18n');
        if (t[key]) el.innerHTML = t[key];
    });

    document.documentElement.lang = lang;
    document.documentElement.dir = (lang === 'ar') ? 'rtl' : 'ltr';
    
    // Activer le bon bouton
    document.querySelectorAll('.lang-btn').forEach(btn => btn.classList.remove('active-lang'));
    const activeBtn = document.getElementById('btn-' + lang);
    if (activeBtn) activeBtn.classList.add('active-lang');
}

document.addEventListener("DOMContentLoaded", function() {
    // 1. Appliquer langue sauvegardée
    const savedLang = localStorage.getItem('lang') || 'fr';
    applyLang(savedLang);

    // 2. Détecter lien actif
    const currentPath = window.location.pathname.split("/").pop() || "index.html";
    document.querySelectorAll(".nav-link").forEach(link => {
        if (link.getAttribute("href") === currentPath) link.classList.add("active");
    });

    // 3. Logique PWA
    let deferredPrompt;
    const btnInstall = document.getElementById('btnInstall');
    const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
    const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone;

    if (btnInstall) {
        if (isIOS && !isStandalone) {
            btnInstall.style.display = 'block';
            btnInstall.addEventListener('click', () => {
                alert("Installation sur iPhone :\n1. Appuyez sur 'Partager' (carré avec flèche en bas).\n2. Choisissez 'Sur l'écran d'accueil'.");
            });
        }
    }

    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        if (btnInstall) btnInstall.style.display = 'block';
    });

    if (btnInstall) {
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
