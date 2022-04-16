<?php 
    //$time_start = microtime(true); 
    require_once("../inc/connect.php");

    if(isset($_GET['strike'])) {
      $type = 'strike';
      $type_common = '主线';
      $id = $_GET['strike'];
    } else if (isset($_GET['tower'])){
      $type = 'tower';
      $type_common = '活动';
      $id = $_GET['tower'];
    } else if (isset($_GET['love'])){
      $type = 'love';
      $type_common = '好感';
      $id = $_GET['love'];
    } else if (isset($_GET['vow'])){
      $type = 'vow';
      $type_common = '誓约';
      $id = $_GET['vow'];
    } else if (isset($_GET['ex'])){
      $type = 'ex';
      $type_common = '其他';
      $id = $_GET['ex'];
    } else {
      http_response_code(404);
      die('404.html');
    }

    $query_tax = "SELECT `common` FROM `category` WHERE `".$type."`=".anti_injection($id).";";
    $result_tax = $conn->query($query_tax);
    if ($result_tax->num_rows != 1) {
        http_response_code(404);
        die(file_get_contents('./404.html'));
    }
    $result_tax->data_seek(0);
    $tax_data = $result_tax->fetch_array();

    $query = "SELECT `id`, `common` FROM `entry` WHERE `".$type."`=".anti_injection($id).";";
    $result = $conn->query($query);
    $result_count = $result->num_rows;
    if ($result_count <= 0) {
      http_response_code(403);
        die(file_get_contents('./403.html'));
    }
    $entries = [];
    while($data = $result->fetch_array()) {
      array_push($entries, $data);
    }
?>
<?php
  $page_title = $type_common.'/'.$tax_data['common'];
  include '../inc/header.php';
?>
      <h1>检索：<?php echo uni_encode($type_common.' / '.$tax_data['common']); ?></h1>
      <p></p>
      <table>
        <thead>
            <tr>
                <th>类型</th>
                <th>分类</th>
                <th>标题</th>
                <th>操作</th>
            </tr>
        </thead>
        <?php foreach($entries as $this_entry){
            echo "<tr><td>$type_common</td><td>".uni_encode($tax_data['common'])."</td><td>".uni_encode($this_entry['common'])."</td><td><a href='/display.php?entry=".$this_entry['id']."'>阅读条目</a></td></tr>";
        } ?>  
      </table>
      <p>检索完成，共<?php echo $result_count; ?>条记录。<a href="/">点此返回首页</a>。</p>
<?php
  include '../inc/footer.php';
?>