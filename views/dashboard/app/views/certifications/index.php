<!-- **********************************************************************************************************************************************************
    contenu principal
    *********************************************************************************************************************************************************** -->
<!--contenu principal debut-->
<section id="main-content">
    <section class="wrapper">

        <!-- row -->
        <div class="row mt">
            <div class="col-md-12">
                <?php if (!empty($msg)): ?>
                    <div class="alert alert-success">
                        <?php echo $msg ?>
                    </div>
                <?php endif; ?>
                <div class="inp-centre table-responsive" style="padding: 2rem;">
                    <table class="table table-striped table-advance table-hover">
                        <h4><i class="fa fa-angle-right"></i> Listes des certifications disponibles
                            &nbsp;&nbsp;&nbsp;&nbsp; <a href="?p=admin.certifications.add" class="btn btn-success">Ajouter</a>
                        </h4>
                        <hr>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th width="40%">Nom de la certification</th>
                            <th>Score Minimum de réussite</th>
                            <th width="20%"> Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($certifications as $certification): ?>
                            <tr>
                                <td><b><?php echo $certification->idCert; ?></b></td>
                                <td><?php echo $certification->NomCertification; ?></td>
                                <td><?php echo $certification->ScoreReussite; ?></td>
                                <td><a href="?p=admin.certifications.edit&id=<?php echo $certification->idCert; ?>"
                                       class="btn btn-sm btn-primary">Editer</a>
                                    <a href="?p=admin.certifications.delete&id=<?php echo $certification->idCert; ?>"
                                       class="btn btn-sm btn-danger">Supprimer</a></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /row -->
    </section>
</section>
<!--contenue principal fin-->