<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php $path = sfConfig::get('sf_relative_url_root', preg_replace('#/[^/]+\.php5?$#', '', isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : (isset($_SERVER['ORIG_SCRIPT_NAME']) ? $_SERVER['ORIG_SCRIPT_NAME'] : ''))) ?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="title" content="hemsinif" />
<meta name="robots" content="index, follow" />
<meta name="description" content="hemsinif, friends, sinif yoldashlari" />
<meta name="keywords" content="dostlar, friends" />
<meta name="language" content="en" />
<title>hemsinif</title>

<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $path ?>/css/layout.css" />

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
      <h1>Oops! An Error Occurred</h1>
      <h5>The server returned a "<?php echo $code ?> <?php echo $text ?>".</h5>
    </div>
  </div>

  <dl class="sfTMessageInfo">
    <dt>Something is broken</dt>
    <dd>Please e-mail us at info at hemsinif dot az  and let us know what you were doing when this error occurred. We will fix it as soon as possible.
    Sorry for any inconvenience caused.</dd>

    <dt>What's next</dt>
    <dd>
      <ul class="sfTIconList">
        <li class="sfTLinkMessage"><a href="javascript:history.go(-1)">Back to previous page</a></li>
        <li class="sfTLinkMessage"><a href="/">Go to Homepage</a></li>
      </ul>
    </dd>
  </dl>
</div>
</body>
</html>
