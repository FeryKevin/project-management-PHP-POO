<?php

require '../vendor/autoload.php';

use App\Classes\Host;
use App\Repository\HostRepository;
use App\Forms\Validator;
use slugifier as s;

$errors = array();


//insert
if (isset($_POST['submit'])){
    $code = 'HOST_' . s\slugify(Validator::verifyInput($_POST['name']), '_');
    $host = new Host(0,
    strtoupper($code),
    Validator::verifyInput($_POST['name']),
    Validator::verifyInput($_POST['notes']));

    $errors = Validator::checkHost($host);

    if (null === $errors){
        HostRepository::addHost($host);
        header("Location: View.php");
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <base href='../'>
        <title>Ajouter un hébergeur</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="public/js/script.js"></script>
        <link rel="stylesheet" href="public/css/styles.css">
    </head>
    
    <body>
        
        <!-- navbar -->
        <?php require '../layout/navbar.php' ?>
        
        <section id="insert">

            <div class="container-fluid">
                <div class="row">

                    <!-- menu -->
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <?php require '../layout/menu.php' ?>
                    </div>

                    <!-- page -->
                    <div class="col-lg-9 col-md-9 col-sm-12">

                        <!-- lien -->
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h2 class="nouv">Nouvel hébergeur</h2>
                            <ul class="listContact">
                                <a href="Host/insert.php" class="infoGenerale">INFORMATIONS GÉNÉRALES</a>&emsp;
                                <a href="Contact/H-0-new" class="contactLien2">CONTACTS HEBERGEUR</a>
                            </ul>
                        </div>

                        <!-- debut carré -->
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="add">

                                <!-- début form -->
                                <form method='Post'>

                                    <label class="lab">Nom <span style="color:red">*</span></label>
                                    <input name='name' class="input0" value="<?php echo (!isset($_POST['name']))? '' : $_POST['name'] ?>">
                                    <p class="error"><?php echo (!isset($errors['nameError']))? '' : $errors['nameError'] ?></p>

                                    <br>

                                    <label class="lab">Code interne</label>
                                    <button disabled="disabled" class="input1">Champs généré automatiquement</button>

                                    <br>

                                    <label class="lab2">Notes / remarques</label>
                                    <textarea name='notes' class="textarea"><?php echo (!isset($_POST['notes']))? '' : $_POST['notes'] ?></textarea>
                                    <p class="error"><?php echo (!isset($errors['notesError']))? '' : $errors['notesError'] ?></p>

                                    <!-- bouton form -->
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="btnPlace">
                                            <a href="Host/View.php" class="btnBlanc">ANNULER</a>&emsp;
                                            <button type='submit' name='submit' class="btnOrange"><span class="glyphicon glyphicon-ok"></span> SAUVEGARDER</button>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </section>
        
        <!-- footer -->
        <?php require '../layout/footer.php' ?>
        
    </body>

</html>