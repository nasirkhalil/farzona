<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<? $can=substr($_SERVER['REQUEST_URI'],1);?>
        <title><?=$meta[0];?></title>
        <meta name="keywords" content="<?=$meta[1];?>" />
        <meta name="description" content="<?=$meta[2];?>" />
        <link rel="canonical" href="<?=$conf->site_url.$can?>" />
        <link rel="stylesheet" type="text/css" href="<?=$conf->site_url?>css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="<?=$conf->site_url?>css/swiper.css">
<link rel="stylesheet" type="text/css" href="<?=$conf->site_url?>css/style.css">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
<link rel="icon" href="<?=$conf->site_url?>images/favi.png"> 
</head>