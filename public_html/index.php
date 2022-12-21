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
if ($result_count > 0) {
  $bNoEntry = false;
  while ($data = $result->fetch_array()) {
    if ($data['strike'] != NULL) {
      $curr_tax = ['id' => $data['strike'], 'common' => $data['common']];
      array_push($type_strike, $curr_tax);
    } else if ($data['tower'] != NULL) {
      $curr_tax = ['id' => $data['tower'], 'common' => $data['common']];
      array_push($type_tower, $curr_tax);
    } else if ($data['love'] != NULL) {
      $curr_tax = ['id' => $data['love'], 'common' => $data['common']];
      array_push($type_love, $curr_tax);
    } else if ($data['vow'] != NULL) {
      $curr_tax = ['id' => $data['vow'], 'common' => $data['common']];
      array_push($type_vow, $curr_tax);
    } else if ($data['ex'] != NULL) {
      $curr_tax = ['id' => $data['ex'], 'common' => $data['common']];
      array_push($type_ex, $curr_tax);
    }
  }
} else {
  $bNoEntry = true;
}

?>
<?php
$page_title = '主页';
include '../inc/header.php';
?>
<h1>店长与少女们的珍贵回忆。</h1>
<p>欢迎来到剧情档案馆，本馆收藏内容范围为《双生视界》各类剧情（不包含私信、朋友圈）。本档案馆现有主线、好感、誓约、生日等各类剧情超1500篇，并正在不断扩展馆藏中。</p>
<p>本档案馆由少女咖啡枪同人站建立、维护。如您遇到问题，请发送邮件至 <a href="mailto: webmaster@gcg.moe">webmaster@gcg.moe</a> 或发送私信至 bilibili @少女咖啡枪同人站。<br /></p>
<hr />

<article>
  <ul class="c86moe-grid-row c86moe-card-group">
    <li class="c86moe-grid-column-one-third c86moe-card-group__item">
      <div class="c86moe-card c86moe-card">
        <div class="c86moe-card__content">
          <h2 class="c86moe-card__heading c86moe-u-font-size-24">
            <a class="c86moe-card__link" href="/?type=strike#section-strike">
              主线剧情
            </a>
          </h2>
          <p class="c86moe-card__description">
            面对来自里世界的Alpha的入侵，少女们与店长一起展开了战斗。在这场战斗中，少女们与店长的感情也逐渐深化。
          </p>
        </div>
      </div>
    </li>

    <li class="c86moe-grid-column-one-third c86moe-card-group__item">
      <div class="c86moe-card c86moe-card">
        <div class="c86moe-card__content">
          <h2 class="c86moe-card__heading c86moe-u-font-size-24">
            <a class="c86moe-card__link" href="/?type=tower#section-tower">
              活动剧情
            </a>
          </h2>
          <p class="c86moe-card__description">
            08小队与店长一起参加了各种各样的活动，少女们与店长的感情也逐渐深化。
          </p>
        </div>
      </div>
    </li>

    <li class="c86moe-grid-column-one-third c86moe-card-group__item">
      <div class="c86moe-card c86moe-card">
        <div class="c86moe-card__content">
          <h2 class="c86moe-card__heading c86moe-u-font-size-24">
            <a class="c86moe-card__link" href="/?type=love#section-love">
              好感剧情
            </a>
          </h2>
          <p class="c86moe-card__description">
            与店长的亲密关系不断加深，少女们也逐渐展现出了自己的个性。在这个过程中，少女们与店长的感情也逐渐深化。
          </p>
        </div>
      </div>
    </li>

    <li class="c86moe-grid-column-one-third c86moe-card-group__item">
      <div class="c86moe-card c86moe-card">
        <div class="c86moe-card__content">
          <h2 class="c86moe-card__heading c86moe-u-font-size-24">
            <a class="c86moe-card__link" href="/?type=vow#section-vow">
              誓约剧情
            </a>
          </h2>
          <p class="c86moe-card__description">
            从无数的未来中，少女们与店长选择了一条共同的未来。在这个过程中，少女们与店长的感情也逐渐深化。
          </p>
        </div>
      </div>
    </li>

    <li class="c86moe-grid-column-one-third c86moe-card-group__item">
      <div class="c86moe-card c86moe-card">
        <div class="c86moe-card__content">
          <h2 class="c86moe-card__heading c86moe-u-font-size-24">
            <a class="c86moe-card__link" href="/?type=ex#section-ex">
              其他剧情
            </a>
          </h2>
          <p class="c86moe-card__description">
            卡面剧情、生日剧情、特殊活动剧情等。
          </p>
        </div>
      </div>
    </li>
  </ul>


</article>


<?php if (count($type_strike) > 0 && $_GET['type'] == 'strike') { ?>
  <div class="c86moe-core callout callout--attention" id="section-strike">
    <h1 class="c86moe-heading-l">主线剧情。</h1>
    <?php foreach ($type_strike as $this_tax) { ?>
      <form action="category.php" method="get">
        <input type="hidden" name="strike" value="<?php echo $this_tax['id']; ?>">
        <div class="c86moe-action-link c86moe-u-margin-bottom-0">
          <button class="c86moe-action-link__link button--link">
            <svg class="c86moe-icon c86moe-icon__arrow-right-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M0 0h24v24H0z" fill="none"></path>
              <path d="M12 2a10 10 0 0 0-9.95 9h11.64L9.74 7.05a1 1 0 0 1 1.41-1.41l5.66 5.65a1 1 0 0 1 0 1.42l-5.66 5.65a1 1 0 0 1-1.41 0 1 1 0 0 1 0-1.41L13.69 13H2.05A10 10 0 1 0 12 2z"></path>
            </svg>
            <span class="c86moe-action-link__text"><?php echo uni_encode($this_tax['common']); ?></span>
          </button>
        </div>
      </form>
      <span>&nbsp;</span>
    <?php } ?>
  </div>
<?php } ?>


<?php if (count($type_tower) > 0 && $_GET['type'] == 'tower') { ?>
  <div class="c86moe-core callout callout--attention" id="section-tower">
    <h1 class="c86moe-heading-l">活动剧情。</h1>
    <?php foreach ($type_tower as $this_tax) { ?>
      <form action="category.php" method="get">
        <input type="hidden" name="tower" value="<?php echo $this_tax['id']; ?>">
        <div class="c86moe-action-link c86moe-u-margin-bottom-0">
          <button class="c86moe-action-link__link button--link">
            <svg class="c86moe-icon c86moe-icon__arrow-right-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M0 0h24v24H0z" fill="none"></path>
              <path d="M12 2a10 10 0 0 0-9.95 9h11.64L9.74 7.05a1 1 0 0 1 1.41-1.41l5.66 5.65a1 1 0 0 1 0 1.42l-5.66 5.65a1 1 0 0 1-1.41 0 1 1 0 0 1 0-1.41L13.69 13H2.05A10 10 0 1 0 12 2z"></path>
            </svg>
            <span class="c86moe-action-link__text"><?php echo uni_encode($this_tax['common']); ?></span>
          </button>
        </div>
      </form>
      <span>&nbsp;</span>
    <?php } ?>
  </div>
<?php } ?>


<?php if (count($type_love) > 0 && $_GET['type'] == 'love') { ?>
  <div class="c86moe-core callout callout--attention" id="section-love">
    <h1 class="c86moe-heading-l">好感剧情。</h1>
    <?php foreach ($type_love as $this_tax) { ?>
      <form action="category.php" method="get">
        <input type="hidden" name="love" value="<?php echo $this_tax['id']; ?>">
        <div class="c86moe-action-link c86moe-u-margin-bottom-0">
          <button class="c86moe-action-link__link button--link">
            <svg class="c86moe-icon c86moe-icon__arrow-right-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M0 0h24v24H0z" fill="none"></path>
              <path d="M12 2a10 10 0 0 0-9.95 9h11.64L9.74 7.05a1 1 0 0 1 1.41-1.41l5.66 5.65a1 1 0 0 1 0 1.42l-5.66 5.65a1 1 0 0 1-1.41 0 1 1 0 0 1 0-1.41L13.69 13H2.05A10 10 0 1 0 12 2z"></path>
            </svg>
            <span class="c86moe-action-link__text"><?php echo uni_encode($this_tax['common']); ?></span>
          </button>
        </div>
      </form>
      <span>&nbsp;</span>
    <?php } ?>
  </div>
<?php } ?>

<?php if (count($type_vow) > 0 && $_GET['type'] == 'vow') { ?>
  <div class="c86moe-core callout callout--attention" id="section-vow">
    <h1 class="c86moe-heading-l">誓约剧情。</h1>
    <?php foreach ($type_vow as $this_tax) { ?>
      <form action="category.php" method="get">
        <input type="hidden" name="vow" value="<?php echo $this_tax['id']; ?>">
        <div class="c86moe-action-link c86moe-u-margin-bottom-0">
          <button class="c86moe-action-link__link button--link">
            <svg class="c86moe-icon c86moe-icon__arrow-right-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M0 0h24v24H0z" fill="none"></path>
              <path d="M12 2a10 10 0 0 0-9.95 9h11.64L9.74 7.05a1 1 0 0 1 1.41-1.41l5.66 5.65a1 1 0 0 1 0 1.42l-5.66 5.65a1 1 0 0 1-1.41 0 1 1 0 0 1 0-1.41L13.69 13H2.05A10 10 0 1 0 12 2z"></path>
            </svg>
            <span class="c86moe-action-link__text"><?php echo uni_encode($this_tax['common']); ?></span>
          </button>
        </div>
      </form>
      <span>&nbsp;</span>
    <?php } ?>
  </div>
<?php } ?>

<?php if (count($type_ex) > 0 && $_GET['type'] == 'ex') { ?>
  <div class="c86moe-core callout callout--attention" id="section-ex">
    <h1 class="c86moe-heading-l">其他剧情。</h1>
    <?php foreach ($type_ex as $this_tax) { ?>
      <form action="category.php" method="get">
        <input type="hidden" name="ex" value="<?php echo $this_tax['id']; ?>">
        <div class="c86moe-action-link c86moe-u-margin-bottom-0">
          <button class="c86moe-action-link__link button--link">
            <svg class="c86moe-icon c86moe-icon__arrow-right-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M0 0h24v24H0z" fill="none"></path>
              <path d="M12 2a10 10 0 0 0-9.95 9h11.64L9.74 7.05a1 1 0 0 1 1.41-1.41l5.66 5.65a1 1 0 0 1 0 1.42l-5.66 5.65a1 1 0 0 1-1.41 0 1 1 0 0 1 0-1.41L13.69 13H2.05A10 10 0 1 0 12 2z"></path>
            </svg>
            <span class="c86moe-action-link__text"><?php echo uni_encode($this_tax['common']); ?></span>
          </button>
        </div>
      </form>
      <span>&nbsp;</span>
    <?php } ?>
  </div>
<?php } ?>

<?php
include '../inc/footer.php';
?>