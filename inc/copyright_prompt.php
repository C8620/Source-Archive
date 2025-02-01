<?php http_response_code(401); ?>
<?php
if(isset($_GET["conscent"])) {
  $_SESSION["conscent"] = true;
  header("Location: " . $_SERVER['REQUEST_URI']);
  exit();
}
$page_title = __('版权提示');
include dirname(__FILE__) . '/header.php';
?>
<div class="app-callout app-callout--alert app-callout--alert-bordered nhsuk-u-reading-width">
  <h1 class="nhsuk-heading-xl nhsuk-u-margin-bottom-4 app-u-color-red"><?php __e('访问档案馆前，请您仔细阅读下列内容'); ?></h1>
  <h2 class="nhsuk-heading-s"><?php __e('依据中华人民共和国法律及相关国际条约，本档案馆所提供给您的内容是受到法律法规及国际法保护的。私自复制、共享、传播档案馆的任何内容均有可能为您带来高额罚金和/或牢狱之灾，并有可能重创您的信用记录。'); ?></h2>
  <p>
  <?php __e('您在[ServiceName]上获得的内容，[Organisation]或 [Organisation] 不提供给您任何再发行、复制、传播之许可。如您想要获取这些权利，您需要联系相关内容的著作权人以获取许可。为了将这些内容展现给您，我们已从合适的权利人处获取了不可转移或再授权的许可。如您绕过本服务的技术保护措施利用本服务进行了侵犯权利人著作权的行为，您应当为自己辩护并承担相应责任。'); ?>
  </p>
  <p>
  <?php __e('基于对版权所有人负责的立场，我们会对在使用本服务时发出的请求进行记录，其中包括请求URI、用户主体名称（UPN）、User Agent、以及您访问时的IP地址。您继续访问视为您接受我们对这些信息的收集，并在存在滥用或其他涉及到系统安全及版权保护的事宜时，将相关记录向执法机关或法庭分享。如您不愿意接受我们对这些信息的收集，请停止使用此服务。'); ?>
  </p>
  <p>
  <?php __e('此外，当我们有理由相信您正在尝试绕过本服务所设之保护措施时，我们可能会选择封禁您的账户。如您对我们封禁账户的选择不满，可通过 [Organisation] 公示的联系方式友好协商，或向[CourtName]提起诉讼。'); ?>
  </p>
  <form action="/" method="GET" class="nhsuk-u-reading-width">
    <input type="hidden" name="conscent" value="1">
    <button class="nhsuk-button " type="submit" data-module="nhsuk-button"><?php __e('我同意并了解上述内容'); ?></button>
  </form>
</div>
<?php
include dirname(__FILE__) . '/footer.php';
?>