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
                        <h4><i class="fa fa-angle-right"></i> Listes des Postes de certification
                            &nbsp;&nbsp;&nbsp;&nbsp; <a href="?p=admin.machines.add" class="btn btn-success">Ajouter</a>
                        </h4>
                        <hr>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th width="20%">Numéro de la machine</th>
                            <th>Site</th>
                            <th>Salle</th>
                            <th width="20%"> Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($machines as $machine): ?>
                            <tr>
                                <td><b><?php echo $machine->idMachine; ?></b></td>
                                <td><?php echo $machine->NumMachine; ?></td>
                                <td><?php echo $machine->NomSite; ?></td>
                                <td><?php echo $machine->NumSalle; ?></td>
                                <td><a href="?p=admin.machines.edit&id=<?php echo $machine->idMachine; ?>" class="btn btn-sm btn-primary">Editer</a>
                                    <a href="?p=admin.machines.delete&id=<?php echo $machine->idMachine;?>" class="btn btn-sm btn-danger">Supprimer</a></td>
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