<?php
if ($_SESSION['admin']) {
    $_SESSION['Humanity'] = _GEETEST_PERIOD;
}

if (!isset($_SESSION['Humanity']) || $_SESSION['Humanity'] < 1) {
    $_SESSION['IP'] = $ip;
    $_SESSION['UA'] = $_SERVER['HTTP_USER_AGENT'];
    http_response_code(402);
    ?>
    <!doctype html>
    <html lang='<?php $_SESSION['LANG']; ?>'>

    <head>
        <meta name="theme-color" content="#FFA1C0" />
        <title>
            <?php __e('人机验证 - [ServiceName] ([Organisation])'); ?>
        </title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <script src='<?= _CDN_URL ?>/voez1.min.js' fetchpriority="high"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" type="image/x-icon" href="/favicon.ico">
        <script decode-utilities-auto src='<?= _CDN_URL ?>/jquery.js' fetchpriority="high"></script>
        <link href="<?= _CDN_URL ?>/origin.min.css" rel="stylesheet">
        <script src="https://static.geetest.com/v4/gt4.js"></script>
    </head>

    <body class="js-enabled nhsuk-core app-u-background-pink" oncut="return false;" oncopy="return false;" onload="voez.init;">
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
            <style>
            .geetest_logo{display: none !important;}
            .geetest_box_logo{display: none !important;}
            </style>
            <div class="nhsuk-width-container">
                <main id="content" class="nhsuk-main-wrapper" role="main">
                    <div class="nhsuk-u-reading-width">
                        <h1>
                            <?php __e('我们需要验证您是人类。'); ?>
                        </h1>
                        <p>
                            <?php __e('十分抱歉给店长带来了不好的体验，但使此服务可以长久运行且不受机器人滥用，我们需要定期对访客进行检查。'); ?>
                        </p>
                        <p>
                            <?php __e('请您点击下方的验证组件完成人机验证。当您完成后，此页面会自动刷新。'); ?>
                        </p>
                        <form action="" method="GET">
                            <?php
                            foreach ($_GET as $key => $value) {
                                echo "<input type='hidden' name='$key' value='$value'>";
                            }
                            ?>
                            <hr />
                            <div id="captcha"></div>
                            <button id="gt4btn" class="nhsuk-button" data-module="nhsuk-button">
                                <?php __e('完成人机验证'); ?>
                            </button>
                            <br /><br /><br />
                        </form>
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
                                <?php __e('人机验证 (GeeTest)。您的登录状态和剩余页面访问计数不受影响。'); ?>
                            </p>
                            <hr class="nhsuk-section-break nhsuk-section-break--m nhsuk-section-break--visible">
                            <p><img alt='<?php __e('[Organisation]'); ?>' src='<?= _CDN_URL ?>/[Organisation].png' height='45em'></p>
                            <p class="nhsuk-body-s">
                                <a href="<?= _URL ?>">
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
        <script>
            var captchaId = "<?= _GEETEST_VERIFYID ?>"
            var product = "float"
            if (product !== 'bind') {
                $('#gt4btn').remove();
            }

            initGeetest4({
                captchaId: captchaId,
                product: product,
                mask: {
                    outside: true,
                    bgColor:'#FFA1C0',
                }
            }, function (gt) {
                window.gt = gt
                gt
                    .appendTo("#captcha")
                    .onSuccess(function (e) {
                        var result = gt.getValidate();
                        $.ajax({
                            url: '/gt4.php',
                            data: result,
                            dataType: 'json',
                            success: function (res) {
                                console.log('Successful request.');
                                if (res.result == 'success') {
                                    console.log("Verification success.");
                                    location.reload();
                                } else {
                                    console.log("Verification failed.");
                                    alert('<?= __('验证失败，请重试。如果问题持续，请尝试更换浏览器、使用无痕浏览模式、或关闭广告屏蔽软件。'); ?>');
                                    location.reload();
                                }
                            }
                        })
                    })

                $('#gt4btn').click(function () {
                    gt.showBox();
                })
            });
        </script>
    </body>

    </html>
    <?php
    exit();
} else {
    http_response_code(200);
}
