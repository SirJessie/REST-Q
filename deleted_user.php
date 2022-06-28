<?php include_once "includes/header.php"?>
<?php
    // USER ID
    if(isset($_SESSION['RESTQ_USER-ID']) && isset($_SESSION['RESTQ_USER-ROLE'])){
        $YOUR_USER_ID = $_SESSION['RESTQ_USER-ID'];
        $YOUR_USER_ROLE = $_SESSION['RESTQ_USER-ROLE'];
    }

    //SUCCESS
    if(isset($_GET['success_restoring'])){
        echo '<script>
                    swal({
                        title:"SUCCESS",
                        text: "User restored",
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
?>
    <div class="container-fluid p-4">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-between">
                <h6 class="fw-bold p-2">USER MANAGEMENT / DELETED USERS</h6>
            </div>
            <div class="col-md-12 container-sm table-responsive table-container p-4 pt-2">
                <div class="navbar-expand nav-button-bar mb-5">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <button type="button" class="btn btn-inline" id="restoreUser">
                                <i class="fas fa-undo-alt"></i>
                                <span>Restore user</span>
                            </button>
                        </li>  
                        <li class="nav-item dropdown">
                            <button class="btn btn-inline dropdown-toggle" type="button" id="btnAUExport" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-file-export"></i>
                                <span>Export</span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownAUExport">
                                <form action="php/exportfile.php" method="post">
                                    <input type="text" class="form-control" name="htxtSearch">
                                    <li><button type="submit" name="btnCSV" class="dropdown-item">CSV File</button></li>
                                    <li><button type="submit" name="btnExcel" class="dropdown-item">Excel File</button></li>
                                </form>
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
                            <th>DELETED ON</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($YOUR_USER_ROLE== "Global Administrator"){
                                $populate_users = "SELECT *  FROM user_info UI, user_logs UL WHERE UI.U_ID = UL.U_ID AND UI.DeletedDate = UL.DateOfAction AND UI.U_ID <> '$YOUR_USER_ID' AND UI.AccountStatus = 'Deleted' AND Action = 'DeleteUser' ORDER BY UI.ID DESC";
                            }else if($YOUR_USER_ROLE == "User Administrator"){
                                $populate_users = "SELECT * FROM user_info UI, user_logs UL WHERE UI.U_ID = UL.U_ID AND UI.DeletedDate = UL.DateOfAction AND UI.U_ID <> '$YOUR_USER_ID' AND UI.Roles <> 'Global Administrator' AND UI.AccountStatus = 'Deleted' AND Action = 'DeleteUser' ORDER BY UI.ID DESC";
                            }else if($YOUR_USER_ROLE == "Patient Administrator"){
                                $populate_users = "SELECT * FROM user_info UI, user_logs UL WHERE UI.U_ID = UL.U_ID AND UI.DeletedDate = UL.DateOfAction AND UI.U_ID <> '$YOUR_USER_ID' AND UI.Roles <> 'Global Administrator' AND UI.Roles <> 'User Administrator' AND UI.AccountStatus = 'Deleted' AND Action = 'DeleteUser' ORDER BY UI.ID DESC";
                            }else{
                                $populate_users = "SELECT * FROM user_info UI, user_logs UL WHERE UI.U_ID = UL.U_ID AND UI.DeletedDate = UL.DateOfAction AND UI.U_ID <> '$YOUR_USER_ID' AND UI.Roles <> 'Global Administrator' AND UI.Roles <> 'User Administrator' AND UI.Roles <> 'Patient Administrator' AND UI.AccountStatus = 'Deleted' AND Action = 'DeleteUser' ORDER BY UI.ID DESC";
                            }
                            
                            $populate_result = mysqli_query($conn, $populate_users);
                            
                            while($user_table = mysqli_fetch_array($populate_result)):
                        ?>
                            <tr>
                                <td><input type="checkbox" class="m-auto" name="restoreUser[]" id="<?= $user_table['U_ID']?>" value="<?= $user_table['U_ID']?>"></td>
                                <td><label for="<?= $user_table['U_ID']?>"><?= $user_table['U_ID']?></label></td>
                                <td><label for="<?= $user_table['U_ID']?>"><?= $user_table['Fname'] . " " . substr($user_table['Mname'],0,1) . ". " . $user_table['Sname']?></label></td>
                                <td><label for="<?= $user_table['U_ID']?>"><?= $user_table['DeletedDate']?>, <?= date("h:i:s a", strtotime($user_table['TimeOfAction']))?></label></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php include_once "includes/footer.php"?>
<script>
    $(document).ready(function () {
        $('#data-table_filter input[type="search"]').keyup(function () {
            $('input[name="htxtSearch"]').val($('#data-table_filter input[type="search"]').val());
        });
    });
</script>