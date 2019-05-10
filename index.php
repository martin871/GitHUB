<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

date_default_timezone_set("America/Cancun");
include('class/peticiones.class.php');
include('class/pdo.class.php');
$html = $htmlPaginacion = "";

if(!empty($_GET['q'])){
     $page = empty($_GET['page'])?'':$_GET['page'];
     $peticion = new Peticiones();
     $peticion->search = $_GET['q'];
     $peticion->page = !empty($_GET['page'])?$_GET['page']:1;
     $html = $peticion->getHtml();
     $htmlPaginacion = $peticion->paginacion();

     $cn = new connectPDO();
     $cn->updateLogs($_GET['q']);
}
?>
<html lang="es">
     <head>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
          <meta name="author" content="Martin Ucan May">
          <title>Repositorio GitHub</title>

          <!-- Bootstrap core CSS -->
          <link href="css/bootstrap.min.css" rel="stylesheet">
          <!-- Estilos generales -->          
          <link rel="stylesheet" href="css/style.css">
     </head>

     <body class="d-flex flex-column h-100">
          <!-- Fixed navbar -->
          <header>
               <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                    <a class="navbar-brand" href="#">GitHub</a>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                         <ul class="navbar-nav mr-auto"></ul>
                         <form method="GET" action="index.php" class="form-inline mt-2 mt-md-0">
                              <input class="form-control mr-sm-2" type="text" name="q" value="<?=@$_GET['q'];?>" id="search" placeholder="Search" aria-label="Search">
                              <button class="btn btn-outline-success my-2 my-sm-0" id="btnSearch" type="submit">Search</button>
                         </form>
                    </div>
               </nav>
          </header>
          
          <!-- Begin page content -->
          <br /></br/> <br /></br/>
          <div class="container">
               <div class="row search-repos">
                  <?=$html;?>
               </div>
               <nav class="navigation">
                  <?=$htmlPaginacion;?>
               </nav>          
          </div>
          <!-- Begin Footer-->
          <footer class="footer mt-auto py-3">
               <div class="container">
                    <span class="text-muted">2019 GitHub.</span>
               </div>
          </footer>

          <!-- Modal -->
          <div class="modal fade bd-example-modal-xl" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
              <div class="modal-content col-md-12">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalScrollableTitle">Comentarios</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                  
                </div>
              </div>
            </div>
          </div>

          <!--Moment-->
          <script src="js/moment.min.js" type="text/javascript"></script>          
          <script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
          <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>          
          <script src="js/script.js" type="text/javascript"></script>
     </body>
</html>