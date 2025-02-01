<?php
$content = json_decode(file_get_contents($file_path), true);
$npc = $content['npc'];
$npcAvatar = $content['npcAvatar'];

function print_option($url, $content)
{
    ?>
    <p><a class="nhsuk-action-link__link" href="<?php echo $url; ?>">
            <svg class="nhsuk-icon nhsuk-icon__arrow-right-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                aria-hidden="true" height="36" width="36">
                <path d="M0 0h24v24H0z" fill="none"></path>
                <path
                    d="M12 2a10 10 0 0 0-9.95 9h11.64L9.74 7.05a1 1 0 0 1 1.41-1.41l5.66 5.65a1 1 0 0 1 0 1.42l-5.66 5.65a1 1 0 0 1-1.41 0 1 1 0 0 1 0-1.41L13.69 13H2.05A10 10 0 1 0 12 2z">
                </path>
            </svg>
            <span class="nhsuk-action-link__text">
                <?php echo $content; ?>
            </span></a></p>
    <?php
}

?>
<table class="nhsuk-u-margin-bottom-2">
    <thead>
        <tr>
            <th width='1%' style='white-space:nowrap;'></th>
            <th id="0">
                <!--Creater Name-->
                <center>
                    <?php echo $npc; ?>
                </center>
            </th>
            <th width='1%' style='white-space:nowrap;'></th>
        </tr>
    </thead>
    <?php
    $i = 0;
    $branch_invoked = false;
    $open_option = false;
    $branch = 0;
    $last_printable = 0;
    $last_option = 0;
    if (isset($_GET['R'])) {
        $read = $_GET['R'];
    } else {
        $read = 0;
    }
    foreach ($content['contents'] as $this_content) {
        $i++;
        if ($branch != $this_content['branch']) {
            continue;
        }
        if ($this_content['isPlayer'] == true) {
            echo "<td width='1%' style='white-space:nowrap;'></td>";
            echo "<td>";
            if (isset($this_content['content'])) {
                if ($read >= $i) {
                    echo $this_content['content'];
                    $branch_invoked = true;
                } else {
                    print_option(add_premerator('R', $i, $last_printable), $this_content['content']);
                    $open_option = true;
                }
            } else {
                $option_para = "O" . $i;
                $open_option = true;
                if (isset($_GET[$option_para]) && isset($this_content['choices'][$_GET[$option_para]])) {
                    // branch must be integer
                    $branch = (int) $_GET[$option_para];
                    $open_option = false;
                    $branch_invoked = true;
                    $last_option = $i;
                    echo $this_content['choices'][$_GET[$option_para]];
                }
                if ($open_option) {
                    foreach ($this_content['choices'] as $branch => $option) {
                        print_option(add_premerator($option_para, $branch, $last_printable), $option);
                    }
                }
            }
            echo "</td>";
            echo "<td width='1%' style='white-space:nowrap;'><img class='terminal_avatar' src='" . _CDN_URL . "/TA/player.png'/></td>";
            echo "</tr>";
            if ($open_option) {
                break;
            }
        } else {
            echo "<tr>";
            // Avatar Image
            echo "<td width='1%' style='white-space:nowrap;'><img class='terminal_avatar' src='" . _CDN_URL . "/TA/" . $npcAvatar . "'/></td>";
            // content, check if starts with "UI/Emoji/"
            if (str_starts_with($this_content['content'], "UI/Emoji/")) {
                // Only preserve the filename
                $this_content['content'] = substr($this_content['content'], 9);
                echo "<td><img id='" . $i . "' class='terminal_image' src='" . _CDN_URL . "/TA/" . $this_content['content'] . "'/></td>";
            } else {
                echo "<td>" . $this_content['content'] . "</td>";
            }
            echo "<td width='1%' style='white-space:nowrap;'></td>";
            echo "</tr>";
        }
        $last_printable = $i;
        if ($this_content['action'] == 1) {
            $branch = 0;
        }
        if ($this_content['action'] == 2) {
            break;
        }
    } ?>
</table>
<div class="nhsuk-card nhsuk-card--feature ">
    <div class="nhsuk-card__content nhsuk-card__content--feature">
        <h2 class="nhsuk-card__heading nhsuk-card__heading--feature nhsuk-heading-m">
            <?php
            if ($open_option) {
                __e('TA正在等待店长的回复！请点击上方的选项进行回复。您还可以：');
            } else {
                __e('本条目已结束。您可以：');
            } ?>
        </h2>

        <ul class="nhsuk-list nhsuk-list--border">
            <?php
            if ($last_option > 0) {
                $option_para = "O" . $last_option;
                $new_url = add_premerator_multi(array($option_para => 0, 'R' => $last_option), $last_option);
                ?>
                <li>
                    <a href="<?php echo $new_url ?>">
                        <?php __e('清除上一个分支选项'); ?>
                    </a>
                </li>
                <?php
            }
            if ($branch_invoked) {
                ?>
                <li>
                    <a
                        href="/display.php?entry=<?php echo (((int) anti_injection($_GET['entry']))); ?>&lang=<?php echo $lang_content; ?>">
                        <?php __e('重置选项并重新开始'); ?>
                    </a>
                </li>
                <?php
            }

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