<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php if (!empty($title)): echo $title; else: echo "Accueil"; endif; ?> | Reserve Certiport</title>
    <link rel="stylesheet" href="<?php echo static_('connectivity/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?php echo static_('connectivity/css/sweetalert.css')?>">
    <link rel="stylesheet" href="<?php echo static_('connectivity/css/style.css')?>">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

<?php if (!empty($content)): echo $content; else: echo ""; endif; ?>

<!-- </div> -->
<script src="<?php echo static_('connectivity/js/jquery.min.js')?>"></script>
<script src="<?php echo static_('connectivity/js/jquery.inputmask.min.js')?>"></script>
<script type="text/javascript" src="<?php echo static_('connectivity/js/bootstrap.min.js')?>"></script>
<script src="<?php echo static_('connectivity/js/sweetalert.min.js')?>"></script>
<script type="text/javascript">
    var base_url = "<?php echo url("connectivity/") ?>";
    console.log(base_url + "register.php");
</script>
<script type="text/javascript" src="<?php echo static_('connectivity/js/main.js')?>"></script>
</body>
</html><?php
