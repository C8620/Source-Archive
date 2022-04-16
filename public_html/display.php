<?php
    //$time_start = microtime(true); 
    require_once("../inc/connect.php");
    $query = "SELECT * FROM `entry` WHERE `id`=".anti_injection($_GET['entry']).";";
    $result = $conn->query($query);

    if ($result->num_rows != 1) {
      http_response_code(404);
      die(file_get_contents('./404.html'));
    }
    $result->data_seek(0);
    $data = $result->fetch_array();

    $file_path = "../lib/".$data['filename'].".txt.json";

    if(!file_exists($file_path)){
      http_response_code(403);
      die(file_get_contents('./403.html'));
    }

    if($data['strike']!=NULL) {
      $type = 'strike';
      $type_common = '主线';
      $id = $data['strike'];
    } else if ($data['tower']!=NULL){
      $type = 'tower';
      $type_common = '活动';
      $id = $data['tower'];
    } else if ($data['love']!=NULL){
      $type = 'love';
      $type_common = '好感';
      $id = $data['love'];
    } else if ($data['vow']!=NULL){
      $type = 'vow';
      $type_common = '誓约';
      $id = $data['vow'];
    } else if ($data['ex']!=NULL){
      $type = 'ex';
      $type_common = '其他';
      $id = $data['ex']; 
    } else {
      http_response_code(403);
      die('./403.html');
    }

    $query_tax = "SELECT `common` FROM `category` WHERE `".$type."`=".anti_injection($id).";";
    $result_tax = $conn->query($query_tax);
    if ($result_tax->num_rows != 1) {
        http_response_code(510);
        die(file_get_contents('./510.html'));
    }
    $result_tax->data_seek(0);
    $tax_data = $result_tax->fetch_array();
?>
<?php
  $page_title = $data['common'].' - '.$tax_data['common'];
  include '../inc/header.php';
?>
      <h1><?php echo uni_encode($data['common']); ?></h1>
      <p><a href = "/category.php?<?php echo $type.'='.$data[$type]; ?>"><?php echo uni_encode($type_common.' / '.$tax_data['common']); ?></a><p>
      <hr />
      <?php
        if (!isset($_GET['section'])){
          $section = "1";
        }else{
          $section = $_GET['section'];
        }
        $content = json_decode(file_get_contents($file_path), true);
        //echo var_dump($content);
        $content = $content[$section];
        if(count($content)>0){
      ?>
      <table>
        <thead>
            <tr>
                <th>角色</th>
                <th>台词</th>
            </tr>
        </thead>
      <?php 
        $hasLink = false;
        foreach ($content as $this_content){ 
          echo "<tr>";
          echo "<td style='white-space:nowrap;'>" . uni_encode($this_content['a']) . "</td>";
          if(isset($this_content['c'])){
            $hasLink = true;
            echo "<td><a href=\"" . add_premerator("section", $this_content['c']) . "\">" . uni_encode($this_content['b']) . "</a></td>";
          }else{
            echo "<td>" . uni_encode($this_content['b']) . "</td>";
          }
          echo "</tr>\n";
        }
        echo "</table>\n";
      }
      ?>
      <p><?php
        if($hasLink){
          echo "本页面内容含有选项或跳转链接，请点击表格内的蓝色/紫色选项进行跳转。</p><p>或者，您也可以";
        } else {
          echo "本条目已结束。您可以";
        }
        if($section!=1){
          echo " <a href=\"" . add_premerator("section", "1") . "\">点此返回本条目起始点</a> /";
        }
        echo " <a href=\"/category.php?". $type.'='.$data[$type] . "\">点此返回本分类检索页面</a> /";
      ?> <a href="/">点此返回首页</a>。</p>
<?php
  include '../inc/footer.php';
?>