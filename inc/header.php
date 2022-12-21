<?php
function getVisIpAddr()
{

  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    return $_SERVER['HTTP_CLIENT_IP'];
  } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    return $_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
    return $_SERVER['REMOTE_ADDR'];
  }
}

if ($_SESSION['IP'] != getVisIpAddr() || $_SESSION['UA'] != $_SERVER['HTTP_USER_AGENT'] || $_SESSION['Humanity'] <= 0) {
  require('../inc/418.php');
} else {
  $_SESSION['Humanity']--;
}
?>

<!doctype html>
<html lang="zh">

<head>
  <title>
    <?php echo uni_encode($page_title); ?> - 剧情档案馆 (少女咖啡枪同人站)
  </title>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://static.c86.ac.cn/css/moe.gcg.src.origin.css" rel="stylesheet">
  <link rel="preload" as="font" type="font/woff2" href="https://static.c86.ac.cn/fonts/unity/C86Unity.woff2" />
</head>

<body class="js-enabled c86moe-core" oncut="return false;" oncopy="return false;">
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
          <?php
          if (isset($_SESSION['freepv']) && $_SESSION['freepv'] > 0) {
            if (str_contains($_SERVER['REQUEST_URI'], 'display.php')) {
              $_SESSION['freepv'] -= 1;
            }
          ?>
            <div class="c86moe-core c86moe-error-summary app-u-background-pink">
              <p class="c86moe-u-margin-bottom-4">您当前尚未登录。少女咖啡枪同人站为您提供<?php echo $_SESSION['grace']; ?>个页面的查看，当前还剩余<?php echo $_SESSION['freepv']; ?>。要获得无限制访问，并将您的名字而不是访问IP代入剧情，请：</p>
              <form action="" method="get">
                <?php
                foreach ($_GET as $key => $value) {
                  echo "<input type='hidden' name='$key' value='$value'>";
                }
                ?>
                <input type="hidden" name="login" value="1">
                <div class="c86moe-action-link c86moe-u-margin-bottom-4">
                  <button class="c86moe-action-link__link button--link">
                    <svg class="c86moe-icon c86moe-icon__arrow-right-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                      <path d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M12 2a10 10 0 0 0-9.95 9h11.64L9.74 7.05a1 1 0 0 1 1.41-1.41l5.66 5.65a1 1 0 0 1 0 1.42l-5.66 5.65a1 1 0 0 1-1.41 0 1 1 0 0 1 0-1.41L13.69 13H2.05A10 10 0 1 0 12 2z"></path>
                    </svg>
                    <span class="c86moe-action-link__text">登录</span>
                  </button>
                </div>
              </form>
              <form action="https://shibboleth.csdcso.org/" method="get">
                <div class="c86moe-action-link c86moe-u-margin-bottom-0">
                  <button class="c86moe-action-link__link button--link">
                    <svg class="c86moe-icon c86moe-icon__arrow-right-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                      <path d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M12 2a10 10 0 0 0-9.95 9h11.64L9.74 7.05a1 1 0 0 1 1.41-1.41l5.66 5.65a1 1 0 0 1 0 1.42l-5.66 5.65a1 1 0 0 1-1.41 0 1 1 0 0 1 0-1.41L13.69 13H2.05A10 10 0 1 0 12 2z"></path>
                    </svg>
                    <span class="c86moe-action-link__text">注册</span>
                  </button>
                </div>
              </form>
            </div>
          <?php
          }
          ?>