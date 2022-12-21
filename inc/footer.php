</div>
</main>
</div>
</div>

<footer role="contentinfo">
  <div class="c86moe-footer" id="c86moe-footer">
    <div class="c86moe-width-container">
      <div class="c86moe-grid-row">
        <div class="c86moe-grid-column-two-thirds">
          <p class="c86moe-body-s">
            <?php
            echo $_SESSION['playername'] . ' (' . $_SESSION['userpname'] . ')';
            if ($_SESSION['freepv'] >= 0) {
              echo " <a href='" . add_premerator($key = 'login', $value = 1) . "'>点此登录</a>";
            } else {
              echo " <a href='" . add_premerator($key = 'action', $value = 'logout') . "'>点此登出</a>";
            }
            if ($_SESSION['freepv'] >= 0) {
              echo "</p><p class='c86moe-body-s'>剩余访客限额：" . $_SESSION['freepv'] . "页面";
            }
            ?>
          </p>
          <hr class="c86moe-section-break c86moe-section-break--m c86moe-section-break--visible">
          <p><img alt='少女咖啡枪同人站' src='https://static.c86.ac.cn/img/GCG-moe-Dark.png' height='45em'></p>
          <p class="c86moe-body-s">
            <a href="//src.gcg.moe">少女咖啡枪同人站 剧情档案馆</a>
          </p>
          <p class="c86moe-body-s">
            &copy;2021-<?php echo date("Y"); ?> C86 Academic England, GCG.moe
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>
</div>
</body>

</html>