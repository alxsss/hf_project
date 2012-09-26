<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php $path = preg_replace('#/[^/]+\.php5?$#', '', isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : (isset($_SERVER['ORIG_SCRIPT_NAME']) ? $_SERVER['ORIG_SCRIPT_NAME'] : '')) ?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="title" content="fmpsv project" />
<meta name="robots" content="index, follow" />
<meta name="description" content="fmpsvproject" />
<meta name="keywords" content="friends, music, photos, shopping, videos" />
<meta name="language" content="en" />
<title>hemsinif</title>

<link rel="shortcut icon" href="/favicon.ico" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $path ?>/sf/sf_default/css/error.css" />
<!--[if lt IE 7.]>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $path ?>/sf/sf_default/css/ie.css" />
<![endif]-->

</head>
<body>
<div class="sfTContainer">
  <div class="sfTMessageContainer sfTAlert">
    <div class="sfTMessageWrap">
      <h1>Website Temporarily Unavailable</h1>
      <h5>Please try again in a few seconds...</h5>
    </div>
  </div>

  <dl class="sfTMessageInfo">
    <dt>What's next</dt>
    <dd>
      <ul class="sfTIconList">
        <li class="sfTReloadMessage"><a href="javascript:window.location.reload()">Try again: Reload Page</a></li>
      </ul>
    </dd>
  </dl>
</div>
</body>
</html>
