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

/* id */
if (isset($_GET['id'])){
    $project = ProjectRepository::getProjectById($_GET['id']);
}

/* update */
if (isset($_POST['submit'])){
    $code = 'PROJECT_'. s\slugify(Validator::verifyInput($_POST['name']), '_');
    $host = (isset($_POST['host'])) ? HostRepository::getHostById($_POST['host']) : new Host(0,0,0,0);
    $customer = (isset($_POST['customer'])) ? CustomerRepository::getCustomerById($_POST['customer']) : new Customer(0,0,0,0);
    $server = (isset($_POST['managed_server'])) ? 1 : 0;
    $newProject = new Project(0,
    Validator::verifyInput($_POST['name']),
    $code = strtoupper($code),
    Validator::verifyInput($_POST['lastpass_folder']),
    Validator::verifyInput($_POST['link_mock_ups']),
    $server,
    Validator::verifyInput($_POST['notes']),
    $host,
    $customer);

    $errors = Validator::checkProject($newProject);
    if (null === $errors){
        ProjectRepository::updateProject($project, $newProject);
        header("Location: View.php");
    }
}

/* delete */
if (isset($_POST['submit_delete'])){
    $project = ProjectRepository::getProjectById($_GET['id']);
    ProjectRepository::deleteProject($project);
    header('Location: View.php');
}

?>

<!DOCTYPE html>
<html>
    <head>
        <base href='../'>
        <title>Modifier un projet</title>
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
                            <h2 class="nouv"><?php echo $project->getName(); ?></h2>
                            <ul class="listContact">
                                <a href="Project/<?php echo $_GET['id'] ?>" class="infoGenerale">INFORMATIONS GÉNÉRALES</a>&emsp;<?php echo'
                                <a href="Environment/E-' .$_GET['id'] .'-1" class="contactLien1">ENVIRONNEMENTS PROJET</a>';?>
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
                                            <input name='name' class="input2" value="<?php echo $project->getName()?>">
                                            <p class="error"><?php echo (!isset($errors['nameError']))? '' : $errors['nameError'] ?></p>
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
                                                <option disabled></option>
                                                <?php 

                                                $customers = CustomerRepository::getCustomer();                                            

                                                foreach ($customers as $customer) 
                                                {
                                                    if ($customer == $project->getCustomer()){
                                                        echo '<option value="'. $customer->getId() . '" selected>'. $customer->getName() . '</option>';
                                                    }
                                                    else{
                                                        echo '<option value="'. $customer->getId() . '">'. $customer->getName() . '</option>';
                                                    }
                                                }

                                                ?>
                                            </select>
                                            <p class="error"><?php echo (!isset($errors['customerError']))? '' : $errors['customerError'] ?></p>
                                        </div><br>

                                        <!-- hebergeur -->
                                        <div class="host">
                                            <label class="lab" for='host'>Hébergeur <span style="color:red">*&emsp;</span></label>
                                            <select type="text" name='host' class="select1">
                                                <option disabled></option>
                                                <?php 

                                                $host = HostRepository::getHost();

                                                foreach ($host as $host) 
                                                {
                                                    if ($host == $project->getHost()){
                                                        echo '<option value="'. $host->getId() . '" selected>'. $host->getName() . '</option>';
                                                    }
                                                    else{
                                                        echo '<option value="'. $host->getId() . '">'. $host->getName() . '</option>';
                                                    }
                                                }

                                                ?>
                                            </select>
                                            <p class="error"><?php echo (!isset($errors['hostError']))? '' : $errors['hostError'] ?></p>
                                        </div><br>
                                        
                                        <!-- serveur infogéré --> 
                                        <div class="serveur"> 
                                            <label class="labCheck" for='managed_server'>
                                            <input name='managed_server' type='checkbox' <?php echo $project->getManaged_server()==0 ? '': 'checked' ?>></label> Serveur infogéré
                                        </div><br><br>

                                        <!-- notes -->
                                        <div class="notes">
                                            <label class="lab2">Notes / remarques</label>
                                            <textarea name='notes' class="textarea1"><?php echo $project->getNotes();?></textarea>
                                            <p class="error"><?php echo (!isset($errors['notesError']))? '' : $errors['notesError'] ?></p>
                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                    
                                        <br><br>

                                        <!-- dossier lastpass-->
                                        <div class="dossier">
                                            <label class="lab">Dossier Lastpass</label>
                                            <input name='lastpass_folder' class="input4" value="<?php echo $project->getLastpast_folder() ;?>"><br>
                                        </div><br><br>

                                        <!-- lien maquettes-->
                                        <div class="maquettes">
                                            <label class="lab">Lien&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</label>
                                            <input name='link_mock_ups' class="input5" value="<?php echo $project->getLink_mock_ups() ;?>">
                                        </div>
                                        
                                    </div>
                                                                        
                                    <!-- bouton form -->
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="btnPlace">   
                                            <button type='submit' name='submit' class="btnOrange"><span class="glyphicon glyphicon-ok"></span> SAUVEGARDER</button>&emsp;
                                            <a href="#" data-toggle='modal' data-target='#modal'class="btnOrange"><span class="glyphicon glyphicon-trash"></span> SUPPRIMER</a>
                                        </div>
                                        <br>
                                        <div class="btnPlace1">
                                            <a href="Project/View.php" class="btnBlanc">Annuler</a> 
                                        </div>

                                        <!-- modal suppression -->
                                        <div class='modal fade' id='modal'> 
                                            <div class='modal-dialog'>
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <button type='button' class='close' data-dismiss='modal'>x</button>
                                                        <h5 class='modal-title' style="font-weight: bold;">Suppression d'un projet</h5>
                                                    </div>
                                                    <div class='modal-body'>
                                                        <p>Voulez-vous vraiment supprimer le projet <strong>"<?php echo $project->getName(); ?>"</strong> ?</p>
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