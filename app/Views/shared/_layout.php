<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Title -->
  <title>Circl</title>

  <!-- Styles -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&amp;display=swap" rel="stylesheet">
  <link href="<?= asset() ?>/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="<?= asset() ?>/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
  <link href="<?= asset() ?>/plugins/DataTables/datatables.min.css" rel="stylesheet">
  <!-- Theme Styles -->
  <link href="<?= asset() ?>/css/main.min.css" rel="stylesheet">
  <link href="<?= asset() ?>/css/custom.css" rel="stylesheet">
  <script src="<?= asset() ?>/plugins/jquery/jquery-3.4.1.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <style>
    .page-header {
      top: 0 !important;
    }
    .page-sidebar
    {
      top:85px !important;
    }
    .page-content{
      margin-top: 38px;
    }
  </style>
</head>

<body>

  <div class="loader">
    <div class="spinner-grow text-primary" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>

  <div class="page-container">
    <div class="page-header">
      <nav class="navbar navbar-expand-lg d-flex justify-content-between">
        <div class="" id="navbarNav">
          <ul class="navbar-nav" id="leftNav">
            <li class="nav-item">
              <a class="nav-link" id="sidebar-toggle" href="#"><i data-feather="arrow-left"></i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Settings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Help</a>
            </li>
          </ul>
        </div>
        <div class="logo">
          <a class="navbar-brand" href="index.html"></a>
        </div>
        <div class="" id="headerNav">
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a class="nav-link search-dropdown" href="#" id="searchDropDown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="search"></i></a>
              <div class="dropdown-menu dropdown-menu-end dropdown-lg search-drop-menu" aria-labelledby="searchDropDown">
                <form>
                  <input class="form-control" type="text" placeholder="Type something.." aria-label="Search">
                </form>
                <h6 class="dropdown-header">Recent Searches</h6>
                <a class="dropdown-item" href="#">charts</a>
                <a class="dropdown-item" href="#">new orders</a>
                <a class="dropdown-item" href="#">file manager</a>
                <a class="dropdown-item" href="#">new users</a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link notifications-dropdown" href="#" id="notificationsDropDown" role="button" data-bs-toggle="dropdown" aria-expanded="false">3</a>
              <div class="dropdown-menu dropdown-menu-end notif-drop-menu" aria-labelledby="notificationsDropDown">
                <h6 class="dropdown-header">Notifications</h6>
                <a href="#">
                  <div class="header-notif">
                    <div class="notif-image">
                      <span class="notification-badge bg-info text-white">
                        <i class="fas fa-bullhorn"></i>
                      </span>
                    </div>
                    <div class="notif-text">
                      <p class="bold-notif-text">faucibus dolor in commodo lectus mattis</p>
                      <small>19:00</small>
                    </div>
                  </div>
                </a>
                <a href="#">
                  <div class="header-notif">
                    <div class="notif-image">
                      <span class="notification-badge bg-primary text-white">
                        <i class="fas fa-bolt"></i>
                      </span>
                    </div>
                    <div class="notif-text">
                      <p class="bold-notif-text">faucibus dolor in commodo lectus mattis</p>
                      <small>18:00</small>
                    </div>
                  </div>
                </a>
                <a href="#">
                  <div class="header-notif">
                    <div class="notif-image">
                      <span class="notification-badge bg-success text-white">
                        <i class="fas fa-at"></i>
                      </span>
                    </div>
                    <div class="notif-text">
                      <p>faucibus dolor in commodo lectus mattis</p>
                      <small>yesterday</small>
                    </div>
                  </div>
                </a>
                <a href="#">
                  <div class="header-notif">
                    <div class="notif-image">
                      <span class="notification-badge">
                        <img src="<?= asset() ?>/images/avatars/profile-image.png" alt="">
                      </span>
                    </div>
                    <div class="notif-text">
                      <p>faucibus dolor in commodo lectus mattis</p>
                      <small>yesterday</small>
                    </div>
                  </div>
                </a>
                <a href="#">
                  <div class="header-notif">
                    <div class="notif-image">
                      <span class="notification-badge">
                        <img src="<?= asset() ?>/images/avatars/profile-image-3.jpg" alt="">
                      </span>
                    </div>
                    <div class="notif-text">
                      <p>faucibus dolor in commodo lectus mattis</p>
                      <small>yesterday</small>
                    </div>
                  </div>
                </a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link profile-dropdown" href="#" id="profileDropDown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="<?= asset() ?>/images/avatars/profile-image-1.png" alt=""></a>
              <div class="dropdown-menu dropdown-menu-end profile-drop-menu" aria-labelledby="profileDropDown">
                <a class="dropdown-item" href="#"><i data-feather="user"></i>Profile</a>
                <a class="dropdown-item" href="#"><i data-feather="inbox"></i>Messages</a>
                <a class="dropdown-item" href="#"><i data-feather="edit"></i>Activities<span class="badge rounded-pill bg-success">12</span></a>
                <a class="dropdown-item" href="#"><i data-feather="check-circle"></i>Tasks</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#"><i data-feather="settings"></i>Settings</a>
                <a class="dropdown-item" href="#"><i data-feather="unlock"></i>Lock</a>
                <a class="dropdown-item" href="#"><i data-feather="log-out"></i>Logout</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>
    </div>
    <div class="page-sidebar">
      <ul class="list-unstyled accordion-menu">
        <li class="sidebar-title">
          Main
        </li>
        <li class="active-page">
          <a href="<?= route('/home/index') ?>"><i data-feather="home"></i>Dashboard</a>
        </li>
        <li class="sidebar-title">
          Enrich
        </li>
        <li>
          <a href="<?= route('/templates/index') ?>"><i data-feather="inbox"></i>Templates</a>
        </li>

        <li>
          <a href="<?= route('/lists/index') ?>"><i data-feather="inbox"></i>Data Lists</a>
        </li>
    
      
      </ul>
    </div>
    <div class="page-content">
      <div class="main-wrapper">
        <?= $this->renderSection('content') ?>
      </div>

    </div>
  </div>

  <!-- Javascripts -->

  <script src="https://unpkg.com/@popperjs/core@2"></script>
  <script src="<?= asset() ?>/plugins/bootstrap/js/bootstrap.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="<?= asset() ?>/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
  <script src="<?= asset() ?>/js/main.min.js"></script>
  <script src="<?= asset() ?>/plugins/DataTables/datatables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $(document).ready(() => {
      $('.select2').select2({
        placeholder: "Please Select an Option",
        width: "100%"
      });
    });

    function showModal($id) {
      $($id).modal('show');
      return false;
    }

    function hideModal($id) {
      $($id).modal('hide');
      return false;
    }

    function showMessage($status, $message) {
      Swal.fire({
        icon: $status,
        title: $status,
        text: $message
      })
    }

    function showLoader() {
      $('.loader').css('visibility', 'visible');
      $('.loader').css('opacity', '0.7');
    }

    function hideLoader() {
      $('.loader').css('visibility', 'hidden');
      $('.loader').css('opacity', '0');
    }
  </script>

  <?= $this->renderSection('scripts') ?>
</body>

</html>