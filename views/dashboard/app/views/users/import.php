<section id="main-content">
    <section class="wrapper">


        <h1>Importer la base de données depuis un fichier <b>CSV</b></h1>
        <?php if (!empty($err)) : ?>
            <div class="alert alert-danger"><?php echo $err ?></div>
        <?php elseif (!empty($success)) : ?>
            <div class="alert alert-success"><?php echo $success ?></div>
        <?php endif; ?>
        <pre style="font-size: 15px; max-width: 500px">

    Les champs à importer sont, dans l'ordre :
        <b>Matricule, Nom, Mail, Contact</b>

</pre>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="file" class="btn btn-primary" required><br>
            <input type="submit" value="Envoyer" class="btn btn-success">
            <a href="?p=admin.users.index" class="btn btn-primary" id="retour">Retour</a>
        </form>
    </section>
</section>