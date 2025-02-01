<?php
$content = json_decode(file_get_contents($file_path), true);
?>
<table class="nhsuk-u-margin-bottom-2">
    <thead>
        <tr>
            <th width='1%' style='white-space:nowrap;'>
                <img class='terminal_avatar' src='<?= _CDN_URL ?>/TA/<?php echo $content['TopicCreaterAvatar']; ?>' />
            </th>
            <th>
                <!--Creater Name-->
                <p>
                    <?php echo $content['TopicCreator']; ?>
                </p>
                <!--Main Content-->
                <?php echo $content['TopicContent']; ?>
                <!--If there is image, here-->
                <?php if (isset($content['ImageAttachment'])) { ?>
                    <br />
                    <img class='terminal_image' src='<?= _CDN_URL ?>/TA/<?php echo $content['ImageAttachment']; ?>' />
                <?php } ?>
            </th>
        </tr>
    </thead>
    <?php
    $i = 0;
    $open_option = false;
    foreach ($content['Replies'] as $this_content) {
        $i++;
        echo "<tr>";
        // Avatar Image
        echo "<td width='1%' style='white-space:nowrap;'><img class='terminal_avatar' src='" . _CDN_URL . "/TA/" . $this_content['p'] . "'/></td>";
        echo "<td>";
        // Creater Name
        echo "<p>" . $this_content['a'] . "</p>";
        if (isset($this_content['o'])) {
            // There are options here
            $option_para = "O" . $i;
            if (isset($_GET[$option_para])) {
                $option = $_GET[$option_para];
                if (isset($this_content['o'][$option])) {
                    echo $this_content['o'][$option];
                } else { ?>
                    <select class="nhsuk-select" id="select-1" name="select-1">
                        <?php
                        $j = 0;
                        echo "<option value='0' selected disabled>" . __("选择一个选项") . "</option>";
                        foreach ($this_content['o'] as $this_option) {
                            $j++;
                            echo "<option value='" . $j . "'>" . $this_option . "</option>";
                        }
                        ?>
                    </select>
                    <?php
                }
            } else {
                $open_option = true; ?>
                <?php
                $j = 0;
                foreach ($this_content['o'] as $this_option) {
                    ?>
                    <p><a class="nhsuk-action-link__link" href="<?php echo add_premerator($option_para, $j, $i); ?>">
                            <svg class="nhsuk-icon nhsuk-icon__arrow-right-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                aria-hidden="true" height="36" width="36">
                                <path d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M12 2a10 10 0 0 0-9.95 9h11.64L9.74 7.05a1 1 0 0 1 1.41-1.41l5.66 5.65a1 1 0 0 1 0 1.42l-5.66 5.65a1 1 0 0 1-1.41 0 1 1 0 0 1 0-1.41L13.69 13H2.05A10 10 0 1 0 12 2z">
                                </path>
                            </svg>
                            <span class="nhsuk-action-link__text">
                                <?php echo $this_option; ?>
                            </span></a></p>
                    <?php
                    $j++;
                }
                ?>
                </td></tr></table>
            <?php 
                break;
                }
            ?>

            <?php
        } else {
            // No options here
            echo $this_content['b'];

        }
        echo "</td></tr>\n";
    }
    echo "</table>\n";

    ?>

    <div class="nhsuk-card nhsuk-card--feature ">
        <div class="nhsuk-card__content nhsuk-card__content--feature">
            <h2 class="nhsuk-card__heading nhsuk-card__heading--feature nhsuk-heading-m">
            <?php
          if ($open_option) {
            __e('少女们正在等待店长的回复！请点击上方的选项进行回复。您还可以：');
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

                <li>
                    <a href="/category.php?id=<?php echo $category['categoryID']; ?>">
                        <?php __e('返回本分类检索页面'); ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>