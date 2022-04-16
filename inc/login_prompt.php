<?php http_response_code(401); ?>
<?php
  $page_title = "免费配额已耗尽";
  include dirname(__FILE__) . '/header.php';
?>
      <h1>感谢您试用剧情档案馆。</h1>
      <p>您尚未登录，且您的免费配额已耗尽。要继续访问档案馆馆藏，请使用少女咖啡枪同人站账户(以@GCG.moe结尾)登录。如您碰巧拥有歌斐尔辅助团账户(以@eruthyll.net结尾)，亦可使用。</p>
      <p><a href = "<?php echo add_premerator($key = 'login', $value = 1); ?>">点此登录</a></p>
      <p><a href = "https://shibboleth.csdcso.org/">没有账户？点此注册</a></p>
<?php
  include dirname(__FILE__) . '/footer.php';
?>