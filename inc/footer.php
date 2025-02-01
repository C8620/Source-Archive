</div>
<!--
<div class="notification-banner survey-banner notification-banner--hiviz">
  <form action="/help.php" method="get" target="_blank">
  <p class="notification-banner--inner">
    <?php __e('使用此服务时遇到了问题吗？') ?> <button type="submit" class="button--link"
      data-event-trigger="click"><?php __e('请查看故障排除指南，及获取帮助的方式。') ?></button>
  </p>
  </form>
</div>
-->
</main>
</div>
</div>

<footer role="contentinfo">
  <div class="nhsuk-footer" id="nhsuk-footer">
    <div class="nhsuk-width-container">
      <div class="nhsuk-grid-row">
        <div class="nhsuk-grid-column-two-thirds">
          <p class="nhsuk-body-s" style="word-wrap: break-word;">
            <?php
            echo $_SESSION['playername'] . ' (' . $_SESSION['userpname'] . ')<br/>';
            if ($_SESSION['freepv'] >= 0) {
              echo " <a href='" . add_premerator($key = 'login', $value = 1) . "'>" . __('点此登录') . "</a>";
            } else {
              echo " <a href='" . add_premerator($key = 'action', $value = 'logout') . "'>" . __('点此登出') . "</a>";
            }
            if ($_SESSION['freepv'] >= 0) {
              echo "</p><p class='nhsuk-body-s'>" . __('访客限额：剩余{freepv}页面，共{grace}页面。', array('freepv' => $_SESSION['freepv'], 'grace' => $_SESSION['grace']));
            }
            ?>
          </p>
          <p class="nhsuk-body-s">
            <?php __e('使用此服务时遇到了问题吗？') ?>
            <a href="mailto:admin@example.com" target="_blank">
              <?php __e('请向我们发送邮件以获取帮助。') ?>
            </a>
          </p>
          <hr class="nhsuk-section-break nhsuk-section-break--m nhsuk-section-break--visible">
          <p><img alt='<?php __e('[Organisation]'); ?>' src='<?= _CDN_URL ?>/[Organisation].png' height='45em'></p>
          <p class="nhsuk-body-s">
            <a href="<?= _URL ?>">
              <?php __e('[Organisation] [ServiceName]'); ?>
            </a><br/><a href="https://beian.miit.gov.cn">[PRC-ICP-Filling]</a>
          </p>
          <p class="nhsuk-body-s">
            <?php __e('软体版本：');
            echo _SOFTWARE_VERSION; ?> <br />
            <?php __e('数据版本：');
            echo _DATA_VERSION; ?>
          </p>
          <p class="nhsuk-body-s">
            <?php __e('本档案馆内容版权所有，未经许可请勿转载。本站发布前已获授权。'); ?>
            <br />
            <?php __e('剧情内容 &copy;1999-{year} [CopyrightHolder]', array('year' => date("Y"))); ?>
            <br />
            <?php __e('网站系统 &copy;2021-{year} [Organisation], [Organisation], Chise Hachiroku', array('year' => date('Y'))); ?>
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>
</body>

</html>