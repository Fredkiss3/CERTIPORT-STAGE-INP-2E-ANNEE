<!DOCTYPE>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo static_("connectivity/css/bootstrap.min.css") ?>" rel="stylesheet">
    <link href="<?php echo static_("reservations/css/slick.css") ?>" rel="stylesheet">    <!--css externe-->
    <link href="<?php echo static_("reservations/css/slick-theme.css") ?>" rel="stylesheet">    <!--css externe-->
    <link href="<?php echo static_("dashboard/lib/font-awesome/css/font-awesome.min.css") ?>" rel="stylesheet"/>
    <link href="<?php echo static_("reservations/css/style.css") ?>" rel="stylesheet">
    <link href="<?php echo static_("reservations/css/mystyle.css") ?>" rel="stylesheet">    <!--css externe-->
    <link rel="stylesheet" href="<?php echo static_('connectivity/css/sweetalert.css') ?>">

    <title><?php echo(empty($title) ? "Réservations" : $title); ?> | Reserve Certiport</title>

</head>
<body>

    <?php echo(empty($content) ? "" : $content); ?>

<script type="text/javascript" src="<?php echo static_("reservations/js/jquery.min.js") ?>"></script>
<script type="text/javascript" src="<?php echo static_("reservations/js/popper.min.js") ?>"></script>
<script type="text/javascript" src="<?php echo static_("reservations/js/bootstrap.min.js") ?>"></script>
<script type="text/javascript" src="<?php echo static_("reservations/js/slick.min.js") ?>"></script>
<script src="<?php echo static_('connectivity/js/sweetalert.min.js') ?>"></script>

<script type="text/javascript">
        var base_url = "<?php echo url("reservations/") ?>";
        var api_url = "<?php echo url("api/") ?>";

        <?php if(can_reserve() and !salles_fermees() and !max_reserve_atteint()) : ?>
        function reserver(id) {
            // console.log("Réserver " + id);

            var today = $("#day").val();
            plage = $("#pl-" + id).val();
            var data = {};

            data['action'] = "reserver_machine";
            data['today'] = today;
            data['plage'] = plage;
            data['idMachine'] = id;
            data['_token'] = "<?php echo get_token() ?>";

            // console.log(data);

            $.ajax({
                url: base_url + "index.php",
                type: "post",
                data: data,
                success: function (res) {
                    console.log(res);
                    var response = JSON.parse(res);
                    console.log(response);

                    swal({
                        title: response.error ? "Erreur &#x1F628;" :  (response.can_reserve ? "Alerte &#x1F613;" : "Succès &#x1F60A;"),
                        type: response.error ? "error" :  (response.can_reserve ? "warning" : "success"),
                        text: response.msg,
                        html: true,
                        closeOnConfirm: false,
                    }, function () {
                        window.location.reload();
                    })

                }
            })
        }
    <?php endif; ?>
</script>
<script type="text/javascript" src="<?php echo static_("reservations/js/main.js") ?>"></script>
</body>
</html>