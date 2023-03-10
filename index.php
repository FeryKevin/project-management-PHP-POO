<!DOCTYPE html>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="public/js/script.js"></script>
        <link rel="stylesheet" href="public/css/styles.css">
    </head>
    
    <body>
        
        <?php require 'layout/navbar.php' ?>
        
        <section id="sec1">

            <div class="container-fluid">
                <div class="row">

                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <?php require 'layout/menu.php' ?>
                    </div>
                
                </div>
            </div>
        </section>

        <?php require 'layout/footer.php' ?>

    </body>
    
</html>