</div>
    <div id="maia-signature"></div>
    <div class="maia-footer" id="maia-footer">
      <div id="maia-footer-global">
        <div class="maia-aux">
          <ul>
            <li>
                <a href="//src.gcg.moe">少女咖啡枪同人站 剧情档案馆</a>
            </li>
            <li>
              <?php 
              echo $_SESSION['playername'] . ' (' . $_SESSION['userpname'] . ')'; 
              if($_SESSION['freepv']>=0){
                echo " <a href='".add_premerator($key = 'login', $value = 1)."'>点此登录</a>";
              }else{
                echo " <a href='".add_premerator($key = 'action', $value = 'logout')."'>点此登出</a>";
              }
              ?>
            </li>
            <?php
              if($_SESSION['freepv']>=0){
                echo "<li>剩余访客限额：".$_SESSION['freepv']."页面</li>";
              }
            ?>
            <li>
                &copy;2021-<?php echo date("Y"); ?> C86 Academic England, GCG.moe
            </li>
          </ul>
        </div>
      </div>
    </div>
  </body>
</html>
<?php
//echo 'Total execution time in seconds: ' . (microtime(true) - $time_start);
?>