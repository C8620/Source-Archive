<?php
if (isset($_GET['cf-turnstile-response'])) {
    $data = array(
        'secret' => "",
        'response' => $_GET['cf-turnstile-response'],
    );
    $verify = curl_init();
    curl_setopt($verify, CURLOPT_URL, "https://challenges.cloudflare.com/turnstile/v0/siteverify");
    curl_setopt($verify, CURLOPT_POST, true);
    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($verify);
    // var_dump($response);
    $responseData = json_decode($response);
    if ($responseData->success && $responseData->hostname == "") {
        session_start();
        $_SESSION['Humanity'] = 14;
    }
}
if (!isset($_SESSION['Humanity']) || $_SESSION['Humanity'] < 1) {
    session_start();
    $_SESSION['IP'] = $ip;
    $_SESSION['UA'] = $_SERVER['HTTP_USER_AGENT'];
    http_response_code(402);
?>
    <!doctype html>
    <html lang="zh">

    <head>
        <title>
            人机验证 - 剧情档案馆 (少女咖啡枪同人站)
        </title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <script disable-devtool-auto src='https://cdn.jsdelivr.net/npm/disable-devtool'></script>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://static.c86.ac.cn/css/moe.gcg.src.origin.css" rel="stylesheet">
        <link rel="preload" as="font" type="font/woff2" href="https://static.c86.ac.cn/fonts/origin.woff2" />
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
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
                        <h1>我们需要验证您是人类。</h1>
                        <p>十分抱歉给店长带来了不好的体验，但我们需要将有限的服务器资源分配给尽可能多的店长。</p>
                        <p>验证过程是自动的。当您看到下方出现绿底白勾后，便可以点击下方的“继续”按钮。</p>
                        <form action="" method="GET">
                            <?php
                            foreach ($_GET as $key => $value) {
                                echo "<input type='hidden' name='$key' value='$value'>";
                            }
                            ?>
                            <div class="cf-turnstile" data-sitekey="0x4AAAAAAABSFvEc3-XN-9v5"></div>
                            <hr />
                            <button class="c86moe-button " type="submit" data-module="c86moe-button">继续</button>
                        </form>
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
                                人机验证 (Turnstile)。您的登录状态和剩余页面访问计数不受影响。
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
} else {
    http_response_code(200);
}
