<?php
//$time_start = microtime(true); 
if (!$_GET['entry'] || !isset($_GET['entry'])) {
  http_response_code(403);
  die(file_get_contents('./403.html'));
}
require_once("../inc/connect.php");
$data = get_entryInfo(anti_injection($_GET['entry']));
if ($data == null) {
  http_response_code(403);
  die(file_get_contents('./403.html'));
}

$langs_enabled = array('zh', 'zht', 'en', 'ja', 'kr');
$lang_available = array();
foreach ($langs_enabled as $lang) {
  $file_path[$lang] = "../lib-" . $lang . "/" . $data['entryPath'] . ".json";
  if (file_exists($file_path[$lang])) {
    $lang_available[] = $lang;
  }
}

if (!isset($_GET['lang'])) {
  $lang_content = $_SESSION['LANG_CONTENT'];
  if (!in_array($lang_content, $lang_available)) {
    $lang_content = i18n_fallback_lang($lang_content);
  }
  $file_path = $file_path[$lang_content];
} else {
  $lang_content = anti_injection($_GET['lang']);
  $file_path = $file_path[$lang_content];
}

if (!file_exists($file_path)) {
  http_response_code(404);
  die(file_get_contents('./404.html'));
}

?>
<?php
$category = get_categoryByPair($data['entryTypeName'], $data['entryTypeID']);
$page_title = $data['entryCommon_' . $_SESSION['LANG']];
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
        <a href="/types.php?class=<?php echo $category['categoryType']; ?>" class="nhsuk-breadcrumb__link">
          <?php echo $category['typeCommon_' . $_SESSION['LANG']]; ?>
        </a>
      </li>
      <li class="nhsuk-breadcrumb__item">
        <a href="/category.php?id=<?php echo $category['categoryID']; ?>" class="nhsuk-breadcrumb__link">
          <?php echo $category['categoryCommon_' . $_SESSION['LANG']]; ?>
        </a>
      </li>
      <li class="nhsuk-breadcrumb__item">
        <?php echo $data['entryCommon_' . $_SESSION['LANG']]; ?>
      </li>
    </ol>
    <p class="nhsuk-breadcrumb__back">
      <a href="/category.php?id=<?php echo $category['categoryID']; ?>" class="nhsuk-breadcrumb__backlink">
        <span class="nhsuk-visually-hidden">
          <?php echo $category['categoryCommon_' . $_SESSION['LANG']]; ?>
        </span>
      </a>
    </p>
  </div>
</nav>
<p></p>

<h1>
  <?php echo $data['entryCommon_' . $_SESSION['LANG']]; ?>
</h1>

<?php if (count($lang_available) > 1 && (!isset($_GET['section']) || $_GET['section'] == 1)) { ?>
  <div class="nhsuk-card ">
    <div class="nhsuk-card__content">
      <p>
        <?php __e('本条目有以下版本：') ?>
        <?php
        foreach ($lang_available as $lang) {
          echo '&nbsp;<a href="/display.php?entry=' . $_GET['entry'] . '&lang=' . $lang . '">' . i18n_local_name($lang) . '</a>&nbsp;';
        }
        ?>
        <?php __e('。您正在查看 {lang} 版本。', array('lang' => "<b>" . i18n_local_name($lang_content) . "</b>")) ?>
      </p>
    </div>
  </div>
<?php } ?>

<?php
// 0 - General Plot
// 1 - PM
// 2 - BBS
if ($data['entryForm'] == 0) {
  include '../inc/display_plot.php';
} else if ($data['entryForm'] == 1) {
  include '../inc/display_pm.php';
} else if ($data['entryForm'] == 2) {
  include '../inc/display_bbs.php';
}
include '../inc/footer.php';
?>