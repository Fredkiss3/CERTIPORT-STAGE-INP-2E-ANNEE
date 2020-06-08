<!-- **********************************************************************************************************************************************************
    contenu principal
    *********************************************************************************************************************************************************** -->
<!--contenu principal debut-->
<section id="main-content">
    <section class="wrapper">
        <!-- row -->
        <div class="row mt">
            <div class="col-md-12">
                <div class="inp-centre table-responsive" style="padding: 2rem;">
                    <table class="table table-striped table-advance table-hover">
                        <h4><i class="fa fa-angle-right"></i> Listes des réservations <span
                                    class="label label-warning label-mini">Non notées</span></h4>
                        <hr>
                        <thead>
                        <tr>
                            <th>Matricule</th>
                            <th class="hidden-phone"> Nom</th>
                            <th>Date</th>
                            <th> Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($res_non_notees as $r): ?>
                            <tr>
                                <td><?php echo $r->Matricule ?></td>
                                <td><?php echo $r->Nom ?></td>
                                <td><?php echo
                                        ($r->datedif < 0 ?
                                            ($r->datedif == -1 ? "Hier" : $r->dt) :
                                            ($r->datedif == 0 ? "Aujourd'hui" :
                                                ($r->datedif == 1 ? "Demain" : $r->dt)
                                            )
                                        ) . " de " . $r->Plage ?></td>

                                <td>
                                    <button class="btn btn-primary btn-xs"
                                            onclick="goto('<?php echo url((auth()->is_admin() ? "admin" : "surveillant")) . '/note_reservation.php' . '?id=' . $r->idResult ?>')">
                                         Noter
                                    </button>

                                    <?php if (auth()->is_admin()) : ?>
                                        <button onclick="goto('<?php echo url('admin/delete_reservation.php?id=' . $r->idResult) ?>')"
                                                class="btn btn-danger btn-xs"><i
                                                    style="height: 17px;"
                                                    class="fa fa-trash"></i>
                                        </button>
                                    <?php endif; ?>

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
                            <h4><i class="fa fa-angle-right"></i> Listes des réservations <span
                                        class="label label-success label-mini">notées</span></h4>
                            <hr>
                            <thead>
                            <tr>
                                <th>Matricule</th>
                                <th class=""> Nom</th>
                                <th class=""> Certification passée</th>
                                <th class=""> Score</th>
                                <th class=""> Appréciation</th>
                                <th>Date</th>
                                <th> Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            //                                dd($res_notees);
                            foreach ($res_notees as $r) :
                                ?>
                                <tr>


                                    <td><?php echo $r->Matricule ?></td>
                                    <td><?php echo $r->Nom ?></td>
                                    <td><?php echo $r->NomCertification ?></td>
                                    <td><?php echo $r->score ?></td>
                                    <td>
                                        <span class="label label-<?php echo ($r->score >= $r->ScoreReussite) ? "success" : "warning" ?> label-mini"><?php echo $r->Apreciation ?></span>
                                    </td>
                                    <td><?php
                                        echo
                                            ($r->datedif < 0 ?
                                                ($r->datedif == -1 ? "Hier" : $r->dt) :
                                                ($r->datedif == 0 ? "Aujourd'hui" :
                                                    ($r->datedif == 1 ? "Demain" : $r->dt)
                                                )
                                            ) . " de " . $r->Plage ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-xs"
                                                onclick="goto('<?php echo url((auth()->is_admin() ? "admin" : "surveillant")) . '/note_reservation.php' . '?id=' . $r->idResult ?>')">
                                           <i class="fa fa-edit"></i> modifier
                                        </button>

                                        <?php if (auth()->is_admin()) : ?>
                                            <button onclick="goto('<?php echo url('admin/delete_reservation.php?id=' . $r->idResult) ?>')"
                                                    class="btn btn-danger btn-xs"><i
                                                        style="height: 17px;"
                                                        class="fa fa-trash"></i>
                                            </button>
                                        <?php endif; ?>

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
