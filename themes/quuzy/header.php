<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$this->seoTitle()?></title>

    <meta name="description" content="<?=$this->seoDesc()?>"/>
    <link rel="canonical" href="<?=$this->seoCanonical($urlParse)?>" />

    <meta property="og:locale" content="en" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?=$this->seoTitle()?>" />
    <meta property="og:description" content="<?=$this->seoDesc()?>" />
    <meta property="og:url" content="https://quuzy.com/" />
    <meta property="og:site_name" content="<?=$this->seoTitle()?>" />
    <meta property="og:image" content="<?=THEMEPATH?>assets/img/favicons/android-icon-192x192.png" />
    <meta property="og:image:secure_url" content="<?=THEMEPATH?>assets/img/favicons/android-icon-192x192.png" />
    <meta property="og:image:width" content="1199" />
    <meta property="og:image:height" content="1199" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="<?=$this->seoDesc()?>" />
    <meta name="twitter:title" content="<?=$this->seoTitle()?>" />
    <meta name="twitter:image" content="https://quuzy.com/wp-content/uploads/2018/05/25394711_2023938964550869_8082656677524465474_o.jpg" />

    <link rel="apple-touch-icon" sizes="57x57" href="<?=THEMEPATH?>assets/img/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?=THEMEPATH?>assets/img/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=THEMEPATH?>assets/img/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=THEMEPATH?>assets/img/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=THEMEPATH?>assets/img/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=THEMEPATH?>assets/img/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=THEMEPATH?>assets/img/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=THEMEPATH?>assets/img/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=THEMEPATH?>assets/img/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"   href="<?=THEMEPATH?>assets/img/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32"     href="<?=THEMEPATH?>assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96"     href="<?=THEMEPATH?>assets/img/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16"     href="<?=THEMEPATH?>assets/img/favicons/favicon-16x16.png">
    <link rel="manifest" href="<?=THEMEPATH?>manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?=THEMEPATH?>assets/img/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!--<script src="//quuzy.com/pwabuilder-sw-register.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="<?=THEMEPATH?>assets/js/jquery.fancybox.min.js"></script>
    <script src="<?=THEMEPATH?>assets/js/quuzy.js"></script>


    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=auto" rel="stylesheet">
    <link href="<?=THEMEPATH?>assets/css/fontawesome-all.min.css" rel="stylesheet">
    <link href="<?=THEMEPATH?>assets/css/jquery.fancybox.min.css" rel="stylesheet">
    <link href="<?=THEMEPATH?>assets/css/quuzy.css" rel="stylesheet">
    <?php
        $urlParse = $this->urlParse();
        //print_r($urlParse);
    ?>

    <script data-ad-client="ca-pub-9896875941850273" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>
<body data-username="<?=$urlParse['subFolder']??'quuzy'?>" data-page-type="<?=$this->page?>">