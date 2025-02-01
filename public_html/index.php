<?php
//$time_start = microtime(true); 
require_once('../inc/connect.php');

if (isset($_GET['sel'])) {
  $lang = $_GET['sel'];
  if ($lang == "zh" || $lang == "zht" || $lang == "en" || $lang == "ja" || $lang == "kr" || $lang == "zhc") {
    if ($lang != $_SESSION['LANG_CONTENT'] && $_SESSION['freepv'] >= 0) {
      include_once '../inc/randomNames.php';
      $_SESSION['playername'] = getRandomName($lang);
    }
    if ($lang == "kr") {
      $_SESSION['LANG_SYSTEM'] = 'kr';
      $_SESSION['LANG'] = 'en';
      $_SESSION['LANG_CONTENT'] = 'kr';
    } else if ($lang == "zhc") {
      $_SESSION['LANG_SYSTEM'] = 'zht';
      $_SESSION['LANG'] = 'zh';
      $_SESSION['LANG_CONTENT'] = 'zht';
    } else if ($lang == "zht") {
      $_SESSION['LANG_SYSTEM'] = 'zh';
      $_SESSION['LANG'] = 'zh';
      $_SESSION['LANG_CONTENT'] = 'zht';
    } else {
      $_SESSION['LANG_SYSTEM'] = $lang;
      $_SESSION['LANG'] = $lang;
      $_SESSION['LANG_CONTENT'] = $lang;
    }
    i18n_init($_SESSION['LANG_SYSTEM']);
  }
}

$page_title = __('主页');
$hero_header = __('与大家の珍贵回忆');
$hero_desc = __('欢迎来到[ServiceName]。愿店长在这里能找到您所期冀的记忆。');
include '../inc/header.php';

$types = array(
  array('strike', __('主线剧情'), __('面对来自里世界的Alpha的入侵，少女们与店长一起展开了夺回未来的战斗。')),
  array('tower', __('活动剧情'), __('08小队与店长一起参加了各种各样的活动，少女们与店长的感情也逐渐深化。')),
  array('love', __('好感剧情'), __('与店长的亲密关系不断加深，少女们也逐渐展现出了自己的个性，分享了自己的过往。')),
  array('vow', __('誓约剧情'), __('从未来的无数可能性中，少女们与店长选择了一条共同的未来，并顺回了十六条婚纱。')),
  array('card', __('卡面剧情'), __('呜哇，少女的新衣！不行不行……鼻血要控制不住了……欸？下面也〇了？！')),
  array('ex', __('其他剧情'), __('生日剧情、特殊纪念剧情、社团活动剧情等。')),
  array('bbs', __('朋友圈 (Beta)'), __('朋友圈内大家一起参与的的日常互动。')),
  array('pm', __('私信 (Beta)'), __('与少女和其他角色的私信通讯。')),
  array('cafe', __('咖啡馆随机事件'), __('少女在咖啡馆发生的日常事件。')),
  array('quest', __('每日少女请求'), __('每日少女在咖啡馆内对店长的小小请求，随机触发。'))
);
?>
<p>
  <?php __e('本馆收藏内容范围为《[GameName]》各类剧情。本档案馆现有主线、好感、誓约、生日、私信、朋友圈等各类文字类内容超2500条，并提供多种语言切换。'); ?>
</p>
<p>
  <?php __e('本档案馆由[Organisation]建立、维护。如您遇到问题，请发送邮件至 admin@example.com 或发送私信至 bilibili @[Organisation]。'); ?><br />
</p>
<hr />
<?php
if (!_VOICE_GA_ENABLED && !_VOICE_KILLSWITCH && $_SESSION['voice']) { ?>
  <div class="nhsuk-card callout app-callout--info measure nhsuk-u-margin-bottom-6">
    <div class="nhsuk-card__content">
      <p>
        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"
          class="nhsuk-icon nhsuk-icon__arrow-right-circle"
          style="margin-top: -10px !important; margin-bottom: -10px !important;">
          <path
            d="M423.283-291.217 708.87-576.804 646.413-639.5l-223.13 223.13L312.152-527.5l-62.456 62.696 173.587 173.587ZM480-71.869q-84.913 0-159.345-32.118t-129.491-87.177q-55.059-55.059-87.177-129.491Q71.869-395.087 71.869-480t32.118-159.345q32.118-74.432 87.177-129.491 55.059-55.059 129.491-87.177Q395.087-888.131 480-888.131t159.345 32.118q74.432 32.118 129.491 87.177 55.059 55.059 87.177 129.491Q888.131-564.913 888.131-480t-32.118 159.345q-32.118 74.432-87.177 129.491-55.059 55.059-129.491 87.177Q564.913-71.869 480-71.869Z" />
        </svg>
        <?php __e('实验性语音播放功能已启用。'); ?>
      </p>
    </div>
  </div>
<?php }

if (isset($_SESSION['voice_greetings']) && $_SESSION['voice'] && !_VOICE_KILLSWITCH) {
  ?>
  <div class="nhsuk-card callout app-callout--info measure nhsuk-u-margin-bottom-6" id="greetings-note"
    onclick="playVoice(<?= voiceTGS($_SESSION['voice_greetings']) ?>)">
    <div class="nhsuk-card__content">
      <p>
        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"
          class="nhsuk-icon nhsuk-icon__arrow-right-circle"
          style="margin-top: -10px !important; margin-bottom: -10px !important;">
          <path
            d="M292.309-60.002q-29.923 0-51.115-21.192-21.193-21.192-21.193-51.115v-695.382q0-29.923 21.193-51.115 21.192-21.193 51.115-21.193h375.382q29.923 0 51.115 21.193 21.193 21.192 21.193 51.115v146.152H680v-48.462H280v500.002h400v-48.462h59.999v146.152q0 29.923-21.193 51.115Q697.614-60 667.691-60H292.309Zm0-59.998h375.382q4.616 0 8.463-3.846 3.846-3.847 3.846-8.463v-37.692H280v37.692q0 4.616 3.846 8.463 3.847 3.846 8.463 3.846Zm417.69-206.154q-63.692 0-108.769-45.077Q556.154-416.308 556.154-480q0-63.692 45.076-108.769 45.077-45.077 108.769-45.077 63.692 0 108.769 45.077Q863.845-543.692 863.845-480q0 63.692-45.077 108.769-45.077 45.077-108.769 45.077Zm0-47.692q15.077 0 28.885-4.154 13.808-4.154 27.116-12.461l-145.539-145.54q-8.308 13.308-12.462 27.116T603.845-480q0 44.308 30.923 75.231 30.923 30.923 75.231 30.923Zm89.539-50.153q9.077-13.693 12.846-27.308 3.77-13.616 3.77-28.693 0-44.308-30.924-75.231-30.923-30.923-75.231-30.923-15.077 0-28.885 4.154-13.808 4.154-27.115 12.461l145.539 145.54ZM280-789.999h400v-37.692q0-4.616-3.846-8.463-3.847-3.846-8.463-3.846H292.309q-4.616 0-8.463 3.846-3.846 3.847-3.846 8.463v37.692Zm0 0V-840v50.001ZM280-120v-50.001V-120Z" />
        </svg>
        <?php __e('您的浏览器可能会阻止自动播放的问候语音。您可以点击这里手动播放。'); ?>
      </p>
    </div>
  </div>
  <script>
    if (document.visibilityState == 'visible') {
      playVoice(<?= voiceTGS($_SESSION['voice_greetings'], false) ?>);
    }
  </script>
  <?php
  unset($_SESSION['voice_greetings']);
}
?>
</div>
<article>
  <ul class="nhsuk-grid-row nhsuk-card-group">
    <?php
    foreach ($types as $type) {
      ?>
    <li class="nhsuk-grid-column-one-half app-section__content nhsuk-card-group__item">
      <div class="nhsuk-card nhsuk-card--clickable" onclick="location.href='/types.php?class=strike';">
        <div class="nhsuk-card__content">
          <h2 class="nhsuk-card__heading nhsuk-u-font-size-24">
            <a class="nhsuk-card__link" href="/types.php?class=<?= $type[0]; ?>">
              <?= $type[1]; ?>
            </a>
          </h2>
          <p class="nhsuk-card__description">
            <?= $type[2]; ?>
          </p>
        </div>
      </div>
    </li>
    <?php
    }
    ?>
  </ul>
</article>
<div class="nhsuk-u-reading-width">
  <div class="nhsuk-card ">
    <div class="nhsuk-card__content">
      <p>
        <?php __e('当前设定：'); ?><br />
        <?php __e('系统语言：'); ?>
        <?php echo i18n_local_name($_SESSION['LANG_SYSTEM']); ?><br />
        <?php __e('索引语言：'); ?>
        <?php echo i18n_local_name($_SESSION['LANG']); ?><br />
        <?php __e('内容语言：'); ?>
        <?php echo i18n_local_name($_SESSION['LANG_CONTENT']); ?>
      </p>
      <p id="lang"><a class="nhsuk-action-link__link" href="/language.php">
          <svg class="nhsuk-icon nhsuk-icon__arrow-right-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
            aria-hidden="true" height="36" width="36">
            <path d="M0 0h24v24H0z" fill="none"></path>
            <path
              d="M12 2a10 10 0 0 0-9.95 9h11.64L9.74 7.05a1 1 0 0 1 1.41-1.41l5.66 5.65a1 1 0 0 1 0 1.42l-5.66 5.65a1 1 0 0 1-1.41 0 1 1 0 0 1 0-1.41L13.69 13H2.05A10 10 0 1 0 12 2z">
            </path>
          </svg>
          <span class="nhsuk-action-link__text">
            <?php
              __e('更改语言偏好');
              if($_SESSION['LANG_SYSTEM'] != 'en') {
                echo ' / Language Preferences';
              }
            ?>
          </span></a></p>
    </div>
  </div>
  <?php
  include '../inc/footer.php';
  ?>