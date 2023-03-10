<?php 

require '../vendor/autoload.php';

use App\Classes\Environment;
use App\Classes\Project;
use App\Repository\EnvironmentRepository;
use App\Repository\ProjectRepository;
use App\Forms\Validator;
use slugifier as s;

//insert
if (isset($_POST['submit'])){

    $name = (isset($_POST['name'])) ? $_POST['name'] : null ;
    $link = (isset($_POST['link'])) ? $_POST['link'] : null ;
    $ip_address = (isset($_POST['ip_address'])) ? $_POST['ip_address'] : null ;
    $ssh_port = (isset($_POST['ssh_port'])) ? $_POST['ssh_port'] : null ;
    $ssh_username = (isset($_POST['ssh_username'])) ? $_POST['ssh_username'] : null ;
    $phpmyadmin_link = (isset($_POST['phpmyadmin_link'])) ? $_POST['phpmyadmin_link'] : null ;
    $ip_restriction = (isset($_POST['ip_restriction'])) ? 1 : 0;

    if (isset($_POST['project'])) {
        $project = ProjectRepository::getProjectById($_POST['project']);
    }
    elseif (isset($_GET['id']) && $_GET['id'] != 0 ){
        $project = ProjectRepository::getProjectById($_GET['id']);
    }

    $environment = new Environment(
        0,
        Validator::verifyInput($name),
        Validator::verifyInput($link),
        Validator::verifyInput($ip_address),
        Validator::verifyInput(intval($ssh_port)),
        Validator::verifyInput($ssh_username),
        Validator::verifyInput($phpmyadmin_link),
        Validator::verifyInput($ip_restriction),
        $project,
    );

    $errors = Validator::checkEnvironment($environment);
    if (null === $errors){
        EnvironmentRepository::addEnvironment($environment);
        header("Location: ../project/all");
    }

}

?>

<!DOCTYPE html>
<html>
    <head>
        <base href='../'>
        <title>Ajouter un environment</title>
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
                            <h2 class='nouv'>Nouvel environnement</h2>
                            <ul class="listContact">
                                <a href="Project/insert.php" class="infoGenerale2">INFORMATIONS GÉNÉRALES</a>&emsp;
                                <a href="Environment/E-0-new" class="contactLien4">CONTACTS ENVIRONNEMENT</a>
                            </ul>
                        </div>

                        <!-- debut carré -->
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="add">

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <form method="Post">  

                                        <div class="envAffichage">
                                                                                                                                                                                        
                                            <input type="hidden" name="idContact" value=''>

                                            <br>
                                            <!-- nom -->
                                            <div class="nom">                                       
                                                <label class="labEnv" for="name">Nom &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</label>
                                                <input name="name" class="inputEnv0" value="<?php echo $_POST['name'] ?? '' ?>">
                                            </div>
                                            <br>

                                            <!-- addresse ip -->
                                            <div class="addresse_ip">
                                                <label class="labEnv" for="ip_address">Adresse IP&emsp;&emsp;&emsp;&emsp;</label>
                                                <input class="inputEnv1" name="ip_address" value="<?php echo $_POST['ip_address'] ?? '' ?>">
                                            </div> 
                                            <br>
                                            
                                            <!-- ssh username -->
                                            <div class="ssh_username">
                                                <label class="labEnv" for="ssh_username">Nom d'utilisateur &emsp;</label>
                                                <input class="inputEnv2" name="ssh_username" value="<?php echo $_POST['ssh_username'] ?? '' ?>">
                                            </div>  
                                
                                            <!-- project -->
                                            <?php 
                                                
                                            if ($_GET['id'] == 0){
                                                echo'
                                                <div class="group-form">
                                                    <div class="project">
                                                        <label class="labEnv" for="project">Projet <span style="color:red">*&emsp;</span></label>
                                                        <select type="text" name="project" class="selectEnv">';

                                                            $project = ProjectRepository::getProject();

                                                            foreach ($project as $project) 
                                                            {
                                                                echo '<option value="'. $project->getId() . '">'. $project->getName() . '</option>';
                                                            }

                                                        echo"
                                                        </select>
                                                        <p class='erreurEnv'> ". (!isset($errors['projectError']))? '' : $errors['projectError']."</p>
                                                    </div>
                                                </div>";
                                                }

                                            ?>

                                            <br>

                                            <div class="form-right">

                                                <!-- port ssh -->
                                                <div class="port_ssh">
                                                    <label class="labContact" for="ssh_port">Port SSH &emsp;</label>
                                                    <input class="inputEnv4" name="ssh_port" value="<?php echo $_POST['ssh_port'] ?? '' ?>">
                                                    <p class='error'><?php echo $errors['ssh_portError']?? '' ?></p>

                                                    <!-- ip restriction -->
                                                    <label for="ip_restriction">
                                                    <input type="checkbox" name="ip_restriction">&emsp;Restriction IP</label>
                                                </div> 

                                                <!-- PHPMyAdmin -->
                                                <div class="PHPMyAdmin">
                                                    <label class="labContact" for="phpmyadmin_link">Lien PHPMyAdmin &emsp;</label>
                                                    <input class="inputEnv5" name="phpmyadmin_link" value="<?php echo $_POST['phpmyadmin_link'] ?? '' ?>">
                                                </div>    
                                                       
                                                <br>

                                                <!-- link -->
                                                <div class="link">
                                                    <label class="labContact" for="link">Lien&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</label>
                                                    <input class="inputEnv6" name="link" value="<?php echo $_POST['link'] ?? '' ?>">   
                                                </div>    
                                                

                                            </div>
                                        </div>

                                        <br>

                                        <!-- ajouter -->
                                        <button type="submit" name="submit" class="btnOrange">+ AJOUTER</a>

                                    </form>
                                </div>
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