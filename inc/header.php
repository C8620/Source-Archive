<!DOCTYPE html>
<html class="gcgmoe mmfb" lang="zh">
  <head>
    <meta charset="utf-8">
    <meta content="initial-scale=1, minimum-scale=1, width=device-width" name="viewport">
    <link rel="icon" href="//emt.c86.moe/c86ac.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="//emt.c86.moe/c86ac.ico" type="image/x-icon"/>
    <title>
     <?php echo uni_encode($page_title); ?> - 剧情档案馆 (少女咖啡枪同人站)
    </title>
    <link href="//eruthyll.net/css/gcg-maia.css" rel="stylesheet">
  </head>
  <body>
    <div class="maia-header" id="maia-header">
      <div class="maia-aux">
        <h1>
          <a href="//gcg.moe">
            少女咖啡枪同人站
            <!-- <img alt="Gopher Auxiliary" src="https://eruthyll.net/images/branding-auxiliary-oneline.png" height="38em"> -->
          </a>
        </h1>
        <h2>
          <a href="//src.gcg.moe">
            &nbsp; 剧情档案馆
          </a>
        </h2>
      </div>
    </div>
    <div id="maia-main">
<?php 
  if(isset($_SESSION['freepv'])&&$_SESSION['freepv']>0){
    $_SESSION['freepv']-=1;
  ?>
  <quote>
    您当前尚未登录。少女咖啡枪同人站为您提供<?php echo $_SESSION['grace']; ?>个页面的查看，当前还剩余<?php echo $_SESSION['freepv']; ?>。要获得无限制访问，请 <a href="<?php echo add_premerator($key = 'login', $value = 1); ?>">登录</a> 或 <a href = "https://shibboleth.csdcso.org/">注册</a> 。
  </quote>
<?php  
  }
?>