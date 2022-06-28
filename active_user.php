<?php include_once "includes/header.php"?>
<?php
    // USER ID
    if(isset($_SESSION['RESTQ_USER-ID']) && isset($_SESSION['RESTQ_USER-ROLE'])){
        $YOUR_USER_ID = $_SESSION['RESTQ_USER-ID'];
        $YOUR_USER_ROLE = $_SESSION['RESTQ_USER-ROLE'];
    }

    //SUCCESS
    if(isset($_GET['success_adding'])){
        echo '<script>
                    swal({
                        title:"SUCCESS",
                        text: "Add successfully",
                        icon: "success",
                    });
                </script>';
    }
    if(isset($_GET['success_updating'])){
        echo '<script>
                    swal({
                        title:"SUCCESS",
                        text: "Update successfully",
                        icon: "success",
                    });
                </script>';
    }
    if(isset($_GET['success_deleting'])){
        echo '<script>
                    swal({
                        title:"SUCCESS",
                        text: "User(s) deleted",
                        icon: "success",
                    });
                </script>';
    }
    if(isset($_GET['success_blocking'])){
        echo '<script>
                    swal({
                        title:"SUCCESS",
                        text: "Block successfully",
                        icon: "success",
                    });
                </script>';
    }
    if(isset($_GET['success_unblocking'])){
        echo '<script>
                    swal({
                        title:"SUCCESS",
                        text: "Unblock successfully",
                        icon: "success",
                    });
                </script>';
    }
    if(isset($_GET['password_reset'])){
        echo '<script>
                    swal({
                        title:"SUCCESS",
                        text: "Password reset",
                        icon: "success",
                    });
                </script>';
    }

    //ERROR
    if(isset($_GET['query_error'])){
        echo '<script>
                    swal({
                        title:"FAILED",
                        text: "Query error",
                        icon: "error",
                    });
                </script>';
    }

    if(isset($_GET['unknown_error'])){
        echo '<script>
                    swal({
                        title:"FAILED",
                        text: "Unknown error",
                        icon: "error",
                    });
                </script>';
    }

    if(isset($_GET['error_file_exts'])){
        echo '<script>
                    swal({
                        title:"FAILED",
                        text: "You cannot upload this file type!",
                        icon: "error",
                    });
                </script>';
    }
?>
    <div class="container-fluid p-4">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-between">
                <h6 class="fw-bold p-2">USER MANAGEMENT / ACTIVE USERS</h4>
            </div>
            <div class="col-md-12 container-sm table-responsive table-container p-4 pt-2">
                <div class="navbar-expand nav-button-bar mb-5">

                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <button type="button" class="btn btn-inline" id="addUser">
                                <i class="fas fa-user-plus"></i>
                                <span>Add a user</span>
                            </button>
                        </li>  
                        <li class="nav-item">
                            <button type="button" class="btn btn-inline" id="resetUser">
                                <i class="fas fa-key"></i>
                                <span>Reset Password</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="btn btn-inline" id="deleteUser">
                                <i class="fas fa-user-times"></i>
                                <span>Delete user</span>
                            </button>
                        </li>
                        <li class="nav-item dropdown">
                            <button class="btn btn-inline dropdown-toggle" type="button" id="btnAUExport" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-file-export"></i>
                                <span>Export</span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownAUExport">
                                <li><button class="dropdown-item" type="button">CSV File</button></li>
                                <li><button class="dropdown-item" type="button">Excel File</button></button></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <table id="data-table" class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>USER ID</th>
                            <th>USER NAME</th>
                            <th>ROLE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($YOUR_USER_ROLE== "Global Administrator"){
                                $populate_users = "SELECT * FROM user_info WHERE U_ID <> '$YOUR_USER_ID' AND AccountStatus <> 'Deleted' ORDER BY ID DESC";
                            }else if($YOUR_USER_ROLE == "User Administrator"){
                                $populate_users = "SELECT * FROM user_info WHERE U_ID <> '$YOUR_USER_ID' AND Roles <> 'Global Administrator' AND AccountStatus <> 'Deleted' ORDER BY ID DESC";
                            }else if($YOUR_USER_ROLE == "Patient Administrator"){
                                $populate_users = "SELECT * FROM user_info WHERE U_ID <> '$YOUR_USER_ID' AND Roles <> 'Global Administrator' AND Roles <> 'User Administrator' AND AccountStatus <> 'Deleted' ORDER BY ID DESC";
                            }else{
                                $populate_users = "SELECT * FROM user_info WHERE U_ID <> '$YOUR_USER_ID' AND Roles <> 'Global Administrator' AND Roles <> 'User Administrator' AND Roles <> 'Patient Administrator' AND AccountStatus <> 'Deleted' ORDER BY ID DESC";
                            }
                            
                            $populate_result = mysqli_query($conn, $populate_users);
                            
                            while($user_table = mysqli_fetch_array($populate_result)):
                        ?>
                            <tr>
                                <td><input type="checkbox" class="m-auto" name="userSelect[]" id="<?= $user_table['U_ID']?>" value="<?= $user_table['U_ID']?>"></td>
                                <td><label for="<?= $user_table['U_ID']?>"><?= $user_table['U_ID']?></label></td>
                                <td><label for="<?= $user_table['U_ID']?>"><?= $user_table['Fname'] . " " . substr($user_table['Mname'],0,1) . ". " . $user_table['Sname']?></label></td>
                                <td><label for="<?= $user_table['U_ID']?>"><?= $user_table['Roles']?></label></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php include_once "includes/footer.php"?>