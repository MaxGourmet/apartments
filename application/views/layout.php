<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <link type="text/css" rel="stylesheet" href="/assets/css/jquery-ui-1.9.2.custom.min.css" />
    <link type="text/css" rel="stylesheet" href="/assets/css/style.css" />
    <script type="application/javascript" src="/assets/js/jquery-1.8.3.js"></script>
    <script type="application/javascript" src="/assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script type="application/javascript" src="/assets/js/script.js"></script>
</head>
<body>
<div class="body">
    <? $this->load->view('includes/menu'); ?>
    <h1><?= $title; ?></h1>
    <div class="content">
        <?= $content ?>
    </div>
</div>
</body>
</html>