const i18n = {
    fr: {
        'nav-home': "Accueil", 'nav-schedule': "Horaire", 'nav-location': "Localisation",
        'nav-events': "Événements", 'nav-docs': "Documents", 'nav-contact': "Contact",
        'nav-about': "À propos", 'nav-register': "Inscription",
        'welcome-title': "Bienvenue à l'Église Antiochienne",
        'card-schedule-title': "Horaires des messes",
        'card-location-title': "Localisation",
        'card-event-title': "Prochain événement",
        'contact-title': "Contactez-nous",
        'form-title': "Envoyez-nous un message",
        'form-name': "Nom complet",
        'form-email': "Email",
        'form-message': "Message",
        'form-btn': "Envoyer le message",
        'install-btn': "Appli",
        'seo-title': "Votre Église Orthodoxe à Genève Bellevue",
        'seo-p1': "Bienvenue à la paroisse de l'Église Antiochian Orthodox Geneva Switzerland. Située à Bellevue, notre communauté représente l'Église orthodoxe grecque au sein du canton de Genève et de la Suisse.",
        'reg-title': "Inscrivez-vous à la paroisse",
        'reg-form-title': "Formulaire d'adhésion",
        'reg-subtitle': "Rejoignez notre communauté et restez informé des activités de la paroisse.",
        'reg-lastname': "Nom de famille",
        'reg-firstname': "Prénom",
        'reg-address': "Adresse complète",
        'reg-family-count': "Nombre de personnes dans la famille",
        'reg-birthdate': "Date de naissance",
        'reg-confirm': "Confirmer l'inscription"
    },
    en: {
        'nav-home': "Home", 'nav-schedule': "Schedule", 'nav-location': "Location",
        'nav-events': "Events", 'nav-docs': "Documents", 'nav-contact': "Contact",
        'nav-about': "About", 'nav-register': "Register",
        'welcome-title': "Welcome to the Antiochian Church",
        'card-schedule-title': "Mass Schedule",
        'card-location-title': "Location",
        'card-event-title': "Next Event",
        'contact-title': "Contact Us",
        'form-title': "Send us a message",
        'form-name': "Full Name",
        'form-email': "Email",
        'form-message': "Message",
        'form-btn': "Send Message",
        'install-btn': "App",
        'seo-title': "Your Orthodox Church in Geneva Bellevue",
        'seo-p1': "Welcome to the parish of the Antiochian Orthodox Church Geneva Switzerland. Located in Bellevue, our community represents the Greek Orthodox Church in the canton of Geneva and Switzerland.",
        'reg-title': "Register with the Parish",
        'reg-form-title': "Membership Form",
        'reg-subtitle': "Join our community and stay informed about parish activities.",
        'reg-lastname': "Last Name",
        'reg-firstname': "First Name",
        'reg-address': "Full Address",
        'reg-family-count': "Number of family members",
        'reg-birthdate': "Date of Birth",
        'reg-confirm': "Confirm Registration"
    },
    ar: {
        'nav-home': "الرئيسية", 'nav-schedule': "المواعيد", 'nav-location': "الموقع",
        'nav-events': "الفعاليات", 'nav-docs': "وثائق", 'nav-contact': "اتصل بنا",
        'nav-about': "من نحن", 'nav-register': "التسجيل",
        'welcome-title': "مرحباً بكم في الكنيسة الأنطاكية",
        'card-schedule-title': "مواقيت القداسات",
        'card-location-title': "الموقع",
        'card-event-title': "الحدث القادم",
        'contact-title': "اتصل بنا",
        'form-title': "أرسل لنا رسالة",
        'form-name': "الاسم الكامل",
        'form-email': "البريد الإلكتروني",
        'form-message': "الرسالة",
        'form-btn': "إرسال الرسالة",
        'install-btn': "تطبيق",
        'seo-title': "كنيستكم الأرثوذكسية في جنيف بيلفو",
        'seo-p1': "أهلاً بكم في رعية كنيسة أنطاكية الأرثوذكسية في جنيف سويسرا. تقع في بيلفو، تمثل جماعتنا الكنيسة الأرثوذكسية في كانتون جنيف وسويسرا.",
        'reg-title': "سجل في الرعية",
        'reg-form-title': "استمارة العضوية",
        'reg-subtitle': "انضم إلى مجتمعنا وابق على اطلاع بأنشطة الرعية.",
        'reg-lastname': "اسم العائلة",
        'reg-firstname': "الاسم الأول",
        'reg-address': "العنوان الكامل",
        'reg-family-count': "عدد أفراد الأسرة",
        'reg-birthdate': "تاريخ الميلاد",
        'reg-confirm': "تأكيد التسجيل"
    }
};

function setLang(lang) {
    localStorage.setItem('lang', lang);
    applyLang(lang);
}

function applyLang(lang) {
    const t = i18n[lang];
    if (!t) return;
    
    document.querySelectorAll('[data-i18n]').forEach(el => {
        const key = el.getAttribute('data-i18n');
        if (t[key]) {
            // Si l'élément est une balise de formulaire avec placeholder
            if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                el.placeholder = t[key];
            } else {
                el.innerHTML = t[key];
            }
        }
    });

    document.documentElement.lang = lang;
    document.documentElement.dir = (lang === 'ar') ? 'rtl' : 'ltr';
    
    document.querySelectorAll('.lang-btn').forEach(btn => btn.classList.remove('active-lang'));
    const activeBtn = document.getElementById('btn-' + lang);
    if (activeBtn) activeBtn.classList.add('active-lang');
}

document.addEventListener("DOMContentLoaded", function() {
    const savedLang = localStorage.getItem('lang') || 'fr';
    applyLang(savedLang);

    // Détection menu actif
    const currentPath = window.location.pathname.split("/").pop() || "index.html";
    document.querySelectorAll(".nav-link").forEach(link => {
        if (link.getAttribute("href") === currentPath) link.classList.add("active");
    });

    // Logique PWA
    let deferredPrompt;
    const btnInstall = document.getElementById('btnInstall');
    if (btnInstall) {
        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone;

        if (isIOS && !isStandalone) {
            btnInstall.style.display = 'block';
            btnInstall.addEventListener('click', () => {
                const msg = (localStorage.getItem('lang') === 'ar') 
                    ? "للتثبيت على iPhone: اضغط على 'مشاركة' ثم 'إضافة إلى الشاشة الرئيسية'."
                    : "Pour installer sur iPhone :\n1. Appuyez sur 'Partager' (carré avec flèche).\n2. Choisissez 'Sur l'écran d'accueil'.";
                alert(msg);
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
                await deferredPrompt.userChoice;
                btnInstall.style.display = 'none';
                deferredPrompt = null;
            }
        });
    }
});
