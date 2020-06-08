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
                        <h4><i class="fa fa-angle-right"></i> Listes des utilisateurs
                            &nbsp;&nbsp;&nbsp;&nbsp; <a href="?p=admin.users.add" class="btn btn-success">Ajouter</a>
                            &nbsp;&nbsp;&nbsp;&nbsp; <a href="?p=admin.users.import" class="btn btn-warning">Importer</a>
                            &nbsp;&nbsp;&nbsp;&nbsp; <a href="?p=admin.users.export" class="btn btn-primary">Exporter</a>
                        </h4>
                        <hr>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Matricule</th>
                            <th width="45%"> Nom</th>
                            <th>EMail institutionnel</th>
                            <th>Contact</th>
                            <th width="20%"> Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php for ($i=0; $i<count($users); $i++): ?>
                            <tr>
                                <td><b><?php echo $users[$i]->idUtilisateur; ?></b></td>
                                <td><?php echo $users[$i]->Matricule; ?></td>
                                <td><?php echo $users[$i]->Nom; ?></td>
                                <td><?php echo $users[$i]->Mail; ?></td>
                                <td><?php echo $users[$i]->Contact;  ?></td>
                                <td>
                                    <a href="?p=admin.users.edit&id=<?php echo $users[$i]->idUtilisateur; ?>" class="btn btn-sm btn-primary">Editer</a>
                                    <a href="?p=admin.users.delete&id=<?php echo $users[$i]->idUtilisateur;?>" class="btn btn-sm btn-danger">Supprimer</a>
                                </td>
                            </tr>
                        <?php
                        endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /row -->
    </section>
</section>
<!--contenue principal fin-->