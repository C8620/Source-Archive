<?php
//$time_start = microtime(true); 
require_once("../inc/connect.php");

if(isset($_GET['class'])) {
  $class = anti_injection($_GET['class']);
} else {
  http_response_code(404);
  die(file_get_contents('404.html'));
}

$type = get_typeInfo($class);

if($type == null) {
  http_response_code(404);
  die(file_get_contents('404.html'));
}

$categories = get_typeCategories($class);

if($categories == null) {
  http_response_code(403);
  die(file_get_contents('403.html'));
}

?>
<?php
$page_title = $type['typeCommon_'.$_SESSION['LANG']];
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
        <?php echo $type['typeCommon_'.$_SESSION['LANG']]; ?>
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
<p></p>
<h1>
  <span role="text">
    <?php
    echo $type['typeCommon_'.$_SESSION['LANG']];
    ?>
    <span class="nhsuk-caption-xl nhsuk-caption--bottom">
      <span class="nhsuk-u-visually-hidden"> - </span>
      <?php __e('选择下列一个分类检索。'); ?>
    </span>
  </span>
</h1>
</div>
<ul class="app-signage">
  <?php
  $count = 0;
  foreach($categories as $this_entry) {
    if($this_entry['categoryCommon_'.$_SESSION['LANG']] == null)
      continue;
    $count++;
    ?>
    <li class="app-signage__item">
      <a class="app-signage__link" href="/category.php?id=<?php echo $this_entry['categoryID']; ?>">
        <?php echo $this_entry['categoryCommon_'.$_SESSION['LANG']]; ?>
        <svg class="app-signage__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
          height="24" width="24">
          <path
            d="M15.5 12a1 1 0 0 1-.29.71l-5 5a1 1 0 0 1-1.42-1.42l4.3-4.29-4.3-4.29a1 1 0 0 1 1.42-1.42l5 5a1 1 0 0 1 .29.71z">
          </path>
        </svg>
      </a>
    </li>
    <?php
  } ?>
</ul>
<div class="nhsuk-u-reading-width">
  <h1 class="nhsuk-u-font-size-19 nhsuk-u-font-weight-normal">
    <?php __e('检索完成，共{count}个分类。', array('count' => $count)); ?>
  </h1>

  <?php
  include '../inc/footer.php';
  ?>