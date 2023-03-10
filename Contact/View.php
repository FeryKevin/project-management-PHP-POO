<?php 

require '../vendor/autoload.php';

use App\Repository\ContactRepository;

$contacts = ContactRepository::getContact();

?>

<!DOCTYPE html>
<html>
    <head>
        <base href='../'>
        <title>Liste des contacts</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="public/js/script.js"></script>
        <link rel="stylesheet" href="public/css/styles.css">
    </head>
    
    <body>
        
        <?php require '../layout/navbar.php' ?>
        
        <section id="viewClient">

            <div class="container-fluid">
                <div class="row">

                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <?php require '../layout/menu.php' ?>
                    </div>

                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <h3 class="nouv">&emsp;Contacts</h3>

                         <!-- debut carré -->
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            
                            <div class="fondTableau">

                            <div class="table-responsive">

                                <table class="table table-bordered" id="tabClient">
                                    <tr class="trTableau">
                                        <th>NOM</th>
                                        <th>CONTACT</th>
                                        <th>CODE</th>
                                        <th>ROLE</th>
                                        <th>CLIENT</th>
                                        <th>HÉBERGEUR</th>
                                        <th>MODIFIER</th>
                                    </tr>
                                    <?php
                                        foreach ($contacts as $contact){
                                            echo "<tr class='tr2Tableau'>
                                                <td>". $contact->getName() ."</td>
                                                <td>". $contact->getEmail() ."</td>
                                                <td>". $contact->getPhone() ."</td>
                                                <td>". $contact->getRole() ."</td>
                                                <td>";
                                                echo (null == $contact->getHost()) ? 'aucun': $contact->getHost()->getName();
                                                echo "</td>
                                                <td>";
                                                echo (null == $contact->getCustomer()) ? 'aucun': $contact->getCustomer()->getName();
                                                echo "</td>
                                                <td>
                                                    <a class='aTabl' href='Client/". $contact->getId() ."'>Modifier</a>
                                                </td>
                                            </tr>";
                                        }   
                                    ?>
                                </table>

                            </div>

                                <div class="btnAdd2">
                                    <a href='Contact/Insert.php' class="btnInsertLien">+ Ajouter</a>&emsp;
                                </div>
                                <br>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </section>

        <?php require '../layout/footer.php' ?>
        
    </body>
</html>