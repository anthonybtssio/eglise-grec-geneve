const i18n = {
    fr: {
        'nav-home': "Accueil", 'nav-schedule': "Horaire", 'nav-location': "Localisation",
        'nav-events': "Événements", 'nav-docs': "Documents", 'nav-contact': "Contact",
        'nav-about': "À propos", 'nav-register': "Inscription", 'install-btn': "Appli",
        'share-btn': "Partager"
    },
    en: {
        'nav-home': "Home", 'nav-schedule': "Schedule", 'nav-location': "Location",
        'nav-events': "Events", 'nav-docs': "Documents", 'nav-contact': "Contact",
        'nav-about': "About", 'nav-register': "Register", 'install-btn': "App",
        'share-btn': "Share"
    },
    ar: {
        'nav-home': "الرئيسية", 'nav-schedule': "المواعيد", 'nav-location': "الموقع",
        'nav-events': "الفعاليات", 'nav-docs': "وثائق", 'nav-contact': "اتصل بنا",
        'nav-about': "من نحن", 'nav-register': "التسجيل", 'install-btn': "تطبيق",
        'share-btn': "شارك"
    }
};

// --- GESTION DU THÈME ---
function toggleTheme() {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    updateThemeIcon(newTheme);
}

function updateThemeIcon(theme) {
    const icon = document.querySelector('.theme-toggle i');
    if (icon) {
        icon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
    }
}

// --- GESTION DES LANGUES ---
function applyLang(lang) {
    const t = i18n[lang];
    if (!t) return;
    document.querySelectorAll('[data-i18n]').forEach(el => {
        const key = el.getAttribute('data-i18n');
        if (t[key]) el.innerHTML = t[key];
    });
    document.documentElement.lang = lang;
    document.documentElement.dir = (lang === 'ar') ? 'rtl' : 'ltr';
    document.querySelectorAll('.lang-btn').forEach(btn => btn.classList.toggle('active-lang', btn.id === 'btn-' + lang));
}

function setLang(lang) {
    localStorage.setItem('lang', lang);
    applyLang(lang);
}

document.addEventListener("DOMContentLoaded", function() {
    // Initialisation Langue
    applyLang(localStorage.getItem('lang') || 'fr');

    // Initialisation Thème
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);

    // Menu Actif
    const currentPath = window.location.pathname.split("/").pop() || "index.html";
    document.querySelectorAll(".nav-link, .tab-item").forEach(link => {
        if (link.getAttribute("href") === currentPath) link.classList.add("active");
    });

    // PWA Logic
    let deferredPrompt;
    const btnInstall = document.getElementById('btnInstall');
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        if (btnInstall) btnInstall.style.display = 'block';
    });

    // --- LOGIQUE DE PARTAGE (Web Share API) ---
    const shareBtns = document.querySelectorAll('.btn-share');
    shareBtns.forEach(btn => {
        btn.addEventListener('click', async () => {
            const lang = localStorage.getItem('lang') || 'fr';
            const shareData = {
                title: document.title || 'Antiochian Orthodox Geneva',
                text: i18n[lang]['welcome-title'] || 'Rejoins-nous !',
                url: window.location.href
            };

            if (navigator.share) {
                try {
                    await navigator.share(shareData);
                } catch (err) {
                    console.log('Partage annulé ou erreur');
                }
            } else {
                // Fallback : copier dans le presse-papier
                navigator.clipboard.writeText(window.location.href);
                const msg = (lang === 'ar') ? "تم نسخ الرابط!" : "Lien copié dans le presse-papier !";
                alert(msg);
            }
        });
    });
});
