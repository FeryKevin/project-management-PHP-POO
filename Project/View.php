<?php 

require '../vendor/autoload.php';

use App\Repository\ProjectRepository;

//filtre
$filtre = array();
if (isset($_GET['name']) && $_GET['name'] != ''){
    $filtre[] = ProjectRepository::getByName($_GET['name']);
}
if (isset($_GET['customer']) && $_GET['customer'] != ''){
    $filtre[] = ProjectRepository::getProjectByCustomer($_GET['customer']);
}
if (isset($_GET['host']) && $_GET['host'] != ''){
    $filtre[] = ProjectRepository::getProjectByHost($_GET['host']);
}
else{
    $projects = ProjectRepository::getProject();
}

//affichage filtre
if (!empty($filtre)){
    if (count($filtre) == 1){
        $projects = $filtre[0];
    }
    elseif (count($filtre) ==2){
        $projects = array_intersect($filtre[0], $filtre[1]);
    }
    elseif (count($filtre) ==3){
        $projects = array_intersect($filtre[0], $filtre[1], $filtre[2]);
    }
}

//pagination
$nbPerPage = isset($_GET['nbPage']) ? $_GET['nbPage']: 15;
$currentPage = isset($_GET['page']) ? $_GET['page']: 1;

$pages = ceil(count($projects)/$nbPerPage);
$allProject = array();

for ($i=($currentPage-1)*$nbPerPage; $i<$currentPage*$nbPerPage; $i++){
    if (isset($projects[$i])) $allProject[] = $projects[$i];
}

$projects = $allProject;

if(isset($_GET['page'])){
    $uri = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "&page="));
}
else{
    $uri = $_SERVER['REQUEST_URI'];
}

if (empty($_GET)){
    header('Location: all?name=&customer=&host=&nbPage=15');
}

?>

<!DOCTYPE html>
<html>
    <head>
        <base href='../'>
        <title>Liste des projets</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="public/js/script.js"></script>
        <link rel="stylesheet" href="public/css/styles.css">
    </head>
    
    <body>
        
        <?php require '../layout/navbar.php' ?>
        
        <section id="View">

            <div class="container-fluid">
                <div class="row">

                    <!-- menu -->
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <?php require '../layout/menu.php' ?>
                    </div>

                    <!-- section -->
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <h3 class="nouv">&emsp;Projets</h3>

                         <!-- debut carré -->
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            
                            <div class="fondTableau">

                                <!-- début tableau -->
                                <div class="table-responsive">

                                    <!-- form -->
                                    <form>

                                        <table class="table table-bordered" id="tabClient">

                                            <!-- titre -->
                                            <tr class="trTableau">
                                                <th>NOM</th>                                                
                                                <th>CLIENT</th>
                                                <th>HEBERGEUR</th>
                                                <th>MODIFIER</th>
                                            </tr>

                                            <!-- filtre -->
                                            
                                                <tr>
                                                    <td><input class="inputSearch" name='name' value='<?php echo (isset($_GET['name'])) ? $_GET['name'] : "" ?>'></td>
                                                    <td><input class="inputSearch" name='customer' value='<?php echo (isset($_GET['customer'])) ? $_GET['customer'] : "" ?>'></td>
                                                    <td><input class="inputSearch" name='host' value='<?php echo (isset($_GET['host'])) ? $_GET['host'] : "" ?>'></td>
                                                    <td>
                                                        <button type='submit' style='display:none'>Chercher</button>
                                                        <a class='reset' href='Project/all'>X</button>
                                                    </td>
                                                </tr>
                                            
                                            <!-- affichage -->
                                            <?php
                                                if (empty($projects)){
                                                    echo '<tr><td colspan="4" style="text-align:center">Aucun projet ne corespond à votre recherche</td></tr>';
                                                }
                                                else{
                                                    foreach ($projects as $projects){
                                                        echo "<tr class='tr2Tableau'>
                                                            <td>". $projects->getName() ."</td>
                                                            <td>". $projects->getCustomer()->getName() ."</td>
                                                            <td>". $projects->getHost()->getName() ."</td>
                                                            <td>
                                                                <a class='aTabl' href='Project/". $projects->getId() ."'>Modifier</a>
                                                            </td>
                                                        </tr>";
                                                    }  
                                                } 
                                            ?>

                                        </table>

                                        <!-- pagination choix affichage -->
                                        <div class="col-lg-3 col-md-3 sm-3"> 
                                            <div class="paginationCSS">                                          
                                                <label class="labelPagination">Résultats/pages&emsp;</label>
                                                <select name='nbPage' onchange="this.form.submit()" class="selectPagination">
                                                    <option value="5" <?php echo (isset($_GET['nbPage']) && $_GET['nbPage'] == 5) ? 'selected': '' ?>>5</option>
                                                    <option value="10" <?php echo (isset($_GET['nbPage']) && $_GET['nbPage'] == 10) ? 'selected': '' ?>>10</option>
                                                    <option value="15" <?php echo (isset($_GET['nbPage']) && $_GET['nbPage'] == 15) ? 'selected': '' ?>>15</option>
                                                    <option value="20" <?php echo (isset($_GET['nbPage']) && $_GET['nbPage'] == 20) ? 'selected': '' ?>>20</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- pagination boutons -->
                                        <div class="col-lg-3 col-md-3 col-sm-3">                                                                
                                            <ul class="pagination">
                                                <li class="page-item">
                                                    <a <?php echo ($currentPage == 1) ? "" : "href='".$uri."&page=".$currentPage - 1 ."'"?> class="page-link"><span class="glyphicon glyphicon-chevron-left"></span></a>
                                                </li>
                                                <?php for($page = 1; $page <= $pages; $page++): ?>
                                                    <li class="page-item <?php echo ($currentPage == $page) ? "active" : "" ?>">
                                                        <a href="<?php echo $uri.'&page='.$page?>" class="page-link"><?= $page ?></a>
                                                    </li>
                                                <?php endfor ?>
                                                    <li class="page-item" >
                                                    <a <?php echo ($currentPage == $pages) ? "" : "href='".$uri."&page=".$currentPage + 1 ."'"?> class="page-link"><span class="glyphicon glyphicon-chevron-right"></span></a>
                                                </li>
                                            </ul>                                            
                                        </div>
                                        
                                        <!-- liens -->
                                        <div class="col-lg-3 col-lg-offset-1 col-md-3 col-sm-3">
                                            <div class="tableauBouton">                                          
                                                <a href='Project/view.php' class="btnBlanc"><span class="glyphicon glyphicon-file"></span>&emsp;EXPORTER</a>&emsp;
                                            </div>                                           
                                        </div>                                                
                                    
                                        <!-- liens -->
                                        <div class="col-lg-2 col-md-3 col-sm-3">
                                            <div class="tableauBouton">
                                                <a href='Project/Insert.php' class="btnOrange">+ AJOUTER</a>
                                            </div>                                           
                                        </div>

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