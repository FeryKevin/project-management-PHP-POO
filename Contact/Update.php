<?php 

require '../vendor/autoload.php';

use App\Classes\Contact;
use App\Repository\ContactRepository;
Use App\Repository\HostRepository;
use App\Forms\Validator;
use App\Repository\CustomerRepository;
use slugifier as s;


$customer = $host = null;

//host ou customer
if (isset($_GET['type'])){
    if (isset($_GET['id']) &&  $_GET['type'] == 'H'){
        $contacts = ContactRepository::getContactByHost($_GET['id']);
        $host = HostRepository::getHostById($_GET["id"]);
    }
    elseif (isset($_GET['id']) &&  $_GET['type'] == 'C'){
        $contacts = ContactRepository::getContactByCustomer($_GET['id']);
        $customer = CustomerRepository::getCustomerById($_GET["id"]);
    }
}

//update
if (isset($_POST['submit'])){
    $oldCus = ContactRepository::getContactById($_POST["idContact"]);
    $newContact = new Contact(
        0,
        Validator::verifyInput($_POST['name']),
        Validator::verifyInput($_POST['email']),
        Validator::verifyInput($_POST['phone_number']),
        Validator::verifyInput($_POST['role']),
        $customer,
        $host,
    );
    $errors = Validator::checkContact($newContact);
    if (null === $errors){
        ContactRepository::updateContact($oldCus, $newContact);
        header("Location: ".$_GET['type']."-".$_GET['id'].'-1');
    }
}

//delete
if (isset($_POST['submit_delete'])){
    $contact = ContactRepository::getContactById($_POST['id_con']);
    ContactRepository::deleteContact($contact);
    header("Location: ".$_GET['type']."-".$_GET['id'].'-1');
}

//pagination
$nbPerPage = isset($_GET['nbPage']) ? $_GET['nbPage']: 2;
$currentPage = isset($_GET['page']) ? $_GET['page']: 1;

$pages = ceil(count($contacts)/$nbPerPage);
$allContact = array();

for ($i=($currentPage-1)*$nbPerPage; $i<$currentPage*$nbPerPage; $i++){
    if (isset($contacts[$i])) $allContact[] = $contacts[$i];
}

$contacts = $allContact;

if(isset($_GET['page'])){
    $uri = substr($_SERVER['REQUEST_URI'], 0, -2);
}
else{
    $uri = $_SERVER['REQUEST_URI'];
}

if (empty($_GET)){
    header('Location: all?name=&email=&phone_number=&role=&nbPage=2');
}

?>

<!DOCTYPE html>
<html>
    <head>
        <base href='../'>
        <title>Modifier un contact</title>
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
                            <h2 class="nouv"><?php echo isset($host) ? $host->getName() : $customer->getName()?></h2>
                            <ul class="listContact">
                                <?php 
                                    if(($_GET['type'] == 'C')){
                                        echo'
                                        <a href="Customer/View.php" class="infoGenerale2">INFORMATIONS GÉNÉRALES</a>&emsp;
                                        <a href="Contact/C-' .$_GET['id'] .'-1" class="contactLien3">CONTACTS CLIENT</a>';
                                    }
                                    else
                                    {
                                        if(($_GET['type'] == 'H')){
                                            echo'
                                            <a href="Host/View.php" class="infoGenerale2">INFORMATIONS GÉNÉRALES</a>&emsp;
                                            <a href="Contact/H-' .$_GET['id'] .'-1" class="contactLien4">CONTACTS HEBERGEUR</a>';
                                        }
                                    }
                                ?>
                            </ul>
                        </div>

                        <!-- debut carré -->
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="addContact">

                                <?php

                                /* aucun contacts */
                                if (empty($contacts)){
                                    echo '<p style="text-align:center; padding-top:50px;">Aucun contact</p>';
                                }
                                else{
                                    
                                    echo'<div class="col-lg-12 col-md-12 col-sm-12">';

                                    /* affichage des contacts */

                                    foreach($contacts as $contact){
                                        echo '
                                        <form method="Post">  

                                            <div class="contactAffichage">'                                                

                                                ?>
                                                                                                
                                                <h3 class="nomContact"><?php echo $contact->getName();?></h3>
                                                
                                                <?php echo'  
                                                
                                                <input type="hidden" name="idContact" value='.$contact->getId().'>

                                                <!-- nom -->
                                                <div class="group-form">
                                                    <div class="nom">                                       
                                                        <label class="labContact">Nom du contact <span style="color:red">*</span></label>
                                                        <input name="name" class="inputContact0" value="'.$contact->getName().'">
                                                        <p class="errorContact">';
                                                        echo (!isset($errors['nameError']))? '' : $errors['nameError'];
                                                        echo'</p>   
                                                    </div>
                                                </div>

                                                <!-- email -->
                                                <div class="group-form">
                                                    <div class="email">
                                                        <label class="labContact" for="email">Email&emsp;&emsp;&emsp;&emsp;&emsp;</label>
                                                        <input class="inputContact1" name="email" value="'.$contact->getEmail().'">
                                                        <p class="errorContact">';
                                                        echo (!isset($errors['emailError']))? '' : $errors['emailError'];
                                                        echo'</p>
                                                    </div>    
                                                </div>

                                                <!-- sauvegarder -->
                                                <div class="group-form">
                                                    <button type="submit" name="submit" class="btnOrange"><span class="glyphicon glyphicon-ok"></span> SAUVEGARDER</button>&emsp;                                            
                                                </div>

                                                <div class="form-right">
                                                    <div class="group-form">

                                                    <!-- supprimer -->
                                                    <a href="#" data-toggle="modal" data-target="#modal'.$contact->getId().'"class="btnRouge"><span class="glyphicon glyphicon-trash"></span> SUPPRIMER</a>

                                                        <!-- role -->
                                                        <div class="role">
                                                            <label class="labContact" for="role">Rôle</label>
                                                            <input name="role" class="inputRole" value="'.$contact->getRole().'">
                                                            <br><br>
                                                        </div>
                                                    </div>

                                                    <!-- telephone -->
                                                    <div class="group-form">
                                                        <div class="telephone">
                                                            <label class="labContact" for="phone">Téléphone</label>
                                                            <input class="inputTel" name="phone_number" value="'.$contact->getPhone().'">   
                                                        </div>    
                                                    </div>
                                                </div>

                                                <!-- bouton form -->
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <!-- modal suppression -->
                                                    <div class="modal fade" id="modal'.$contact->getId().'"> 
                                                        <div class="modal-dialog">
                                                            <div class="modal-content"> 
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">x</button>
                                                                    <h5 class="modal-title" style="font-weight: bold;">Suppression d\'un hébergeur</h5>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Voulez-vous vraiment supprimer l\'hébergeur <strong>"'. $contact->getName() .' "</strong> ?</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form method="post">
                                                                        <input type="hidden" name="id_con" value="'.$contact->getId().'">
                                                                        <button type="submit" name="submit_delete" class="btnOrange">Supprimer</button>&emsp;
                                                                    </form>
                                                                    <button type="button" class="btnBlanc" data-dismiss="modal">Fermer</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>'; 
                                    }
                                }

                                ?> 
                                
                                <!-- ajouter -->
                                <br><br>
                                <a href="<?php echo $uri."-new" ?>" class="btnOrange">+ AJOUTER UN CONTACT</a>
                                <br><br>

                                <!-- pagination boutons -->
                                <br><br><br>
                                <div class="btnPlace1">
                                    <ul class="pagination">
                                        <li class="page-item">
                                            <a <?php echo ($currentPage == 1) ? "" : "href='".$uri."-".$currentPage - 1 ."'"?> class="page-link"><span class="glyphicon glyphicon-chevron-left"></span></a>
                                        </li>
                                        <?php for($page = 1; $page <= $pages; $page++): ?>
                                        <li class="page-item <?php echo ($currentPage == $page) ? "active" : "" ?>">
                                            <a href="<?php echo $uri.'-'.$page?>" class="page-link"><?= $page ?></a>
                                        </li>
                                        <?php endfor ?>
                                        <li class="page-item" >
                                            <a <?php echo ($currentPage == $pages) ? "" : "href='".$uri."-".$currentPage + 1 ."'"?> class="page-link"><span class="glyphicon glyphicon-chevron-right"></span></a>
                                        </li>
                                    </ul>                                     
                                </div>
                                <br><br>

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