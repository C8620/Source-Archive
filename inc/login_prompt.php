<?php http_response_code(401); ?>
<?php
if($_SESSION['grace'] > 0){
  $page_title = __('免费配额已耗尽');
} else {
  $page_title = __('需要登录');
}
include dirname(__FILE__) . '/header.php';
?>
<div class="app-callout app-callout--alert app-callout--alert-bordered nhsuk-u-reading-width">
  <?php if($_SESSION['grace'] > 0){ ?>
  <h1 class="nhsuk-heading-xl nhsuk-u-margin-bottom-4 app-u-color-red"><?php __e('感谢您试用[ServiceName]。'); ?></h1>
  <h2 class="nhsuk-heading-s"><?php __e('您尚未登录，且您的免费配额已耗尽。'); ?></h2>
  <?php }else{ ?>
  <h1 class="nhsuk-heading-xl nhsuk-u-margin-bottom-4 app-u-color-red"><?php __e('感谢您访问[ServiceName]。'); ?></h1>
  <h2 class="nhsuk-heading-s"><?php __e('当前本站点暂不提供未登录用户之访问。'); ?></h2>
  <?php } ?>
  <p>
  <?php __e('十分抱歉给店长带来了不好的体验，但我们需要将有限的服务器资源分配给尽可能多的店长。'); ?>
  </p>
  <p>
  <?php __e('要继续访问档案馆馆藏，请使用[Organisation]账户(以@example.com结尾)登录。'); ?>
  </p>
  <?php
  if(_WHITELIST_ENABLED){
    echo '<p>' . __('此服务目前处于白名单模式。您必须使用您获得资格的账户登录。') . '</p>';
  }
  ?>
  <form action="/" method="GET" class="nhsuk-u-reading-width">
    <input type="hidden" name="login" value="1">
    <button class="nhsuk-button " type="submit" data-module="nhsuk-button"><?php __e('点此登录'); ?></button>
  </form>
  <span>&nbsp;</span>
  <form action="<?php __e('https://shibboleth.csdcso.org/'); ?>" method="GET" class="nhsuk-u-reading-width">
    <button class="nhsuk-button " type="submit" data-module="nhsuk-button"><?php __e('没有账户？点此注册'); ?></button>
  </form>
</div>
<?php
include dirname(__FILE__) . '/footer.php';
?>