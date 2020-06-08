<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo(!empty($title) ? $title : "Accueil") ?> | Reserve Certiport</title>

    <link rel="stylesheet" href="<?php echo static_('accueil/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php echo static_('dashboard/lib/font-awesome/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?php echo static_('accueil/css/owl.carousel.min.css') ?>">
    <link rel="stylesheet" href="<?php echo static_('accueil/css/owl.theme.default.min.css') ?>">
    <link rel="stylesheet" href="<?php echo static_('accueil/css/style.css') ?>">
</head>
<body>

<?php echo(!empty($content) ? $content : "") ?>

<script type="text/javascript" src="<?php echo static_('reservations/js/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo static_('accueil/js/owl.carousel.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo static_('reservations/js/popper.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo static_('reservations/js/bootstrap.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo static_('accueil/js/main.js') ?>"></script>
</body>
</html>