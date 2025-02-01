<?php
if (!isset($_GET['section'])) {
  $section = "1";
} else {
  $section = $_GET['section'];
}
$_SESSION['humanity']--;
$content = json_decode(file_get_contents($file_path), true);
//echo var_dump($content);
$content = $content[$section];
if (count($content) > 0) {
  ?>
  <table class="nhsuk-u-margin-bottom-2">
    <thead>
      <tr>
        <th width='1%' style='white-space:nowrap;'>
          <?php __e('角色'); ?>
        </th>
        <th>
          <?php __e('台词'); ?>
        </th>
        <th width='0%' style='white-space:nowrap;'></th>
      </tr>
    </thead>
    <?php
    $hasLink = false;
    $hasBreak = false;
    $hadAction = false;
    $i = 0;
    foreach ($content as $this_content) {
      $i++;
      if (isset($this_content['c'])) {
        $hasLink = true;
      } else {
        if (isset($this_content['d'])) {
          if (!isset($_GET["read"]) || intval($_GET["read"]) < $i) {
            $hasBreak = array("content" => $this_content['b'], "id" => $i);
            break;
          } else {
            $hadAction = true;
          }
        }
        echo "<tr>";
        echo "<td width='1%' style='white-space:nowrap;'>" . $this_content['a'] . "</td>";
        echo "<td>" . $this_content['b'] . "</td>";
        if (isset($this_content['v']) && $_SESSION['voice'] && !_VOICE_KILLSWITCH) {
          ?>
          <td width='0%' style='white-space:nowrap;'><svg xmlns="http://www.w3.org/2000/svg"
              class="nhsuk-icon nhsuk-icon__arrow-right-circle" height="20" viewBox="0 -960 960 960" width="20"
              style="margin-top: -10px !important; margin-bottom: -10px !important; cursor: pointer;"
              onclick="playVoice(<?= voiceTGS($this_content['v']) ?>)">
              <path
                d="M390.001-318.463 641.537-480 390.001-641.537v323.074Zm90.066 218.462q-78.836 0-148.204-29.92-69.369-29.92-120.682-81.21-51.314-51.291-81.247-120.629-29.933-69.337-29.933-148.173t29.92-148.204q29.92-69.369 81.21-120.682 51.291-51.314 120.629-81.247 69.337-29.933 148.173-29.933t148.204 29.92q69.369 29.92 120.682 81.21 51.314 51.291 81.247 120.629 29.933 69.337 29.933 148.173t-29.92 148.204q-29.92 69.369-81.21 120.682-51.291 51.314-120.629 81.247-69.337 29.933-148.173 29.933ZM480-160q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
            </svg></td>
          <?php
        } else {
          echo "<td></td>";
        }
        echo "</tr>\n";
      }
    }
    echo "</table>\n";
}

if ($hasLink) {
  $i = 0;
  foreach ($content as $this_content) {
    $i++;
    if (isset($this_content['c'])) {
      $hasLink = true; ?>
        <p><a class="nhsuk-action-link__link" href="<?php echo add_premerator('section', $this_content['c']); ?>">
            <svg class="nhsuk-icon nhsuk-icon__arrow-right-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
              aria-hidden="true" height="36" width="36">
              <path d="M0 0h24v24H0z" fill="none"></path>
              <path
                d="M12 2a10 10 0 0 0-9.95 9h11.64L9.74 7.05a1 1 0 0 1 1.41-1.41l5.66 5.65a1 1 0 0 1 0 1.42l-5.66 5.65a1 1 0 0 1-1.41 0 1 1 0 0 1 0-1.41L13.69 13H2.05A10 10 0 1 0 12 2z">
              </path>
            </svg>
            <span class="nhsuk-action-link__text">
              <?php echo $this_content['b']; ?>
            </span></a></p>
        <?php
    }
  }
}
if ($hasBreak != false) { ?>
    <p><a class="nhsuk-action-link__link" href="<?php echo add_premerator("read", $hasBreak['id'], $hasBreak['id']); ?>">
        <svg class="nhsuk-icon nhsuk-icon__arrow-right-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
          aria-hidden="true" height="36" width="36">
          <path d="M0 0h24v24H0z" fill="none"></path>
          <path
            d="M12 2a10 10 0 0 0-9.95 9h11.64L9.74 7.05a1 1 0 0 1 1.41-1.41l5.66 5.65a1 1 0 0 1 0 1.42l-5.66 5.65a1 1 0 0 1-1.41 0 1 1 0 0 1 0-1.41L13.69 13H2.05A10 10 0 1 0 12 2z">
          </path>
        </svg>
        <span class="nhsuk-action-link__text">
          <?php echo $hasBreak['content']; ?>
        </span></a></p>
    <?php
}
?>

  <div class="nhsuk-card nhsuk-card--feature ">
    <div class="nhsuk-card__content nhsuk-card__content--feature">
      <h2 class="nhsuk-card__heading nhsuk-card__heading--feature nhsuk-heading-m">
        <?php
        if ($hasLink || $hasBreak != false) {
          __e('本页面内容含有选项或跳转链接，请点击上方的选项进行跳转。您还可以：');
        } else {
          __e('本条目已结束。您可以：');
        } ?>
      </h2>

      <ul class="nhsuk-list nhsuk-list--border">

        <?php
        $data2 = get_entryInfo(anti_injection($_GET['entry']) + 1);
        if ($data2 != null) {
          $file_path = "../lib-" . $lang_content . "/" . $data2['entryPath'] . ".json";
          if (file_exists($file_path)) {
            if ($data2['entryTypeID'] == $data['entryTypeID'] && $data2['entryTypeName'] == $data['entryTypeName'] && $data2['entryCommon_' . $_SESSION['LANG']] != null) {
              ?>
              <li>
                <a href="/display.php?entry=<?php echo (((int) anti_injection($_GET['entry'])) + 1); ?>">
                  <?php __e('阅读下一条目：'); ?>
                  <?php echo $data2['entryCommon_' . $_SESSION['LANG']]; ?>
                </a>
              </li>
            <?php }
          }
        }
        ?>

        <?php if ($section != 1 || $hadAction == true) { ?>
          <li>
            <a href="<?php echo add_premerator_multi(array("section" => 1, "read" => 0)); ?>">
              <?php __e('返回本条目起始点'); ?>
            </a>
          </li>
        <?php } ?>

        <li>
          <a href="/category.php?id=<?php echo $category['categoryID']; ?>">
            <?php __e('返回本分类检索页面'); ?>
          </a>
        </li>
      </ul>
    </div>
  </div>