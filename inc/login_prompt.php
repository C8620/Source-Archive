<?php http_response_code(401); ?>
<?php
$page_title = "免费配额已耗尽";
include dirname(__FILE__) . '/header.php';
?>
<div class="c86moe-core c86moe-error-summary app-u-background-pink">
  <h1 class="c86moe-heading-xl c86moe-u-margin-bottom-4">感谢您试用剧情档案馆。</h1>
  <h2 class="c86moe-heading-s">您尚未登录，且您的免费配额已耗尽。</h2>
  <p>
    十分抱歉给店长带来了不好的体验，但我们需要将有限的服务器资源分配给尽可能多的店长。
  </p>
  <p>
    要继续访问档案馆馆藏，请使用少女咖啡枪同人站账户(以@GCG.moe结尾)登录。
  </p>
  <form action="/" method="GET" class="c86moe-u-reading-width">
    <input type="hidden" name="login" value="1">
    <button class="c86moe-button " type="submit" data-module="c86moe-button">点此登录</button>
  </form>
  <span>&nbsp;</span>
  <form action="https://shibboleth.csdcso.org/" method="GET" class="c86moe-u-reading-width">
    <button class="c86moe-button " type="submit" data-module="c86moe-button">没有账户？点此注册</button>
  </form>
</div>
<?php
include dirname(__FILE__) . '/footer.php';
?>