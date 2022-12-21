<?php
//$time_start = microtime(true); 
if (!$_GET['entry'] || !isset($_GET['entry'])) {
  http_response_code(404);
  die(file_get_contents('./404.html'));
}
require_once("../inc/connect.php");
$query = "SELECT * FROM `entry` WHERE `id`=" . anti_injection($_GET['entry']) . ";";
$result = $conn->query($query);

if ($result->num_rows != 1) {
  http_response_code(404);
  die(file_get_contents('./404.html'));
}
$result->data_seek(0);
$data = $result->fetch_array();

$file_path = "../lib/" . $data['filename'] . ".txt.json";

if (!file_exists($file_path)) {
  http_response_code(403);
  die(file_get_contents('./403.html'));
}

if ($data['strike'] != NULL) {
  $type = 'strike';
  $type_common = '主线';
  $id = $data['strike'];
} else if ($data['tower'] != NULL) {
  $type = 'tower';
  $type_common = '活动';
  $id = $data['tower'];
} else if ($data['love'] != NULL) {
  $type = 'love';
  $type_common = '好感';
  $id = $data['love'];
} else if ($data['vow'] != NULL) {
  $type = 'vow';
  $type_common = '誓约';
  $id = $data['vow'];
} else if ($data['ex'] != NULL) {
  $type = 'ex';
  $type_common = '其他';
  $id = $data['ex'];
} else {
  http_response_code(403);
  die('./403.html');
}

$query_tax = "SELECT `common` FROM `category` WHERE `" . $type . "`=" . anti_injection($id) . ";";
$result_tax = $conn->query($query_tax);
if ($result_tax->num_rows != 1) {
  http_response_code(510);
  die(file_get_contents('./510.html'));
}
$result_tax->data_seek(0);
$tax_data = $result_tax->fetch_array();
?>
<?php
$page_title = $data['common'] . ' - ' . $tax_data['common'];
include '../inc/header.php';
?>
<h1><?php echo uni_encode($data['common']); ?></h1>
<p><a href="/category.php?<?php echo $type . '=' . $data[$type]; ?>"><?php echo uni_encode($type_common . ' / ' . $tax_data['common']); ?></a>
<p>
  <hr />
  <?php
  if (!isset($_GET['section'])) {
    $section = "1";
  } else {
    $section = $_GET['section'];
  }
  $content = json_decode(file_get_contents($file_path), true);
  //echo var_dump($content);
  $content = $content[$section];
  if (count($content) > 0) {
  ?>
<table class="c86moe-u-margin-bottom-2">
  <thead>
    <tr>
      <th>角色</th>
      <th>台词</th>
    </tr>
  </thead>
  <?php
    $hasLink = false;
    foreach ($content as $this_content) {
      if (isset($this_content['c'])) {
        $hasLink = true;
      } else {
        echo "<tr>";
        echo "<td style='white-space:nowrap;'>" . simple_drm(uni_encode($this_content['a'])) . "</td>";
        echo "<td>" . simple_drm(uni_encode($this_content['b'])) . "</td>";
        echo "</tr>\n";
      }
    }
    echo "</table>\n";
  }

  if ($hasLink) {
    foreach ($content as $this_content) {
      if (isset($this_content['c'])) {
        $hasLink = true; ?>
      <form action="" method="get">
        <input type="hidden" name="entry" value="<?php echo $_GET['entry']; ?>">
        <input type="hidden" name="section" value="<?php echo $this_content['c']; ?>">
        <div class="c86moe-action-link c86moe-u-margin-bottom-2">
          <button class="c86moe-action-link__link button--link">
            <svg class="c86moe-icon c86moe-icon__arrow-right-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M0 0h24v24H0z" fill="none"></path>
              <path d="M12 2a10 10 0 0 0-9.95 9h11.64L9.74 7.05a1 1 0 0 1 1.41-1.41l5.66 5.65a1 1 0 0 1 0 1.42l-5.66 5.65a1 1 0 0 1-1.41 0 1 1 0 0 1 0-1.41L13.69 13H2.05A10 10 0 1 0 12 2z"></path>
            </svg>
            <span class="c86moe-action-link__text"><?php echo uni_encode($this_content['b']); ?></span>
          </button>
        </div>
      </form>
<?php
      }
    }
  }
?>
<span>&nbsp;</span>
<hr />
<div class="callout callout--info c86moe-u-margin-bottom-4">
  <?php
  if ($hasLink) {
    echo "<p>本页面内容含有选项或跳转链接，请点击上方的选项进行跳转。</p><p>或者，您也可以：</p>";
  } else {
    echo "<p>本条目已结束。您可以：</p>";
    $query = "SELECT * FROM `entry` WHERE `id`=" . ((int)anti_injection($_GET['entry'])) + 1 . ";";
    $result = $conn->query($query);
    if ($result->num_rows == 1) {
      $result->data_seek(0);
      $data2 = $result->fetch_array();
      $file_path = "../lib/" . $data2['filename'] . ".txt.json";
      if (file_exists($file_path)) {
        if ($data2["$type"] == $id) { ?>
          <form action="" method="get">
            <input type="hidden" name="entry" value="<?php echo (((int)anti_injection($_GET['entry'])) + 1); ?>">
            <div class="c86moe-action-link c86moe-u-margin-bottom-2">
              <button class="c86moe-action-link__link button--link">
                <svg class="c86moe-icon c86moe-icon__arrow-right-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M0 0h24v24H0z" fill="none"></path>
                  <path d="M12 2a10 10 0 0 0-9.95 9h11.64L9.74 7.05a1 1 0 0 1 1.41-1.41l5.66 5.65a1 1 0 0 1 0 1.42l-5.66 5.65a1 1 0 0 1-1.41 0 1 1 0 0 1 0-1.41L13.69 13H2.05A10 10 0 1 0 12 2z"></path>
                </svg>
                <span class="c86moe-action-link__text">阅读下一条目：<?php echo uni_encode($data2['common']); ?></span>
              </button>
            </div>
          </form>
  <?php       }
      }
    }
  } ?>
  <?php


  if ($section != 1) { ?>
    <form action="" method="get">
      <input type="hidden" name="entry" value="<?php echo $_GET['entry']; ?>">
      <input type="hidden" name="section" value="1">
      <div class="c86moe-action-link c86moe-u-margin-bottom-2">
        <button class="c86moe-action-link__link button--link">
          <svg class="c86moe-icon c86moe-icon__arrow-right-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M0 0h24v24H0z" fill="none"></path>
            <path d="M12 2a10 10 0 0 0-9.95 9h11.64L9.74 7.05a1 1 0 0 1 1.41-1.41l5.66 5.65a1 1 0 0 1 0 1.42l-5.66 5.65a1 1 0 0 1-1.41 0 1 1 0 0 1 0-1.41L13.69 13H2.05A10 10 0 1 0 12 2z"></path>
          </svg>
          <span class="c86moe-action-link__text">返回本条目起始点</span>
        </button>
      </div>
    </form>
  <?php } ?>
  <form action="category.php" method="get">
    <input type="hidden" name="<?php echo $type; ?>" value="<?php echo $data[$type]; ?>">
    <div class="c86moe-action-link c86moe-u-margin-bottom-0">
      <button class="c86moe-action-link__link button--link">
        <svg class="c86moe-icon c86moe-icon__arrow-right-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
          <path d="M0 0h24v24H0z" fill="none"></path>
          <path d="M12 2a10 10 0 0 0-9.95 9h11.64L9.74 7.05a1 1 0 0 1 1.41-1.41l5.66 5.65a1 1 0 0 1 0 1.42l-5.66 5.65a1 1 0 0 1-1.41 0 1 1 0 0 1 0-1.41L13.69 13H2.05A10 10 0 1 0 12 2z"></path>
        </svg>
        <span class="c86moe-action-link__text">返回本分类检索页面</span>
      </button>
    </div>
  </form>
</div>
<?php
include '../inc/footer.php';
?>