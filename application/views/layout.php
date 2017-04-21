<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title><?= $title ?></title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="/assets/css/jquery-ui-1.9.2.custom.min.css" />
    <link type="text/css" rel="stylesheet" href="/assets/css/font-awesome-4.7.0/css/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="/assets/css/style.css?v=4" />
    <script type="application/javascript" src="/assets/js/jquery-1.8.3.js"></script>
    <script type="application/javascript" src="/assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script type="application/javascript" src="/assets/js/script.js?v=3"></script>
</head>
<body id="body">
<div class="wrapper">
    <? $this->load->view('includes/menu'); ?>
    <div class="content">
        <div class="search">
            <input name="search" placeholder="Suchen" />
            <a href="javascript:void(0)" id="search"><i class="fa fa-search" aria-hidden="true"></i></a>
        </div>
        <h1><?= $title; ?></h1>
        <?= $content ?>
    </div>
</div>
</body>
</html>