<?php
//$time_start = microtime(true); 
require_once("../inc/connect.php");

if (isset($_GET['strike'])) {
  $type = 'strike';
  $type_common = '主线';
  $id = $_GET['strike'];
} else if (isset($_GET['tower'])) {
  $type = 'tower';
  $type_common = '活动';
  $id = $_GET['tower'];
} else if (isset($_GET['love'])) {
  $type = 'love';
  $type_common = '好感';
  $id = $_GET['love'];
} else if (isset($_GET['vow'])) {
  $type = 'vow';
  $type_common = '誓约';
  $id = $_GET['vow'];
} else if (isset($_GET['ex'])) {
  $type = 'ex';
  $type_common = '其他';
  $id = $_GET['ex'];
} else {
  http_response_code(404);
  die(file_get_contents('404.html'));
}

$query_tax = "SELECT `common` FROM `category` WHERE `" . $type . "`=" . anti_injection($id) . ";";
$result_tax = $conn->query($query_tax);
if ($result_tax->num_rows != 1) {
  http_response_code(404);
  die(file_get_contents('./404.html'));
}
$result_tax->data_seek(0);
$tax_data = $result_tax->fetch_array();

$query = "SELECT `id`, `common` FROM `entry` WHERE `" . $type . "`=" . anti_injection($id) . ";";
$result = $conn->query($query);
$result_count = $result->num_rows;
if ($result_count <= 0) {
  http_response_code(403);
  die(file_get_contents('./403.html'));
}
$entries = [];
while ($data = $result->fetch_array()) {
  array_push($entries, $data);
}
?>
<?php
$page_title = $type_common . '/' . $tax_data['common'];
include '../inc/header.php';
?>
<h1><?php echo uni_encode($type_common . ' / ' . $tax_data['common']); ?></h1>
<p></p>
<div class="c86moe-core callout callout--attention">
  <h1 class="c86moe-heading-l">选择下列一个条目阅读。</h1>
  <?php foreach ($entries as $this_entry) { ?>
    <form action="display.php" method="get">
      <input type="hidden" name="entry" value="<?php echo $this_entry['id']; ?>">
      <div class="c86moe-action-link c86moe-u-margin-bottom-0">
        <button class="c86moe-action-link__link button--link">
          <svg class="c86moe-icon c86moe-icon__arrow-right-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M0 0h24v24H0z" fill="none"></path>
            <path d="M12 2a10 10 0 0 0-9.95 9h11.64L9.74 7.05a1 1 0 0 1 1.41-1.41l5.66 5.65a1 1 0 0 1 0 1.42l-5.66 5.65a1 1 0 0 1-1.41 0 1 1 0 0 1 0-1.41L13.69 13H2.05A10 10 0 1 0 12 2z"></path>
          </svg>
          <span class="c86moe-action-link__text"><?php echo uni_encode($this_entry['common']); ?></span>
        </button>
      </div>
    </form>
    <span>&nbsp;</span>
  <?php
  } ?>
  <h1 class="c86moe-u-font-size-19 c86moe-u-font-weight-normal">检索完成，共<?php echo $result_count; ?>条记录。</h1>
</div>
<span>&nbsp;</span>
<form action="/#section-<?php echo $type ?>" method="get">
  <input type="hidden" name="type" value="<?php echo $type ?>">
  <div class="c86moe-action-link c86moe-u-margin-bottom-0">
    <button class="c86moe-action-link__link button--link">
      <svg class="c86moe-icon c86moe-icon__arrow-right-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M0 0h24v24H0z" fill="none"></path>
        <path d="M12 2a10 10 0 0 0-9.95 9h11.64L9.74 7.05a1 1 0 0 1 1.41-1.41l5.66 5.65a1 1 0 0 1 0 1.42l-5.66 5.65a1 1 0 0 1-1.41 0 1 1 0 0 1 0-1.41L13.69 13H2.05A10 10 0 1 0 12 2z"></path>
      </svg>
      <span class="c86moe-action-link__text">返回上一层。</span>
    </button>
  </div>
</form>

<?php
include '../inc/footer.php';
?>