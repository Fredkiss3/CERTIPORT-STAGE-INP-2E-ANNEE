<!--contenue principal debut-->
<section id="main-content">
    <section class="wrapper">
        <div style="padding-left: 16px; margin: 2rem auto;" class="text-center">
            <?php
            if ($can_reserve and !$max_res and !$salles_fermees) : ?>
                <button style="color: white"
                        onclick="<?php echo "goto('" . url('reservations/') . "')" ?>"
                        class="btn btn-primary btn-lg">
                    <i class="fa fas fa-laptop"></i> Faire une nouvelle réservation.
                </button>
            <?php elseif ($salles_fermees): ?>
                <div class="alert alert-danger">
                    Les salles sont fermées.
                </div>
            <?php elseif ($max_res): ?>
                <div class="alert alert-danger">
                    Vous avez atteint votre maximum de réservations pour aujourd'hui.
                </div>
            <?php elseif (!$can_reserve): ?>
                <div class="alert alert-danger">
                    Vous ne pouvez pas encore réserver de machine.
                    Veuillez revenir dans <b id="counter"></b>
                </div>
            <?php endif; ?>
        </div>

        <!-- row -->
        <div class="row mt">
            <div class="col-md-12">
                <div class="inp-centre table-responsive" style="padding: 2rem;">
                    <table class="table table-striped table-advance table-hover">
                        <h4><i class="fa fa-angle-right"></i> Mes Réservations en cours</h4>
                        <hr>
                        <thead>
                        <tr>
                            <th>site</th>
                            <th class="hidden-phone"> salle</th>
                            <th>Date et plage horaire</th>
                            <th>poste</th>
                            <th> Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($res_non_notees as $r) : ?>
                            <tr>
                                <td><?php echo $r->NomSite ?></td>
                                <td>Salle <?php echo $r->NumSalle ?></td>

                                <td><?php echo
                                        ($r->datedif < 0 ?
                                            ($r->datedif == -1 ? "Hier" : $r->dt) :
                                            ($r->datedif == 0 ? "Aujourd'hui" :
                                                ($r->datedif == 1 ? "Demain" : $r->dt)
                                            )
                                        )  . ' de ' . $r->Plage ?></td>
                                <td> Machine <?php echo $r->NumSalle ?></td>
                                <td>
                                    <button class="btn btn-danger btn-xs"
                                            onclick="goto('<?php echo url("surveillant/cancel_reservation.php"). '?id='. $r->idResult ?>')">annuler
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- /row -->

        <div>
            <!-- row -->
            <div class="row mt">
                <div class="col-md-12">
                    <div class="inp-centre table-responsive" style="padding: 2rem;">
                        <table class="table table-striped table-advance table-hover">
                            <h4><i class="fa fa-angle-right"></i> Mes Résultats</h4>
                            <hr>
                            <thead>
                            <tr>
                                <th>Date et Plage Horaire</th>
                                <th> Certification passée</th>
                                <th> Score</th>
                                <th> Appréciation</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($res_notees as $r) : ?>
                                <tr>
                                    <td><?php echo
                                            ($r->datedif < 0 ?
                                                ($r->datedif == -1 ? "Hier" : $r->dt) :
                                                ($r->datedif == 0 ? "Aujourd'hui" :
                                                    ($r->datedif == 1 ? "Demain" : $r->dt)
                                                )
                                            )  . ' de ' . $r->Plage ?></td>
                                    <td><?php echo $r->NomCertification ?></td>
                                    <td><?php echo $r->score ?></td>
                                    <td>
                                        <span class="label label-<?php echo ($r->score > $r->ScoreReussite) ? "success" : "warning" ?> label-mini"><?php echo $r->Apreciation ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>


            <!-- /row -->
        </div>
    </section>
</section>
<!--contenue principal fin-->
<script type="text/javascript">
    api_url = "<?php echo url('api/')?>";
</script>