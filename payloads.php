<?php

include 'core/class/include.php';

// Redirige l'utilisateur si il n'est pas authentifier
if (!Account::isAuthentified())
{
    header('Location: ./login');
}

?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>kPanel | Payloads</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="datacss/dataTables.bootstrap.min.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="datacss/font-awesome.min.css?v=<?php echo time(); ?>">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <style>
    .slider {
      border: none;
      position: relative;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      width: 125px;
    }

    .slider-checkbox {
      display: none;
    }

    .slider-label {
      border: 2px solid #666;
      border-radius: 20px;
      cursor: pointer;
      display: block;
      overflow: hidden;
    }

    .slider-inner {
      display: block;
      margin-left: -100%;
      transition: margin 0.3s ease-in 0s;
      width: 200%;
    }

    .slider-inner:before,
    .slider-inner:after {
      box-sizing: border-box;
      display: block;
      float: left;
      font-family: sans-serif;
      font-size: 14px;
      font-weight: bold;
      height: 30px;
      line-height: 30px;
      padding: 0;
      width: 50%;
    }

    .slider-inner:before {
      background-color: #66bb6a;
      color: #fff;
      content: "SERVEUR";
      padding-left: 0.75em;
    }

    .slider-inner:after {
      background-color: #eee;
      color: #666;
      content: "CLIENT";
      padding-right: 0.75em;
      text-align: right;
    }

    .slider-circle {
      background-color: #66bb6a;
      border: 2px solid #666;
      border-radius: 20px;
      bottom: 0;
      display: block;
      margin: 5px;
      position: absolute;
      right: 91px;
      top: 0;
      transition: all 0.3s ease-in 0s;
      width: 20px;
    }

    .slider-checkbox:checked + .slider-label .slider-inner {
      margin-left: 0;
    }

    .slider-checkbox:checked + .slider-label .slider-circle {
      background-color: #eee;
      right: 0;
    }
    #payload_list_previous {
      margin-left: 25px;
    }
     #payload_list_previous, .paginate_button {
       margin-right: 5px;
     }

    </style>
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="https://kpanel.cz/home/assets/img/logo/kpanel.png" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item profile">
            <div class="profile-desc">
              <div class="profile-pic">
                <div class="count-indicator">
                  <img class="img-xs rounded-circle " src="<?php echo Account::GetPP(); ?>" alt="">
                  <span class="count bg-success"></span>
                </div>
                <div class="profile-name">
                  <h5 class="mb-0 font-weight-normal"><?php echo Account::GetUsername(); ?></h5>
                  <?php
                  $hisrole = Account::GetRole();
                  $rolecolor = Account::GetRoleColor();
                  $rolecolorlink = Account::GetRoleColorFire();
                  if ($hisrole == "Administrateur") {
                    $role = "<span style='color: #000000; font-weight: bold; text-shadow: 0 0 5px ".$rolecolor.", 0 0 5px ".$rolecolor."; background: url(".$rolecolorlink.") repeat scroll 0% 0% transparent;}'>Administrateur</span>";
                  }
                  else {
                    $role = "<span>Utilisateur</span>";
                  }
                  ?>
                  <?php echo $role; ?>
                </div>
              </div>
              <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                <a href="./profile" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-settings text-primary"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Profil</p>
                  </div>
                </a>
              </div>
            </div>
          </li>
          <li class="nav-item nav-category">
            <span class="nav-link">Gestion</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="dashboard">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="servers">
              <span class="menu-icon">
                <i class="mdi mdi-server"></i>
              </span>
              <span class="menu-title">Serveurs</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="history">
              <span class="menu-icon">
                <i class="mdi mdi-wechat"></i>
              </span>
              <span class="menu-title">Historique</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="payloads">
              <span class="menu-icon">
                <i class="mdi mdi-code-tags"></i>
              </span>
              <span class="menu-title">Payloads</span>
            </a>
          </li>
          <li class="nav-item nav-category">
            <span class="nav-link">Outils</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="chat">
              <span class="menu-icon">
                <i class="mdi mdi-wechat"></i>
              </span>
              <span class="menu-title">Chat</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="obfu">
              <span class="menu-icon">
                <i class="mdi mdi-barcode"></i>
              </span>
              <span class="menu-title">Obfuscateurs</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="bdfinder">
              <span class="menu-icon">
                <i class="mdi mdi-code-array"></i>
              </span>
              <span class="menu-title">Backdoor Finder</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="smartlua">
              <span class="menu-icon">
                <i class="mdi mdi-wheelchair-accessibility"></i>
              </span>
              <span class="menu-title">Smart lua<div class="badge badge-info badge-xs">Beta</div></span>
            </a>
          </li>
          <li class="nav-item nav-category">
            <span class="nav-link">Autres</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="rules">
              <span class="menu-icon">
                <i class="mdi mdi-clipboard-text"></i>
              </span>
              <span class="menu-title">Règles</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="wallofshame">
              <span class="menu-icon">
                <i class="mdi mdi-gavel"></i>
              </span>
              <span class="menu-title" style="color: #000000; font-weight: bold; text-shadow: 0 0 5px #800080, 0 0 5px #800080; background: url(/imgs/fire_purple.gif) repeat scroll -5% 0% transparent;">Wall Of Shame</span>
            </a>
          </li>
          <?php if (Account::IsAdmin()) { ?>
            <li class="nav-item nav-category">
              <span class="nav-link">Administration</span>
            </li>
            <li class="nav-item menu-items">
              <a class="nav-link" href="users">
                <span class="menu-icon">
                  <i class="mdi mdi-account-circle"></i>
                </span>
                <span class="menu-title">Utilisateurs</span>
              </a>
            </li>
            <li class="nav-item menu-items">
              <a class="nav-link" href="allservers">
                <span class="menu-icon">
                  <i class="mdi mdi-server"></i>
                </span>
                <span class="menu-title">Tous les serveurs</span>
              </a>
            </li>
            <li class="nav-item menu-items">
              <a class="nav-link" href="logs">
                <span class="menu-icon">
                  <i class="mdi mdi-settings"></i>
                </span>
                <span class="menu-title">Logs</span>
              </a>
            </li>
          <?php } ?>
        </ul>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini" href="index.html"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                  <div class="navbar-profile">
                    <img class="img-xs rounded-circle" src="<?php echo Account::GetPP();?>" alt="">
                    <p class="mb-0 d-none d-sm-block navbar-profile-name"><?php echo Account::GetUsername();?></p>
                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                  <h6 class="p-3 mb-0">Profil</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href="./profile">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-settings text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Profil</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href="./logout">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-logout text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Déconnection</p>
                    </div>
                  </a>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <!-- Modal création d'un payload -->
            <div class="modal fade" id="createpayload-modal" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Créer un Payload</h4>
                  </div>
                  <div class="modal-body">
                      <div class="form-group">
                        <label>Nom du payload</label>
                        <input type="text" class="form-control" id="payload-name" placeholder="Nom du payload">
                      </div>
                      <div class="form-group">
                        <label>Payload</label>
                        <textarea class="form-control" rows="5" id="payload-text" placeholder="Vous souhaitez ajouter des arguments ? Changez ladite variable par {ARG}."></textarea>
                      </div>
                      <br>
                      <label>Côté</label>
                      <div class="slider">
                        <input type="checkbox" name="slider" class="slider-checkbox" id="clientorserver" checked>
                        <label class="slider-label" for="clientorserver">
                          <span class="slider-inner"></span>
                          <span class="slider-circle"></span>
                        </label>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                    <button type="button" onclick="createPayload()" class="btn btn-primary">Créer le Payload</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal apercu d'un paympad -->
            <div class="modal fade" id="viewpayload-modal" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edition du payload</h4>
                  </div>
                  <div class="modal-body">
                      <div class="form-group">
                        <label>Nom du payload</label>
                        <input type="text" class="form-control" id="edit-payload-name" placeholder="Nom du payload">
                      </div>
                      <div class="form-group">
                        <label>Payload</label>
                        <textarea class="form-control" rows="5" id="edit-payload-text" placeholder="Vous souhaitez ajouter des arguments ? Changez ladite variable par {ARG}."></textarea>
                      </div>
                      <div class="slider">
                        <input type="checkbox" name="slider" class="slider-checkbox" id="clientorserveredit" checked>
                        <label class="slider-label" for="clientorserveredit">
                          <span class="slider-inner"></span>
                          <span class="slider-circle"></span>
                        </label>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" onclick="editPayload()" class="btn btn-warning" data-dismiss="modal">Edité</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12" style="margin-bottom: 10px;">
                  <button data-toggle="modal" data-target="#createpayload-modal" type="button" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Ajouter un payload</button>
              </div>
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Payloads</h4>
                    <div class="table-responsive">
                      <table id="payload_list" cellspacing="0" width="100%" class="table">
                          <br>
                          <thead>
                              <tr>
                                  <th>Nom du Payload</th>
                                  <th style="min-width: 140px!important">Action</th>
                              </tr>
                          </thead>

                          <tbody>
                          </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2020 <a href="#" target="_blank">kPanel</a>. All rights reserved.</span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/Chart.min.js"></script>
    <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <script src="datajs/jquery.dataTables.min.js"></script>
    <script src="datajs/dataTables.bootstrap.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/dashboard.js"></script>
    <script>
    var payload_table = $("#payload_list").DataTable({
        responsive: true,
        bStateSave: true,
        bFilter: false,
        lengthChange: false,
        "language": {
            "lengthMenu": "Afficher _MENU_ payloads",
            "zeroRecords": "Aucun payload trouvée",
            "info": "Affiché _PAGE_ pages sur _PAGES_",
            "infoEmpty": "Aucun payload n'a été trouvé",
            "infoFiltered": "(filtré pour _MAX_ payloads)"
        },
        ajax: "core/ajax/get-payload.php"
    });

    function deletePayload(id)
    {
        $.ajax({
          url: "core/ajax/del-payload.php?id=" + id
        });
    }

    function createPayload()
    {
        var payload_name = $("#payload-name").val();
        var payload_comment = $("#payload-comment").val();
        var payload_content = $("#payload-text").val().replace("\n", "<NEWLINE>");;
        if ($('#clientorserver').is(":checked"))
        {
          var payload_side = "server";
        } else {
          var payload_side = "client";
        }

        $.ajax({
          method: "POST",
          url: "core/ajax/add-payload.php",
          data: { name: payload_name, comment: payload_comment, content: payload_content, side: payload_side }
        });

        $("#createpayload-modal").modal("hide");
    }

    $('#createpayload-modal').on('hidden.bs.modal', function () {
        $("#payload-name").val("");
        $("#payload-text").val("");
        $("#payload-comment").val("");
    });

    function viewPayload(id)
    {
        action_payload_id = id;
        $.ajax({
          url: "core/ajax/get-payload-content.php?id=" + id
        }).done(function(data){
            console.log(data);
            $("#edit-payload-name").val(data.payload_name);
            $("#edit-payload-comment").val(data.payload_comment);
            $("#edit-payload-text").val(data.payload_content);
            $("#viewpayload-modal").modal("show");
        });
    }

    function editPayload()
    {
        var name = $("#edit-payload-name").val();
        var comment = $("#edit-payload-comment").val();
        var text = $("#edit-payload-text").val().replace("\n", "<NEWLINE>");
        if ($('#clientorserveredit').is(":checked"))
        {
          var side = "server";
        } else {
          var side = "client";
        }

        $.ajax({
          method: "POST",
          url: "core/ajax/edit-payload.php?id=" + action_payload_id,
          data: { name: name, comment: comment, content: text, side: side }
        });

        $("#viewpayload-modal").modal("hide");
    }

    $('#viewpayload-modal').on('hidden.bs.modal', function () {
        $("#edit-payload-name").val("");
        $("#edit-payload-comment").val("");
        $("#edit-payload-text").val("");
    });

    setInterval(function(){
        payload_table.ajax.reload(function(){
                  $(".paginate_button > a").on("focus", function(){
                      $(this).blur();
                  });
              }, false);

    }, 0.5 * 1000);
    </script>
    <!-- End custom js for this page -->
  </body>
</html>
