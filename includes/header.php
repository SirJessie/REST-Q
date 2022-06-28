<?php 
    session_start();
    include_once "php/config.php";

    if(isset($_SESSION['RESTQ_USER-ID'])){
        $user_id = $_SESSION['RESTQ_USER-ID'];
        $sql_query = "SELECT * FROM user_info WHERE U_ID = '$user_id'";
        $sql_result = mysqli_query($conn, $sql_query);

        $fetch_data = mysqli_fetch_array($sql_result);

        $fname = $fetch_data['Fname'];

        $name = substr($fname, 0, 1) . ". " . $fetch_data['Sname'];

        $profile = $fetch_data['Image'];

        $roles = $fetch_data['Roles'];

        $from_brgy = $fetch_data['FromBrgy'];

    }else{
        header("Location: no_session.php");
    }

    date_default_timezone_set('Asia/Manila');
    $dateNow = date("Y-m-d");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- TITLE -->
    <title>Home Quarantine Monitoring</title>
    <link rel="shortcut icon" type="image" href="resources/images/System/RestQ_AppIcon_TransBG.png">

    <!-- FONTAWESOME CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- BOOTSTRAP CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <!-- DATATABLES -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">

    <!-- FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    

    <!-- CSS LINK -->
    <link rel="stylesheet" href="css/theme.css">

    <link rel="stylesheet" href="css/navigation.css">

    <link rel="stylesheet" href="css/notification.css">

    <link rel="stylesheet" href="css/popup-container.css">

    <link rel="stylesheet" href="css/dashboard.css">

    <link rel="stylesheet" href="css/user_logs.css">
    
    <link rel="stylesheet" href="css/roles.css">

    <link rel="stylesheet" href="css/user-profile.css">

    <link rel="stylesheet" href="css/sweetalert.css">

    <link rel="stylesheet" href="css/responsive.css">

    <!-- SWEET ALERT CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
    <!-- BOOTSTRAP JS CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- GOOGLE MAPS API -->
    <script async
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBg77qSrZzjZ7jB5vcSkFwB06aAp6jKnbg&callback=initMap">
    </script>
</head>
<body>
    <div class="container-fluid p-0 m-0 w-100">
        <div class="d-flex">
            <!-- SIDE NAVIGATION -->
            <input type="checkbox" id="btn-menu" hidden>
            <aside class="m-0 p-0" id="sidenav">
                <div class="row">
                    <figure class="brand-nav-logo">
                        <img src="resources/images/System/flex_logo_white.png" alt="LOGO"/>
                    </figure>
                    <nav class="col-12 navbar navbar-expand">
                        <ul class="navbar-nav d-flex flex-column w-100 ps-2">
                            <li class="nav-item mb-3">
                                <a class="nav-link" href="redirect.php?page=dashboard">
                                    <i class="fas fa-chart-line"></i>
                                    <span class="mx-2">DASHBOARD</span> 
                                </a>                            
                            </li>
                            <?php
                                if($roles == "Global Administrator" || $roles == "User Administrator"):
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#collapseUser">
                                    <i class="fas fa-user"></i>
                                    <div class="d-flex justify-content-between w-100">
                                        <span class="mx-2">USER MANAGEMENT</span>
                                        <i class="fas fa-caret-down"></i>
                                    </div>
                                </a>
                                <ul class="collapse navbar-nav flex-column" id="collapseUser">
                                    <li class="nav-item">
                                        <a class="nav-link" href="redirect.php?page=active_user">
                                            <span class="mx-2">Active Users</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="redirect.php?page=deleted_user">
                                            <span class="mx-2">Deleted Users</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#collapsePatient">
                                    <i class="fas fa-users"></i>
                                    <div class="d-flex justify-content-between w-100">
                                        <span class="mx-2">PATIENT MANAGEMENT</span>
                                        <i class="fas fa-caret-down"></i>
                                    </div>
                                </a>  
                                <ul class="collapse navbar-nav flex-column" id="collapsePatient">
                                    <li class="nav-item">
                                        <a class="nav-link" href="redirect.php?page=home_quarantine_patients">
                                            <span class="mx-2">Home Quarantined Patients</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="redirect.php?page=quarantine_completer_patients">
                                            <span class="mx-2">Quarantine Completer Patients</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="redirect.php?page=roles" class="nav-link">
                                    <i class="fas fa-network-wired"></i>
                                    <div class="d-flex justify-content-between w-100">
                                        <span class="mx-3">ROLES</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="redirect.php?page=support" class="nav-link">
                                    <i class="fas fa-headset"></i>
                                    <div class="d-flex justify-content-between w-100">
                                        <span class="mx-3">SUPPORT</span>
                                    </div>
                                </a>
                            </li>
                            <?php
                                if($roles == "Global Administrator" || $roles == "User Administrator"):
                            ?>
                            <li class="nav-item">
                                <a href="redirect.php?page=user_logs" class="nav-link">
                                    <i class="fas fa-cogs"></i>
                                    <span class="mx-3">LOGS</span>
                                    <span class="badge bg-danger" id="countLogs"></span>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </aside>
            
            <div class="container-fluid m-0 p-0" id="main-content">  
                <!-- HEADER -->
                <header class="container-fluid p-2 m-0" id="header-container">
                    <div class="d-flex">
                        <div class="burger-menu p-3" id="hamburger">
                            <label for="btn-menu" class="menu-btn">
                                <div class="menu-burger"></div>
                            </label>
                        </div>
                        <figure class="brand-header-logo m-auto">
                            <img src="resources/images/System/flex_logo_white.png" alt="LOGO"/>
                        </figure>
                        <!-- <audio src="resources/sounds/NotificationSound.mp3" id="Notify" controls style="display : none"></audio> -->
                        <figure class="w-100 my-auto d-flex">
                            <!-- <div class="my-auto px-3">
                                <input type="search" id="global_search" class="form-control" placeholder="Search...">
                            </div> -->
                            <div class="dropdown notifs w-100 d-flex justify-content-end">
                                <div>
                                    <a href="#" class="notification" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="btnNotifs">
                                        <span><i class="fas fa-bell"></i></span>
                                        <span class="badge" id="countBadge"><i class="fas fa-exclamation-circle"></i></span>
                                    </a>
                                    <ul class="dropdown-menu notification-scroll-wrapper p-0 pt-3" id="dropdownNotifs">
                                        <!-- NOTIFICATION HERE... -->
                                    </ul>
                                </div>
                                <a href="#" class="img-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="<?= 'resources/images/UserAvatars/' . $profile ?>" alt="avatar">
                                </a>
                                <div class="dropdown-menu m-0 p-0 dropdown-user">
                                    <div class="unameBox">
                                        <a href="redirect.php?page=user_profile">
                                            <img src="<?= 'resources/images/UserAvatars/' . $profile ?>" alt="avatar">
                                        </a>
                                            <span class="m-auto"><a href="redirect.php?page=user_profile"><?= $name ?></a></span>
                                       
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" onclick="LogoutBtn()" class="btn m-1 logout-btn">
                                            Logout
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="settings w-100 col-xl-12 d-flex justify-content-end">
                                <button class="btn icon-btn" id="dropdownSettings">
                                    <i class="fa fa-cog"></i>
                                </button>
                                <ul class="navbar-nav flex-column dropdown-icon" id="dropdown-setting">
                                    <li class="nav-item mt-3 dropstart">
                                        <a href="#" class="nav-link" data-bs-toggle="dropdown" aria-expanded="false">
                                            My Profile
                                        </a>
                                        <div class="dropdown-menu m-0 p-0 dropdown-user">
                                            <div class="unameBox">
                                                <a href="redirect.php?page=user_profile">
                                                    <img src="<?= 'resources/images/UserAvatars/' . $profile ?>" alt="avatar">
                                                </a>
                                                    <span class="m-auto"><a href="redirect.php?page=user_profile"><?= $name ?></a></span>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button type="button" onclick="LogoutBtn()" class="btn m-1 logout-btn">
                                                    Logout
                                                </button>
                                            </div>
                                            <script>
                                                function LogoutBtn(){
                                                    if(confirm("Are you sure you want to logout?")){
                                                        window.location.assign("php/logout.php");
                                                    }
                                                }
                                            </script>
                                        </div>
                                    </li>
                                    <li class="nav-item dropstart">
                                        <a href="#" class="nav-link" data-bs-toggle="dropdown" aria-expanded="false" id="btnSideNotifs">
                                            Alerts <span class="badge bg-danger" id="countNum"></span>
                                        </a>
                                        <ul class="dropdown-menu notification-scroll-wrapper p-0 pt-1" id="dropdownSideNotifs">
                                            <!-- NOTIFICATION HERE... -->
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </figure>
                    </div>
                </header>

                <!-- ACTION CONTAINER -->
                <div class="position-fixed" id="actionContainer">
                    <div class="w-100 d-flex justify-content-end"><i class="fas fa-times" id="closeButton"></i></div>
                    <div id="actionMainContainer">
                        
                    </div>
                </div>
                <!-- MAIN CONTENT -->
                <main class="col-xl-12" id="main-container">
                        <div class="w-100 bg-light p-2">
                            <h4 class="fw-bold m-3">BARANGAY - <span id="BrgyValue"><?= $from_brgy ?></span></h4>
                        </div>
                