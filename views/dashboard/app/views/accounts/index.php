<section id="main-content">
    <section class="wrapper">
        <h3></h3>

        <!-- row -->
        <div class="row mt">
            <div class="col-md-12">
                <div class="inp-centre table-responsive" style="padding: 2rem;">
                    <table class="table table-striped table-advance table-hover">
                        <h4><i class="fa fa-angle-right"></i> Listes des surveillants</h4>
                        <hr>
                        <thead>
                        <tr>
                            <th>Matricule</th>
                            <th class=""> Nom</th>
                            <th>Site affecté</th>
                            <th> Salle surveillée</th>
                            <th> Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        foreach ($surveillants as $s) :
                            ?>

                            <tr>
                                <td><?php echo $s->Matricule ?></td>
                                <td><?php echo $s->Nom ?></td>
                                <td><?php echo $s->NomSite ?></td>
                                <td>Salle - <?php echo $s->NumSalle ?></td>
                                <td>
                                    <?php
                                    if ($s->NiveauAcces > 0) :
                                        ?>
                                        <button class="btn btn-danger btn-xs" style="color: white"
                                                onclick="goto('<?php echo url("admin/remove_surveillant.php?id={$s->idSurveillant}")?>')">
                                            Retirer
                                            les droits
                                        </button>
                                    <?php
                                    else :
                                        ?>
                                        <button class="btn btn-success btn-xs"
                                                onclick="goto('<?php echo url("admin/reset_surveillant.php?id={$s->idSurveillant}")?>')">
                                            Rétablir
                                            les
                                            droits
                                        </button>
                                    <?php
                                    endif;
                                    ?>

                                </td>
                            </tr>
                        <?php
                        endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

        <!-- /row -->
    </section>

    <div style="padding-left: 16px; ">
        <button style="height: 35px; color: white" onclick="goto('<?php echo url('admin/add_surveillant.php')?>')"
                class="btn btn-primary btn-xs">
            <i class="fa fa-user-plus"></i> Ajouter surveillant
        </button>
    </div>

    <section class="wrapper">

        <!-- row -->
        <div class="row mt">
            <div class="col-md-12">
                <div class="inp-centre table-responsive" style="padding: 2rem;">
                    <table class="table table-striped table-advance table-hover dataTable">
                        <h4><i class="fa fa-angle-right"></i> Listes des étudiants inscrits </h4>
                        <hr>
                        <thead>
                        <tr>
                            <th>Matricule</th>
                            <th style="width: 50%"> Nom</th>
                            <th> Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        foreach ($students as $st) :
                            ?>
                            <tr>
                                <td><?php echo $st->Matricule ?></td>
                                <td style="width: 50%"><?php echo $st->Nom ?></td>

                                <?php
                                if ($st->StatutCompte > 0) :
                                    ?>
                                    <td >
                                        <button class="btn btn-danger btn-xs" style="color: white"
                                                onclick="goto('<?php echo url("admin/lock_account.php?id={$st->idUtilisateur}") ?>')">
                                            Bloquer le compte
                                        </button>
                                    </td>

                                <?php
                                else :
                                    ?>
                                    <td>
                                        <button class="btn btn-success btn-xs" style="color: white"
                                                onclick="goto('<?php echo url("admin/unlock_account.php?id={$st->idUtilisateur}") ?>')">
                                            Débloquer le compte
                                        </button>
                                    </td>
                                <?php
                                endif;
                                ?>
                            </tr>
                        <?php
                        endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- /row -->
    </section>


</section>