<?php 

require '../vendor/autoload.php';

use App\Classes\Host;
use App\Repository\HostRepository;
use App\Forms\Validator;
use slugifier as s;

//id
if (isset($_GET['id'])){
    $host = HostRepository::getHostById($_GET['id']);
}

//update
if (isset($_POST['submit'])){
    $code = 'HOST_' . s\slugify(Validator::verifyInput($_POST['name']), '_');
    $newHost = new Host(0,
    strtoupper($code),
    Validator::verifyInput($_POST['name']),
    Validator::verifyInput($_POST['notes']));
    $errors = Validator::checkHost($newHost);
    if (null === $errors){
        HostRepository::updateHost($host, $newHost);
        header("Location: View.php");
    }
}

//delete
if (isset($_POST['submit_delete'])){
    $host = HostRepository::getHostById($_GET['id']);
    HostRepository::deleteHost($host);
    header('Location: View.php');
}

?>

<!DOCTYPE html>
<html>
    <head>
        <base href='../'>
        <title>Modifier un hébergeur</title>
        <base href="../">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="public/js/script.js"></script>
        <link rel="stylesheet" href="public/css/styles.css">
    </head>
    
    <body>
        
        <?php require '../layout/navbar.php' ?>
        
        <section id="update">

            <div class="container-fluid">
                <div class="row">

                    <!-- menu -->                 
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <?php require '../layout/menu.php' ?>
                    </div>

                    <!-- titre -->
                    <div class="col-lg-9 col-md-9 col-sm-12">

                        <!-- lien -->
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h2 class="nouv"><?php echo $host->getName(); ?></h2>
                            <ul class="listContact">
                                <a href="Host/view.php" class="infoGenerale">INFORMATIONS GÉNÉRALES</a>&emsp;
                                <a href="Contact/<?php echo 'H-'.$_GET['id']."-1"?>" class="contactLien2">CONTACTS HEBERGEUR</a>
                            </ul>
                        </div>

                        <!-- debut carré -->
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="add">

                                <!-- début form -->
                                <form method='Post'>

                                    <label class="lab">Nom <span style="color:red">*</span></label>
                                    <input name='name' class="input0" value="<?php echo $host->getName(); ?>">
                                    <p class="error"><?php echo (!isset($errors['nameError']))? '' : $errors['nameError'] ?></p>

                                    <br>

                                    <label class="lab">Code interne</label>
                                    <button disabled="disabled" class="input1" value="<?php echo $host->getCode(); ?>">Champs généré automatiquement</button>

                                    <br>

                                    <label class="lab2">Notes / remarques</label>
                                    <textarea name='notes' class="textarea2"><?php echo $host->getNotes(); ?></textarea>
                                    <p class="error"><?php echo (!isset($errors['notesError']))? '' : $errors['notesError'] ?></p>

                                    <!-- bouton form -->
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="btnPlace">   
                                            <button type='submit' name='submit' class="btnOrange"><span class="glyphicon glyphicon-ok"></span> SAUVEGARDER</button>&emsp;
                                            <a href="#" data-toggle='modal' data-target='#modal'class="btnOrange"><span class="glyphicon glyphicon-trash"></span> SUPPRIMER</a>
                                        </div>
                                        <br>
                                        <div class="btnPlace1">
                                            <a href="Host/View.php" class="btnBlanc">Annuler</a> 
                                        </div>

                                        <!-- modal suppression -->
                                        <div class='modal fade' id='modal'> 
                                            <div class='modal-dialog'>
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <button type='button' class='close' data-dismiss='modal'>x</button>
                                                        <h5 class='modal-title' style="font-weight: bold;">Suppression d'un hébergeur</h5>
                                                    </div>
                                                    <div class='modal-body'>
                                                        <p>Voulez-vous vraiment supprimer l'hébergeur <strong>"<?php echo $host->getName(); ?>"</strong> ?</p>
                                                    </div>
                                                    <div class='modal-footer'>
                                                        <form method="post">
                                                            <input type='hidden' value="<?php echo $_GET['id']?>">
                                                            <button type='submit' name='submit_delete' class="btnOrange">Supprimer</button>&emsp;
                                                        </form>
                                                        <button type='button' class='btnBlanc' data-dismiss='modal'>Fermer</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                          
                                    </div>

                                </form>
                                
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </section>
        
        <?php require '../layout/footer.php' ?>
        
    </body>

</html>