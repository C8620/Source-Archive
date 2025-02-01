<!DOCTYPE html>
<?php
// PHP code to extract IP 

// Store the IP address
$ip = $_SERVER['REMOTE_ADDR'];

// PHP code to obtain country, city, 
// continent, etc using IP Address

function ip_details($ip)
{
    $result = get_ipdata($ip);
    if ($result == NULL) {
        $mac = crc32(md5($ip));
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, _IPDATA_PROXY_ENDPOINT . '?payload=' . $ip . '&mac=' . $mac);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        set_ipdata($ip, $result);
    }
    return json_decode($result);
}

function isLegit($ipdata)
{
    $threats = ['is_tor', 'is_vpn', 'is_icloud_relay', 'is_proxy', 'is_datacenter', 'is_anonymous', 'is_known_attacker', 'is_known_abuser', 'is_threat', 'is_bogon'];
    if (!in_array($ipdata->country_code, _ALLOWED_REGIONS)) {
        return false;
    }
    foreach ($threats as $threat) {
        if ($ipdata->threat->$threat) {
            return false;
        }
    }
    if (count($ipdata->threat->blocklists) > 0) {
        return false;
    }
    if (in_array($ipdata->asn->type, _DISALLOWED_TYPES)) {
        return false;
    }
    return true;
}

// Use JSON encoded string and converts
// it into a PHP variable
// $ipdat = @json_decode(
//     file_get_contents(
//        "http://www.geoplugin.net/json.gp?ip=" . $ip
//     )
// );

$ipdat = ip_details($ip);

// Verify it for Country
if (($_SESSION['IP'] == $ip && $_SESSION['UA'] == $_SERVER['HTTP_USER_AGENT']) || isLegit($ipdat)) {
    // Test if the IP address is from Chinese innerland (CN)
    if (in_array($ipdat->country_code, _TURNSTILE_EXCLUDE)) {
        // For excluded countries, use Geetest
        require('../inc/geetest.php');
    } else {
        // For other countries, use Turnstile
        require('../inc/turnstile.php');
    }
} else {
    http_response_code(418);
    ?>

    <!doctype html>
    <html lang='<?php $_SESSION['LANG']; ?>'>

    <head>
        <meta name="theme-color" content="#FFA1C0" />
        <title>
            <?php __e('吾乃茶壶 - [ServiceName]'); ?>
        </title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" type="image/x-icon" href="/favicon.ico">
        <link href="<?= _CDN_URL ?>/origin.min.css" rel="stylesheet">
    </head>

    <body class="js-enabled nhsuk-core app-u-background-pink" oncut="return false;" oncopy="return false;">
        <a href="#content" class="nhsuk-skip-link">
            <?php __e('跳转到主要内容'); ?>
        </a>
        <div class="nhsuk-core">
            <header class="nhsuk-header" role="banner">
                <div class="nhsuk-width-container nhsuk-header__container">
                    <div class="nhsuk-header__logo">
                        <a class="nhsuk-header__link nhsuk-header__link--service " href="/">
                            <img alt='<?php __e('[Organisation]'); ?>' src='<?= _CDN_URL ?>/[Organisation].png' style='filter: brightness(0) invert(1); max-width: 200px; max-height: 
50px; height: auto; width: auto;' height='45em'> <span class="nhsuk-header__service-name">
                                <?php __e('[ServiceName]'); ?>
                            </span>
                        </a>
                    </div>
                </div>
            </header>
        </div>

        <div class="nhsuk-core" unselectable="on" onselectstart="return false;">
            <div class="nhsuk-width-container">
                <main id="content" class="nhsuk-main-wrapper" role="main">
                    <div class="nhsuk-u-reading-width">
                        <h1>
                            <?php __e('吾乃茶壶。(HTTP 418)'); ?>
                        </h1>
                        <p>
                            <?php __e('服务器无法处理您的请求，因为您的地区不在获准发布的区域内，或您访问的网络存在异常。'); ?>
                        </p>
                        <p>
                            <?php __e('基于安全考虑，我们不会向您提供拦截您请求的具体原因，还请您谅解。不过，下面是一些可能原因：'); ?>
                        </p>
                        <p>
                            <?php __e('您所在的国家或地区未曾发行过《[GameName]》；您使用了包括 iCloud Relay、Google One VPN、Secure WiFi、Cloudflare WARP以及各类机场在内的代理服务；您正在一个数据中心访问此网站；您的IP曾经是僵尸网络的一部分；您的网段曾经发生过滥用行为。'); ?>
                        </p>
                        <p>
                            <?php __e('请确认您所在的区域被本服务支持，且您没有使用代理访问此服务。'); ?>
                        </p>
                    </div>
                </main>
            </div>
        </div>

        <footer role="contentinfo">
            <div class="nhsuk-footer" id="nhsuk-footer">
                <div class="nhsuk-width-container">
                    <div class="nhsuk-grid-row">
                        <div class="nhsuk-grid-column-two-thirds">
                            <p class="nhsuk-body-s">
                                <?php __e('418 拒绝访问: {ip}', array('ip' => $ip)); ?>
                            </p>
                            <hr class="nhsuk-section-break nhsuk-section-break--m nhsuk-section-break--visible">
                            <p><img alt='<?php __e('[Organisation]'); ?>' src='<?= _CDN_URL ?>/[Organisation].png' height='45em'></p>
                            <p class="nhsuk-body-s">
                                <a href="/">
                                    <?php __e('[Organisation] [ServiceName]'); ?>
                                </a><br /><a href="https://beian.miit.gov.cn">[PRC-ICP-Filling]</a>
                            </p>
                            <p class="nhsuk-body-s">
                                <?php __e('软体版本：');
                                echo _SOFTWARE_VERSION; ?>
                            </p>
                            <p class="nhsuk-body-s">
                                <?php __e('本档案馆内容版权所有，未经许可请勿转载。本站发布前已获授权。'); ?>
                                <br />
                                <?php __e('剧情内容 &copy;1999-{year} [CopyrightHolder]', array('year' => date("Y"))); ?>
                                <br />
                                <?php __e('网站系统 &copy;2021-{year} [Organisation], [Organisation], Chise Hachiroku', array('year' => date('Y'))); ?>
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