<?php

require '../vendor/autoload.php';

use App\Classes\Customer;
use App\Classes\Host;
use App\Classes\Project;
use App\Repository\ProjectRepository;
use App\Repository\CustomerRepository;
use App\Repository\HostRepository;
use App\Forms\Validator;
use slugifier as s;

$errors = array();

//insert
if (isset($_POST['submit'])){
    $code = s\slugify('PROJECT_'. Validator::verifyInput($_POST['name']), '_');
    $code = strtoupper($code);
    $lastpass_folder = (isset($_POST['lastpass_folder'])) ? $_POST['lastpass_folder'] : null ;
    $link_mock_ups = (isset($_POST['link_mock_ups'])) ? $_POST['link_mock_ups'] : null ;
    $managed_server = (isset($_POST['managed_server'])) ? 1 : 0;
    $host = (isset($_POST['host'])) ? HostRepository::getHostById($_POST['host']) : new Host(0,0,0,0);
    $customer = (isset($_POST['customer'])) ? CustomerRepository::getCustomerById($_POST['customer']) : new Customer(0,0,0,0);

    $project = new Project(0,
    Validator::verifyInput($_POST['name']),
    $code,
    Validator::verifyInput($lastpass_folder),
    Validator::verifyInput($link_mock_ups),
    Validator::verifyInput($managed_server),
    Validator::verifyInput($_POST['notes']),
    $host,
    $customer);

    $errors = Validator::checkProject($project);
    if (null === $errors){
        ProjectRepository::addProject($project);
        header("Location: View.php");
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <base href='../'>
        <title>Ajouter un projet</title>
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
                            <h2 class="nouv">Nouveau projet</h2>
                            <ul class="listContact">
                                <a href="Customer/insert.php" class="infoGenerale">INFORMATIONS GÉNÉRALES</a>&emsp;
                                <a href="Environment/E-0-new" class="contactLien1">ENVIRONNEMENT PROJET</a>
                            </ul>
                        </div>

                        <!-- debut carré -->
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="add2">

                                <!-- début form -->
                                <form method='Post'>

                                    <div class="col-lg-6 col-md-12 col-sm-12">

                                        <br><br>

                                        <!-- nom -->
                                        <div class="nom">
                                            <label class="lab" for='name'>Nom <span style="color:red">*&emsp;&emsp;&emsp;</span></label>
                                            <input name='name' class="input2" value="<?php echo $_POST['name'] ?? ''?>">
                                            <p class="error"><?php echo $errors['nameError'] ?? '' ?></p>
                                        </div><br>

                                        <!-- code -->
                                        <div class="code">
                                            <label class="lab">Code interne</label>
                                            <button disabled="disabled" class="input3">Champs généré automatiquement</button>
                                        </div><br><br>
                                        
                                        <!-- client -->
                                        <div class="customer">
                                            <label class="lab" for='customer'>Client <span style="color:red">*&emsp;&emsp;&emsp;</span></label>
                                            <select type="text" name='customer' class="select0">  
                                                <option disabled selected>Sélectionner un client</option>
                                                <?php 

                                                $customers = CustomerRepository::getCustomer();

                                                foreach ($customers as $customer) 
                                                {
                                                    echo '<option value="'. $customer->getId() . '">'. $customer->getName() . '</option>';
                                                }

                                                ?>
                                            </select>
                                            <p class="error"><?php echo (!isset($errors['customerError']))? '' : $errors['customerError'] ?></p>
                                        </div><br>

                                        <!-- hebergeur -->
                                        <div class="host">
                                            <label class="lab" for='host'>Hébergeur <span style="color:red">*&emsp;</span></label>
                                            <select type="text" name='host' class="select1">
                                                <option disabled selected>Sélectionner un hébergeur</option>
                                                <?php 

                                                $host = HostRepository::getHost();

                                                foreach ($host as $host) 
                                                {
                                                    echo '<option value="'. $host->getId() . '">'. $host->getName() . '</option>';
                                                }

                                                ?>
                                            </select>
                                            <p class="error"><?php echo (!isset($errors['hostError']))? '' : $errors['hostError'] ?></p>
                                        </div><br>
                                        
                                        <!-- serveur infogéré --> 
                                        <div class="serveur"> 
                                            <label class="labCheck" for='managed_server'>
                                            <input name='managed_server' type='checkbox'></label> Serveur infogéré
                                        </div><br><br>

                                        <!-- notes -->
                                        <div class="notes">
                                            <label class="lab2">Notes / remarques</label>
                                            <textarea name='notes' class="textarea1"><?php echo (!isset($_POST['notes']))? '' : $_POST['notes'] ?></textarea>
                                            <p class="error"><?php echo (!isset($errors['notesError']))? '' : $errors['notesError'] ?></p>
                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                    
                                        <br><br>

                                        <!-- dossier lastpass-->
                                        <div class="dossier">
                                            <label class="lab">Dossier Lastpass</label>
                                            <input name='lastpass_folder' class="input4" value="<?php echo (!isset($_POST['lastpass_folder']))? '' : $_POST['lastpass_folder'] ?>"><br>
                                        </div><br><br>

                                        <!-- lien maquettes-->
                                        <div class="maquettes">
                                            <label class="lab">Lien&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</label>
                                            <input name='link_mock_ups' class="input5" value="<?php echo (!isset($_POST['link_mock_ups']))? '' : $_POST['link_mock_ups'] ?>">
                                        </div>
                                        
                                    </div>
                                                                        
                                    <!-- bouton form -->
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <br><br>
                                        <div class="btnPlace1">
                                            <a href="Project/View.php" class="btnBlanc">ANNULER</a>&emsp;
                                            <button type='submit' name='submit' class="btnOrange"><span class="glyphicon glyphicon-ok"></span> SAUVEGARDER</button>
                                        </div>
                                        <br><br><br><br>
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