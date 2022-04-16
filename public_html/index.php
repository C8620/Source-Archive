<?php
  //$time_start = microtime(true); 
  require_once('../inc/connect.php');
  $query = "SELECT * FROM `category`;";
  $result = $conn->query($query);
  
  $type_strike = [];
  $type_tower = [];
  $type_love = [];
  $type_vow = [];
  $type_ex = [];

  $result_count = $result->num_rows;
  if($result_count > 0){
    $bNoEntry = false;
    while($data = $result->fetch_array()) {
      if($data['strike']!=NULL){
        $curr_tax = ['id' => $data['strike'], 'common' => $data['common']];
        array_push($type_strike, $curr_tax);
      } else if($data['tower']!=NULL){
        $curr_tax = ['id' => $data['tower'], 'common' => $data['common']];
        array_push($type_tower, $curr_tax);
      } else if($data['love']!=NULL){
        $curr_tax = ['id' => $data['love'], 'common' => $data['common']];
        array_push($type_love, $curr_tax);
      } else if($data['vow']!=NULL){
        $curr_tax = ['id' => $data['vow'], 'common' => $data['common']];
        array_push($type_vow, $curr_tax);
      } else if($data['ex']!=NULL){
        $curr_tax = ['id' => $data['ex'], 'common' => $data['common']];
        array_push($type_ex, $curr_tax);
      }
    }
  }else{
    $bNoEntry = true;
  }
  
?>
<?php
  $page_title = '主页';
  include '../inc/header.php';
?>
      <h1>店长与少女们的珍贵回忆。</h1>
      <p>欢迎来到剧情档案馆，本馆收藏内容范围为《双生视界》各类剧情（不包含私信、朋友圈）。本档案馆现有主线、好感、誓约、生日等各类剧情超900篇，并正在不断扩展馆藏中。</p>
      <p>本档案馆由少女咖啡枪同人站建立、维护。如您遇到问题，请发送邮件至 <a href="mailto: webmaster@gcg.moe">webmaster@gcg.moe</a> 或发送私信至 bilibili @少女咖啡枪同人站。<br /></p>
      <hr />
      <?php if(count($type_strike)>0){?>
        <h2 name='main'>主线剧情</h2>
        <table>
          <thead>
            <tr>
                <th>类型</th>
                <th>分类</th>
                <th>操作</th>
            </tr>
          </thead>
          <?php foreach($type_strike as $this_tax){
            echo "<tr><td>主线</td><td>".uni_encode($this_tax['common'])."</td><td><a href='/category.php?strike=".$this_tax['id']."'>检索条目</a></td></tr>";
          } ?>  
        </table>
      <?php } ?>
      <?php if(count($type_tower)>0){?>
        <h2 name='activity'>活动剧情</h2>
        <table>
          <thead>
            <tr>
                <th>类型</th>
                <th>分类</th>
                <th>操作</th>
            </tr>
          </thead>
          <?php foreach($type_tower as $this_tax){
            echo "<tr><td>活动</td><td>".uni_encode($this_tax['common'])."</td><td><a href='/category.php?tower=".$this_tax['id']."'>检索条目</a></td></tr>";
          } ?>  
        </table>
      <?php } ?>
      <?php if(count($type_love)>0){?>
        <h2 name='affection'>好感剧情</h2>
        <table>
          <thead>
            <tr>
                <th>类型</th>
                <th>分类</th>
                <th>操作</th>
            </tr>
          </thead>
          <?php foreach($type_love as $this_tax){
            echo "<tr><td>好感</td><td>".uni_encode($this_tax['common'])."</td><td><a href='/category.php?love=".$this_tax['id']."'>检索条目</a></td></tr>";
          } ?>  
        </table>
      <?php } ?>
      <?php if(count($type_vow)>0){?>
        <h2 name='oath'>誓约剧情</h2>
        <table>
          <thead>
            <tr>
                <th>类型</th>
                <th>分类</th>
                <th>操作</th>
            </tr>
          </thead>
          <?php foreach($type_vow as $this_tax){
            echo "<tr><td>誓约</td><td>".uni_encode($this_tax['common'])."</td><td><a href='/category.php?vow=".$this_tax['id']."'>检索条目</a></td></tr>";
          } ?>  
        </table>
      <?php } ?>
      <?php if(count($type_ex)>0){?>
        <h2 name='other'>其他剧情</h2>
        <table>
          <thead>
            <tr>
                <th>类型</th>
                <th>分类</th>
                <th>操作</th>
            </tr>
          </thead>
          <?php foreach($type_ex as $this_tax){
            echo "<tr><td>其他</td><td>".uni_encode($this_tax['common'])."</td><td><a href='/category.php?ex=".$this_tax['id']."'>检索条目</a></td></tr>";
          } ?>  
        </table>
      <?php } ?>
<?php
  include '../inc/footer.php';
?>