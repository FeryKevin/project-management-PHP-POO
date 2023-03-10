<?php 

require '../vendor/autoload.php';

use App\Classes\Contact;
use App\Repository\ContactRepository;
use App\Repository\CustomerRepository;
use App\Repository\HostRepository;
use App\Forms\Validator;
use slugifier as s;


$host = $customer = null;

$new = false;

//host ou customer
if (isset($_GET['type']) && $_GET['id'] != 0){
    if (isset($_GET['id']) &&  $_GET['type'] == 'H'){
        $host = HostRepository::getHostById($_GET["id"]);
    }
    elseif (isset($_GET['id']) &&  $_GET['type'] == 'C'){
        $customer = CustomerRepository::getCustomerById($_GET["id"]);
    }
}

//insert
if (isset($_POST['submit'])){
    if (isset($_POST['list'])){
        if  ($_GET['type'] == 'C'){
            $customer = CustomerRepository::getCustomerById($_POST['list']);
        }
        elseif ($_GET['type'] == 'H'){
            $host = HostRepository::getHostById($_POST['list']);
        }
    }
    $contact = new Contact(
        0,
        Validator::verifyInput($_POST['name']),
        Validator::verifyInput($_POST['email']),
        Validator::verifyInput($_POST['phone_number']),
        Validator::verifyInput($_POST['role']),
        $customer,
        $host,
    );
    $errors = Validator::checkContact($contact);
    if (null === $errors){
        ContactRepository::addContact($contact);
        if ($_GET['id'] != 0){
            header("Location: ".$_GET['type']."-".$_GET['id'].'-1');
        }
        else{
            header("Location: ".$_GET['type']."-".$_POST['list'].'-1');
        }
    }
}

if ($_GET['id'] == 0){
    $new = true;
    $list = ($_GET['type'] == 'C') ? CustomerRepository::getCustomer():HostRepository::getHost();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <base href='../'>
        <title>Ajouter un contact</title>
        <base href="../">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="public/js/script.js"></script>
        <link rel="stylesheet" href="public/css/styles.css">
    </head>
    
    <body>
        
        <?php require '../layout/navbar.php' ?>
        
        <section id="insert">

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
                            <h2 class="nouv">
                                <?php
                                if((!$new))
                                    echo isset($host) ? $host->getName() : $customer->getName();
                                else
                                    echo 'Nouveau contact';
                                ?>
                            </h2>
                            <ul class="listContact">
                                <?php 
                                    if(($_GET['type'] == 'C')){
                                        echo'
                                        <a href="Customer/Insert.php" class="infoGenerale2">INFORMATIONS GÉNÉRALES</a>&emsp;
                                        <a href="Contact/C-' .$_GET['id'] .'-new" class="contactLien3">CONTACTS CLIENT</a>';
                                    }
                                    else
                                    {
                                        if(($_GET['type'] == 'H')){
                                            echo'
                                            <a href="Host/Insert.php" class="infoGenerale2">INFORMATIONS GÉNÉRALES</a>&emsp;
                                            <a href="Contact/H-' .$_GET['id'] .'-new" class="contactLien4">CONTACTS HEBERGEUR</a>';
                                        }
                                    }
                                ?>
                            </ul>
                        </div>

                        <!-- debut carré -->
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="add">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <form method="Post">  

                                        <div class="contactAffichage">

                                            <br>
                                            
                                            <!-- nom -->
                                            <div class='group-form'>
                                                <label for='name'>Nom du contact <span style="color: red;">*</span>&emsp;</label>
                                                <input name="name" class="" value="<?php echo $_POST['name'] ?? '' ?>">
                                                <p class="errorContact"><?php echo $errors['nameError'] ?? '' ?></p>
                                            </div>

                                            <br><br>

                                            <!-- email -->
                                            <div class='group-form'>
                                                <label class="lab">Email &emsp;&emsp;&emsp;&emsp;&emsp;</label>
                                                <input name='email'  class="contactEmail" value="<?php echo $_POST['email'] ?? '' ?>">
                                                <p class="errorContact"><?php echo $errors['emailError'] ?? '' ?></p>
                                            </div>

                                            
                                            <div class='form-right'>
                                                
                                                <!-- client / hebergeur -->
                                                <div class='group-form'>

                                                    <?php

                                                    if (isset($list) && ($_GET['type'] == 'C')){
                                                        echo"
                                                        <label class='lab'>Client <span style='color: red;'>*</span>&emsp;&emsp;&emsp;&emsp;&emsp;</label>
                                                        <select name='list' class='selectContact'>";
                                                        foreach ($list as $obj){
                                                            echo '<option value='.$obj->getId().'>'.$obj->getName().'</option>';
                                                        }
                                                        echo "</select>";
                                                    }

                                                    if (isset($list) && ($_GET['type'] == 'H')){
                                                        echo"
                                                        <label class='lab'>Hébergeur <span style='color: red;'>*</span>&emsp;&emsp;&emsp;</label>
                                                        <select name='list' class='selectContact'>";
                                                        foreach ($list as $obj){
                                                            echo '<option value='.$obj->getId().'>'.$obj->getName().'</option>';
                                                        }
                                                        echo "</select>";
                                                    }

                                                    ?>

                                                </div>

                                                <!-- role -->
                                                <div class='group-form'>
                                                    <label class="lab">Rôle &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</label>
                                                    <input name="role" class="roleContact"><?php echo $_POST['role'] ?? '' ?>
                                                </div>

                                                <!-- telephone -->
                                                <div class='group-form'>
                                                    <label class="lab">Téléphone &emsp;&emsp;&emsp;</label>
                                                    <input name='phone_number' class="telContact" value="<?php echo $_POST['phone_number'] ?? '' ?>"> 
                                                </div>

                                            </div>

                                        </div>

                                        <!-- bouton -->
                                        <br><br>
                                        <button type="submit" name="submit" class="btnOrange" style='margin-top: 10px'><span class="glyphicon glyphicon-ok"></span> AJOUTER</button>&emsp;

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