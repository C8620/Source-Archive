<?php
if (_WRITE_LOGS) {
  $log_data = array(
    'time' => time(),
    'date' => date('Y-m-d H:i:s'),
    'ip' => $_SERVER['REMOTE_ADDR'],
    'ua' => $_SERVER['HTTP_USER_AGENT'],
    'uri' => $_SERVER['REQUEST_URI'],
    'sessionid' => session_id(),
    'session' => $_SESSION,
    'cookies' => $_COOKIE
  );
  $logfile = fopen('../postscript.log', 'a+');
  fwrite($logfile, json_encode($log_data) . "\r");
  fclose($logfile);
  // If file exceeded 10MB, rename it to include timestamp and create a new one.
  if (filesize('../postscript.log') > 10485760) {
    rename('../postscript.log', '../postscript.log.' . time());
  }
}
if ($_SESSION['IP'] != $_SERVER['REMOTE_ADDR'] || $_SESSION['UA'] != $_SERVER['HTTP_USER_AGENT'] || $_SESSION['Humanity'] <= 0) {
  if (_VOICE_ONLOGON && $_SESSION['voice']) {
    $_SESSION['voice_greetings'] = _VOICE_ONLOGON_LIST[array_rand(_VOICE_ONLOGON_LIST)];
  }
  require('../inc/418.php');
} else {
  $_SESSION['Humanity']--;
}
?>

<!doctype html>
<html lang='<?php echo $_SESSION['LANG'] ?>'>

<head>
  <meta name="theme-color" content="#FFA1C0" />
  <title>
    <?php echo $page_title; ?> -
    <?php __e('[ServiceName] ([Organisation])'); ?>
  </title>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <script src='<?= _CDN_URL ?>/voez1.min.js' fetchpriority="high"></script>
  <?php if ($_SESSION['voice'] && !_VOICE_KILLSWITCH) { ?>
    <script>
     let vo_domain = '<?= _VOICE_ACCESS_ENDPOINT ?>';
     let err_msg_p = '<?= __e('尝试播放音频时出现错误：') ?>';
     let err_msg_s = '<?= __e('请尝试刷新页面，如果此问题持续，请通过页脚链接联系我们。') ?>';
    </script>
  <?php } ?>
  <?php if($_SESSION['admin']) { ?>
    <script src='<?= _CDN_URL ?>/voice.js' fetchpriority="high"></script>
  <?php } ?>
  <?php if (!$_SESSION['admin']) { ?>
    <script decode-utilities-auto src='<?= _CDN_URL ?>/jquery.js' fetchpriority="high"></script>
  <?php }?>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/x-icon" href="/favicon.ico">
  <link href="<?= _CDN_URL ?>/origin.min.css" rel="stylesheet">
</head>

<body class="js-enabled nhsuk-core" oncut="return false;" oncopy="return false;" onload="voez.init;">
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

  <div class="nhsuk-core drmed" unselectable="on" onselectstart="return false;"
    data-watermark="<?php echo $_SESSION['uid']; ?>">
    <?php
    if (isset($hero_header) || isset($hero_desc)) {
      ?>
      <section class="nhsuk-hero nhsuk-hero--image nhsuk-hero--image-description"
        style="background-image: url('<?= _CDN_URL ?>/H/Hero.jpg')">
        <script>
          function randomImage() {
            var images = ["<?= _CDN_URL ?>/H/H1.webp", "<?= _CDN_URL ?>/H/H2.webp", "<?= _CDN_URL ?>/H/H3.webp", "<?= _CDN_URL ?>/H/H4.webp", "<?= _CDN_URL ?>/H/H5.webp", "<?= _CDN_URL ?>/H/H6.webp", "<?= _CDN_URL ?>/H/H7.webp", "<?= _CDN_URL ?>/H/H8.webp", "<?= _CDN_URL ?>/H/H9.webp",];
            var size = images.length;
            var x = Math.floor(size * Math.random());
            var element =
              document.getElementsByClassName("nhsuk-hero--image");
            if (element.length > 0) {
              element[0].style["background-image"] =
                "url(" + images[x] + ")";
            }
          }

          document.addEventListener("DOMContentLoaded", randomImage);
        </script>
        <div class="nhsuk-hero__overlay">
          <div class="nhsuk-width-container">
            <div class="nhsuk-grid-row">
              <div class="nhsuk-grid-column-two-thirds">
                <div class="nhsuk-hero-content">
                  <h1 class="nhsuk-u-margin-bottom-3">
                    <?php echo $hero_header; ?>
                  </h1>
                  <p class="nhsuk-body-l nhsuk-u-margin-bottom-0">
                    <?php echo $hero_desc; ?>
                  </p>
                  <span class="nhsuk-hero__arrow" aria-hidden="true"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section style="padding-top: 64px;" <?php
    }
    ?> <div class="nhsuk-width-container">
      <main id="content" class="nhsuk-main-wrapper" role="main">
        <div class="nhsuk-u-reading-width">
          <?php
          if (isset($_SESSION['freepv']) && $_SESSION['freepv'] > 0) {
            if (str_contains($_SERVER['REQUEST_URI'], 'display.php')) {
              $_SESSION['freepv'] -= 1;
            }
            ?>
            <div class="nhsuk-core nhsuk-error-summary app-u-background-pink">
              <p class="nhsuk-u-margin-bottom-4">
                <?php __e('您当前尚未登录。本服务为您提供{grace}个页面的查看，当前还剩余{freepv}。若要获得无限制访问，并将您的名字代入剧情，请：', array('grace' => $_SESSION['grace'], 'freepv' => $_SESSION['freepv'])); ?>
              </p>
              <a class="nhsuk-action-link__link" href="<?php echo add_premerator(); ?>"><svg
                  class="nhsuk-icon nhsuk-icon__arrow-right-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                  aria-hidden="true" height="36" width="36">
                  <path d="M0 0h24v24H0z" fill="none"></path>
                  <path
                    d="M12 2a10 10 0 0 0-9.95 9h11.64L9.74 7.05a1 1 0 0 1 1.41-1.41l5.66 5.65a1 1 0 0 1 0 1.42l-5.66 5.65a1 1 0 0 1-1.41 0 1 1 0 0 1 0-1.41L13.69 13H2.05A10 10 0 1 0 12 2z">
                  </path>
                </svg><span class="nhsuk-action-link__text">
                  <?php __e('登录'); ?>
                </span></a>
              &nbsp; &nbsp; &nbsp; &nbsp;
              <a class="nhsuk-action-link__link" href="https://shibboleth.csdcso.org/"><svg
                  class="nhsuk-icon nhsuk-icon__arrow-right-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                  aria-hidden="true" height="36" width="36">
                  <path d="M0 0h24v24H0z" fill="none"></path>
                  <path
                    d="M12 2a10 10 0 0 0-9.95 9h11.64L9.74 7.05a1 1 0 0 1 1.41-1.41l5.66 5.65a1 1 0 0 1 0 1.42l-5.66 5.65a1 1 0 0 1-1.41 0 1 1 0 0 1 0-1.41L13.69 13H2.05A10 10 0 1 0 12 2z">
                  </path>
                </svg><span class="nhsuk-action-link__text">
                  <?php __e('注册'); ?>
                </span></a>
            </div>
            <?php
          }
          ?>