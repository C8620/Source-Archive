<!DOCTYPE html>
<?php
// PHP code to extract IP 

function getVisIpAddr0()
{

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// Store the IP address
$ip = getVisIPAddr0();

// PHP code to obtain country, city, 
// continent, etc using IP Address

// Use JSON encoded string and converts
// it into a PHP variable
$ipdat = @json_decode(file_get_contents(
    "http://www.geoplugin.net/json.gp?ip=" . $ip
));


if (($ipdat->geoplugin_countryCode == "CN" && strlen($ipdat->geoplugin_city != 0)) || $_SERVER['HTTP_REFERER'] == "https://personalpages.manchester.ac.uk/" || ($_SESSION['IP'] == $ip && $_SESSION['UA'] == $_SERVER['HTTP_USER_AGENT'])) {
    require('../inc/turnstile.php');
} else if ($ipdat->geoplugin_countryCode == "HK" || $ipdat->geoplugin_countryCode == "MO" || $ipdat->geoplugin_countryCode == "TW") {
    header("Location: https://gcgsrc.csdcso.org");
    exit();
} else {
    http_response_code(418);
?>

    <!doctype html>
    <html lang="zh">

    <head>
        <title>
            吾乃茶壺 - 劇情檔案館
        </title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <script disable-devtool-auto src='https://cdn.jsdelivr.net/npm/disable-devtool'></script>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://static.c86.ac.cn/css/moe.gcg.src.origin.css" rel="stylesheet">
        <link rel="preload" as="font" type="font/woff2" href="https://static.c86.ac.cn/fonts/origin.woff2" />
    </head>

    <body class="js-enabled c86moe-core app-u-background-pink" oncut="return false;" oncopy="return false;">
        <div class="skiplinks">
            <div class="skiplinks__inner">
                <a href="#content" class="skiplinks__link">前往主要内容</a>
            </div>
        </div>
        <div class="c86moe-core">
            <header class="c86moe-header" role="banner">
                <div class="c86moe-width-container c86moe-header__container">
                    <div class="c86moe-header__logo">
                        <a class="c86moe-header__link c86moe-header__link--service " href="/">
                            <img alt='少女咖啡枪同人站' src='https://static.c86.ac.cn/img/GCG-moe-Dark.png' style='filter: brightness(0) invert(1);' height='45em'> <span class="c86moe-header__service-name">剧情档案馆（中国大陆）</span>
                        </a>
                    </div>
                </div>
            </header>
        </div>

        <div class="c86moe-core" unselectable="on" onselectstart="return false;">
            <div class="c86moe-width-container">
                <main id="content" class="c86moe-main-wrapper" role="main">
                    <div class="c86moe-u-reading-width">
                        <h1>吾乃茶壺。(HTTP 418)</h1>
                        <p>伺服器拒煮夷之咖啡，以其永為茶壺，且自強之法不得，亦未嘗求富是也。</p>
                        <p>是以中國之民，禮樂教化，終古不息。棄徑中驛站，斷網域之密，現君子之正身，方可覓曲徑通幽處。</p>
                        <hr />
                        <h1>I'm a teapot. (HTTP 418)</h1>
                        <p>The server has decided to refuse to brew the coffee as it is, permanently, a teapot.</p>
                        <p>However, please do note this error may be the result of country restrictions since this service is only available in select regions. If you believe this is an error, please disable traffic proxy.</p>
                        <p>If this occurs under normal connection circumstances, please contact Maxmind to ask them make corrections to their GeoIP database, or IANA to correct ASN registration.</p>
                    </div>
                </main>
            </div>
        </div>

        <footer role="contentinfo">
            <div class="c86moe-footer" id="c86moe-footer">
                <div class="c86moe-width-container">
                    <div class="c86moe-grid-row">
                        <div class="c86moe-grid-column-two-thirds">
                            <p class="c86moe-body-s">
                                <?php
                                echo "418 拒绝访问: " . $ip;
                                echo " (" . $ipdat->geoplugin_countryName . ")";
                                ?>
                            </p>
                            <hr class="c86moe-section-break c86moe-section-break--m c86moe-section-break--visible">
                            <p><img alt='少女咖啡枪同人站' src='https://static.c86.ac.cn/img/GCG-moe-Dark.png' height='45em'></p>
                            <p class="c86moe-body-s">
                                <a href="//src.gcg.moe">少女咖啡枪同人站 剧情档案馆</a>
                            </p>
                            <p class="c86moe-body-s">
                                &copy;2021-2022 C86 Academic England, GCG.moe
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        </div>
    </body>

    </html>
<?php
    exit();
}
?>