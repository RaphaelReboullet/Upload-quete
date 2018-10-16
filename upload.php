<?php

$extensions = array('image/jpg', 'image/png', 'image/gif');
$taille_maxi = 100000;

for($i = 0; $i < count($_FILES['fichier']['name']); $i++) {
    $dossier = 'images/';
    $fichier = $_FILES['fichier']['name'][$i];
    $taille = $_FILES['fichier']['size'][$i];
    $extension = $_FILES['fichier']['type'][$i];

    $ext = strrchr($_FILES['fichier']['name'][$i], '.');

    if(!in_array($extension, $extensions))
    {
         $erreur = 'Vous devez uploader un fichier de type jpg, png, gif';
    }

    if($taille>$taille_maxi)
    {
         $erreur = 'Le fichier est trop gros...';
    }

    if(!isset($erreur))
    {
         if(move_uploaded_file($_FILES['fichier']['tmp_name'][$i], $dossier . 'image' . uniqid() . $ext))
         {
              echo 'Upload effectué avec succès !';
         }
         else
         {
              echo 'Echec de l\'upload !';
         }
    }
    else
    {
         echo $erreur;
    }
}


if(isset($_REQUEST['delete'])) {
    $link = 'images/'.$_REQUEST['delete'];
    if(unlink($link)) {
        echo 'fichier supprimé';
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>

<form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
    <input type="file" name="fichier[]" multiple="multiple"/>
    <input type="submit" value="Send" />
</form>

<div class="row">
    <?php
    $images = scandir('images/');
    foreach ($images as $image)
    {
        if ($image != '.' and $image != '..')
        { ?>
            <section class="card col-12 col-md-6"">
            <img class="card-img-top w-100" src="images/<?= $image ?>" alt="Numéro <?= $image ?>">
            <div class="card-body">
                <p class="text-center"><?= $image ?></p>
                <a href="upload.php?delete=<?php echo $image; ?>" class="btn btn-info btn-lg">Supprimer</a>
            </div>
            </section>
            <?php
        }
    } ?>
</div>

</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>



