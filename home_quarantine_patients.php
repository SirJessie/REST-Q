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
            <h6 class="fw-bold p-2">PATIENT MANAGEMENT / HOME QUARANTINED PATIENTS</h6>
            <div class="col-md-12 container-sm table-responsive table-container p-4 pt-2">
                <div class="navbar-expand nav-button-bar mb-5">
                    <?php
                        if($YOUR_USER_ROLE == "Global Administrator" || $YOUR_USER_ROLE == "User Administrator" || $YOUR_USER_ROLE == "Patient Administrator"):
                    ?>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <button type="button" class="btn btn-inline" id="addPatient">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Add patient</span>
                                </button>
                            </li>  
                            <li class="nav-item">
                                <button type="button" class="btn btn-inline" id="resetPatient">
                                    <i class="fas fa-key"></i>
                                    <span>Reset app password</span>
                                </button>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
                <table id="data-table" class="table">
                    <?php
                        if($YOUR_USER_ROLE == "Global Administrator" || $YOUR_USER_ROLE == "User Administrator" || $YOUR_USER_ROLE == "Patient Administrator"):
                    ?>
                    <thead>
                        <tr>
                            <th></th>
                            <th>PATIENT ID</th>
                            <th>PATIENT NAME</th>
                            <th>CASE</th>
                            <th>START</th>
                            <th>REMAINING DAYS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $populate_patients = "SELECT * FROM patient_info WHERE QuarantineEnd >= '$dateNow' OR QuarantineEnd = '' ORDER BY QuarantineDate";
                            $populate_result = mysqli_query($conn, $populate_patients);
                            
                            while($patient_table = mysqli_fetch_array($populate_result)):
                                
                        ?>
                            <tr>
                                <td><input type="checkbox" class="m-auto"name="patientSelect[]" id="<?= $patient_table['P_ID']?>" value="<?= $patient_table['P_ID']?>"></td>
                                <td><label for="<?= $patient_table['P_ID']?>"><?= $patient_table['P_ID']?></label></td>
                                <td><label for="<?= $patient_table['P_ID']?>"><?= $patient_table['Fname'] . " " . substr($patient_table['Mname'],0,1) . ". " . $patient_table['Sname']?></label></td>
                                <td><label for="<?= $patient_table['P_ID']?>"><?= $patient_table['InfectiousDisease']?></label></td>
                                <td><label for="<?= $patient_table['P_ID']?>"><?= ($patient_table['QuarantineDate'] <> '0000-00-00') ? $patient_table['QuarantineDate'] : "" ?></label></td>
                                <td><label for="<?= $patient_table['P_ID']?>"><?= ($patient_table['QuarantineDate'] <> '0000-00-00') ? (ceil(abs(strtotime($patient_table['QuarantineEnd']) - strtotime($dateNow)) / 86400)) : "" ?></label></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                    <?php else: ?>
                        <thead>
                        <tr>
                            <th>PATIENT ID</th>
                            <th>PATIENT NAME</th>
                            <th>CASE</th>
                            <th>START</th>
                            <th>REMAINING DAYS</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                $populate_patients = "SELECT * FROM patient_info WHERE QuarantineEnd >= '$dateNow' OR QuarantineEnd = '' ORDER BY QuarantineDate";
                                $populate_result = mysqli_query($conn, $populate_patients);
                                
                                while($patient_table = mysqli_fetch_array($populate_result)):
                                    
                            ?>
                                <tr>
                                    <td><label for="<?= $patient_table['P_ID']?>"><?= $patient_table['P_ID']?></label></td>
                                    <td><label for="<?= $patient_table['P_ID']?>"><?= $patient_table['Fname'] . " " . substr($patient_table['Mname'],0,1) . ". " . $patient_table['Sname']?></label></td>
                                    <td><label for="<?= $patient_table['P_ID']?>"><?= $patient_table['InfectiousDisease']?></label></td>
                                    <td><label for="<?= $patient_table['P_ID']?>"><?= ($patient_table['QuarantineDate'] <> '0000-00-00') ? $patient_table['QuarantineDate'] : "" ?></label></td>
                                    <td><label for="<?= $patient_table['P_ID']?>"><?= ($patient_table['QuarantineDate'] <> '0000-00-00') ? (ceil(abs(strtotime($patient_table['QuarantineEnd']) - strtotime($dateNow)) / 86400)) : "" ?></label></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
<?php include_once "includes/footer.php"?>