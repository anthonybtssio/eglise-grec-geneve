const i18n = {
    fr: {
        'nav-home': "Accueil", 'nav-schedule': "Horaire", 'nav-location': "Localisation",
        'nav-events': "Événements", 'nav-docs': "Documents", 'nav-contact': "Contact",
        'nav-about': "À propos", 'nav-register': "Adhésion", 'install-btn': "Appli",
        'welcome-title': "Bienvenue à l'Église Antiochienne",
        'card-schedule-title': "Horaires des messes", 'card-schedule-text': "2ème Dimanche du mois : 10h30<br>4ème Dimanche du mois : 10h30",
        'card-location-title': "Localisation", 'card-location-text': "Chemin de la Chênaie 145C,<br>1293 Bellevue, Genève",
        'card-event-title': "Prochain événement", 'card-event-text': "Déjeuner de manakish - 14 septembre 2025<br>10h30 à Bellevue",
        'contact-title': "Contactez-nous", 'form-title': "Envoyez-nous un message",
        'form-name': "Nom complet", 'form-email': "Email", 'form-message': "Message", 'form-btn': "Envoyer le message",
        'reg-title': "Inscrivez-vous à la paroisse", 'reg-form-title': "Formulaire d'adhésion",
        'reg-lastname': "Nom de famille", 'reg-firstname': "Prénom", 'reg-confirm': "Confirmer l'inscription"
    },
    en: {
        'nav-home': "Home", 'nav-schedule': "Schedule", 'nav-location': "Location",
        'nav-events': "Events", 'nav-docs': "Documents", 'nav-contact': "Contact",
        'nav-about': "About", 'nav-register': "Membership", 'install-btn': "App",
        'welcome-title': "Welcome to the Antiochian Church",
        'card-schedule-title': "Mass Schedule", 'card-schedule-text': "2nd Sunday of the month: 10:30 AM",
        'card-location-title': "Location", 'card-location-text': "Chemin de la Chênaie 145C, Bellevue",
        'card-event-title': "Next Event", 'card-event-text': "Manakish Lunch - Sept 14, 2025",
        'contact-title': "Contact Us", 'form-title': "Send a message",
        'form-name': "Full Name", 'form-email': "Email", 'form-message': "Message", 'form-btn': "Send",
        'reg-title': "Register", 'reg-form-title': "Membership",
        'reg-lastname': "Last Name", 'reg-firstname': "First Name", 'reg-confirm': "Register"
    },
    ar: {
        'nav-home': "الرئيسية", 'nav-schedule': "المواعيد", 'nav-location': "الموقع",
        'nav-events': "الفعاليات", 'nav-docs': "وثائق", 'nav-contact': "اتصل بنا",
        'nav-about': "من نحن", 'nav-register': "انضمام", 'install-btn': "تطبيق",
        'welcome-title': "مرحباً بكم في الكنيسة الأنطاكية",
        'card-schedule-title': "مواقيت القداسات", 'card-schedule-text': "الأحد الثاني من الشهر: 10:30",
        'card-location-title': "الموقع", 'card-location-text': "جنيف ،Bellevue",
        'card-event-title': "الحدث القادم", 'card-event-text': "غداء المناقيش",
        'contact-title': "اتصل بنا", 'form-title': "أرسل لنا رسالة",
        'form-name': "الاسم الكامل", 'form-email': "البريد الإلكتروني", 'form-message': "الرسالة", 'form-btn': "إرسال",
        'reg-title': "سجل في الرعية", 'reg-form-title': "استمارة العضوية",
        'reg-lastname': "اسم العائلة", 'reg-firstname': "الاسم الأول", 'reg-confirm': "تأكيد"
    }
};

function applyLang(lang) {
    const t = i18n[lang];
    if (!t) return;
    document.querySelectorAll('[data-i18n]').forEach(el => {
        const key = el.getAttribute('data-i18n');
        if (t[key]) {
            if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.placeholder = t[key];
            else el.innerHTML = t[key];
        }
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
    const savedLang = localStorage.getItem('lang') || 'fr';
    applyLang(savedLang);

    const currentPath = window.location.pathname.split("/").pop() || "index.html";
    document.querySelectorAll(".nav-link, .tab-item").forEach(link => {
        if (link.getAttribute("href") === currentPath) link.classList.add("active");
    });

    let deferredPrompt;
    const btnInstall = document.getElementById('btnInstall');
    const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

    const installMsg = {
        fr: "--- GUIDE D'INSTALLATION DE L'APPLI ---\n\n" +
            "1. Navigateur : Utilisez obligatoirement SAFARI (sur iPhone) ou CHROME (sur Android).\n\n" +
            "2. Action :\n" +
            "   - Sur IPHONE : Appuyez sur l'icône 'Partager' (le carré avec une flèche en bas de l'écran).\n" +
            "   - Sur ANDROID : Appuyez sur les 3 petits points en haut à droite.\n\n" +
            "3. Menu : Faites défiler et choisissez 'SUR L'ÉCRAN D'ACCUEIL'.\n\n" +
            "4. ATTENTION (TRÈS IMPORTANT) : Si une case nommée 'Ouvrir comme app web' apparaît, vous DEVEZ la DÉCOCHER.\n\n" +
            "L'icône de l'église apparaîtra alors sur votre écran comme une véritable application !",
        
        en: "--- APP INSTALLATION GUIDE ---\n\n" +
            "1. Browser: Please use SAFARI (on iPhone) or CHROME (on Android).\n\n" +
            "2. Action:\n" +
            "   - On IPHONE: Tap the 'Share' icon (the square with an arrow at the bottom).\n" +
            "   - On ANDROID: Tap the 3 dots at the top right.\n\n" +
            "3. Menu: Scroll down and select 'ADD TO HOME SCREEN'.\n\n" +
            "4. WARNING (CRUCIAL): If an 'Open as web app' checkbox appears, you MUST UNCHECK it.\n\n" +
            "The church icon will then appear on your screen as a real application!",
        
        ar: "--- دليل تثبيت التطبيق ---\n\n" +
            "1. المتصفح: يجب استخدام SAFARI (على iPhone) أو CHROME (على Android).\n\n" +
            "2. الإجراء:\n" +
            "   - على IPHONE: اضغط على أيقونة 'مشاركة' (المربع الذي به سهم في أسفل الشاشة).\n" +
            "   - على ANDROID: اضغط على النقاط الثلاث في أعلى اليمين.\n\n" +
            "3. القائمة: مرر لأسفل واختر 'إضافة إلى الشاشة الرئيسية'.\n\n" +
            "4. تنبيه (هام جداً): إذا ظهر مربع 'الفتح كتطبيق ويب'، فيجب عليك إلغاء تحديده.\n\n" +
            "ستظهر أيقونة الكنيسة بعد ذلك على شاشتك كتطبيق حقيقي!"
    };

    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        if (btnInstall) btnInstall.style.display = 'block';
    });

    if (btnInstall) {
        btnInstall.style.display = 'block';
        btnInstall.addEventListener('click', async () => {
            const lang = localStorage.getItem('lang') || 'fr';
            if (isIOS) {
                alert(installMsg[lang]);
            } else if (deferredPrompt) {
                deferredPrompt.prompt();
                await deferredPrompt.userChoice;
                deferredPrompt = null;
            } else {
                alert(installMsg[lang]);
            }
        });
    }
});
