<!-- **********************************************************************************************************************************************************
    contenu principal
    *********************************************************************************************************************************************************** -->
<!--contenu principal debut-->
<section id="main-content">
    <section class="wrapper">

        <!-- row -->
        <div class="row mt">
            <div class="col-md-12">
                <?php if(!empty($msg)): ?>
                    <div class="alert alert-success">
                        <?php echo $msg ?>
                    </div>
                <?php endif; ?>
                <div class="inp-centre table-responsive" style="padding: 2rem;">
                    <table class="table table-striped table-advance table-hover">
                        <h4><i class="fa fa-angle-right"></i> Listes des salles
                            &nbsp;&nbsp;&nbsp;&nbsp; <a href="?p=admin.salles.add" class="btn btn-success">Ajouter</a>
                        </h4>
                        <hr>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Numéro</th>
                            <th>Site</th>
                            <th>Surveillant affecté</th>
                            <th width="20%"> Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($salles as $salle): ?>
                            <tr>
                                <td><b><?php echo $salle->idSalle; ?></b></td>
                                <td><?php echo $salle->NumSalle; ?></td>
                                <td><?php echo $salle->NomSite; ?></td>
                                <td><?php echo $salle->NomSurveillant; ?></td>
                                <td><a href="?p=admin.salles.edit&id=<?php echo $salle->idSalle; ?>" class="btn btn-sm btn-primary">Editer</a>
                                    <a href="?p=admin.salles.delete&id=<?php echo $salle->idSalle;?>" class="btn btn-sm btn-danger">Supprimer</a></td>
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