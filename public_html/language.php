<?php
require_once('../inc/connect.php');

if (isset($_GET['sel'])) {
  $lang = $_GET['sel'];
  if ($lang == "zh" || $lang == "zht" || $lang == "en" || $lang == "ja" || $lang == "kr" || $lang == "zhc") {
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

$page_title = __('更改语言');
include '../inc/header.php';
?>
<nav class="nhsuk-breadcrumb" aria-label="Breadcrumb">
  <div class="nhsuk-width-container">
    <ol class="nhsuk-breadcrumb__list">
      <li class="nhsuk-breadcrumb__item">
        <a href="/" class="nhsuk-breadcrumb__link">
          <?php __e('首页'); ?>
        </a>
      </li>
      <li class="nhsuk-breadcrumb__item">
        <?php __e('修改您的首选语言'); ?>
      </li>
    </ol>
    <p class="nhsuk-breadcrumb__back">
      <a href="/" class="nhsuk-breadcrumb__backlink">
        <span class="nhsuk-visually-hidden">
          <?php __e('首页'); ?>
        </span>
      </a>
    </p>
  </div>
</nav>
<h1>
  <?php __e('修改您的首选语言'); ?>
</h1>
<p>
  <?php __e('如果您当前的语言选项与您的实际语言不符，您可以选择下方的选项修改。请注意，选择不同的语言会影响您索引的结果。'); ?>
</p>

<div class="nhsuk-card callout app-callout--info measure">
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
  </div>
</div>

</div>
<article>
  <ul class="nhsuk-grid-row nhsuk-card-group">
    <li class="nhsuk-grid-column-one-half app-section__content nhsuk-card-group__item">
      <div class="nhsuk-card nhsuk-card--clickable" onclick="location.href='/?sel=zh';">
        <div class="nhsuk-card__content">
          <h2 class="nhsuk-card__heading nhsuk-u-font-size-24">
            <a class="nhsuk-card__link" href="/?sel=zh">
              简体中文
            </a>
          </h2>
          <p class="nhsuk-card__description">
            系统语言：简体中文<br />
            索引语言：简体中文<br />
            内容语言：简体中文
          </p>
        </div>
      </div>
    </li>

    <li class="nhsuk-grid-column-one-half app-section__content nhsuk-card-group__item">
      <div class="nhsuk-card nhsuk-card--clickable" onclick="location.href='/?sel=en';">
        <div class="nhsuk-card__content">
          <h2 class="nhsuk-card__heading nhsuk-u-font-size-24">
            <a class="nhsuk-card__link" href="/?sel=en">
              English (Intl')
            </a>
          </h2>
          <p class="nhsuk-card__description">
            System Language: English (Intl')<br />
            Index Language: English (Intl')<br />
            Content Language: English (US)<br />
          </p>
        </div>
      </div>
    </li>

    <li class="nhsuk-grid-column-one-half app-section__content nhsuk-card-group__item">
      <div class="nhsuk-card nhsuk-card--clickable" onclick="location.href='/?sel=zht';">
        <div class="nhsuk-card__content">
          <h2 class="nhsuk-card__heading nhsuk-u-font-size-24">
            <a class="nhsuk-card__link" href="/?sel=zht">
              繁體中文
            </a>
          </h2>
          <p class="nhsuk-card__description">
            系統語言：簡體中文<br />
            索引語言：簡體中文<br />
            內容語言：繁體中文<br />
            當繁體內容不存在時，將會顯示簡體內容。
          </p>
        </div>
      </div>
    </li>

    <li class="nhsuk-grid-column-one-half app-section__content nhsuk-card-group__item">
      <div class="nhsuk-card nhsuk-card--clickable" onclick="location.href='/?sel=zhc';">
        <div class="nhsuk-card__content">
          <h2 class="nhsuk-card__heading nhsuk-u-font-size-24">
            <a class="nhsuk-card__link" href="/?sel=zhc">
              繁體中文 (粵語)
            </a>
          </h2>
          <p class="nhsuk-card__description">
            系統語言：繁體中文<br />
            索引語言：簡體中文<br />
            內容語言：繁體中文<br />
            當繁體內容不存在時，將會顯示簡體內容。
          </p>
        </div>
      </div>
    </li>

    <li class="nhsuk-grid-column-one-half app-section__content nhsuk-card-group__item">
      <div class="nhsuk-card nhsuk-card--clickable" onclick="location.href='/?sel=ja';">
        <div class="nhsuk-card__content">
          <h2 class="nhsuk-card__heading nhsuk-u-font-size-24">
            <a class="nhsuk-card__link" href="/?sel=ja">
              日本語
            </a>
          </h2>
          <p class="nhsuk-card__description">
            システム言語：日本語<br />
            インデックス言語：：日本語<br />
            内容の言語: 日本語<br />
            日本語コンテンツがない場合は英語が表示されます。
          </p>
        </div>
      </div>
    </li>
    <li class="nhsuk-grid-column-one-half app-section__content nhsuk-card-group__item">
      <div class="nhsuk-card nhsuk-card--clickable" onclick="location.href='/?sel=kr';">
        <div class="nhsuk-card__content">
          <h2 class="nhsuk-card__heading nhsuk-u-font-size-24">
            <a class="nhsuk-card__link" href="/?sel=kr">
              한국인
            </a>
          </h2>
          <p class="nhsuk-card__description">
            시스템 언어: 한국어<br />
            색인 언어: 영어<br />
            콘텐츠 언어: 한국어<br />
            한국어 내용이 없으면 영어로 표시됩니다
          </p>
        </div>
      </div>
    </li>
  </ul>
</article>
<div class="nhsuk-u-reading-width">

<?php
include '../inc/footer.php';
?>