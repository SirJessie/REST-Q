<?php
    session_start();
    if(isset($_POST['LoadData'])  && isset($_SESSION['RESTQ_USER-ID'])){
        include "config.php";

        $user_id = mysqli_real_escape_string($conn, $_SESSION['RESTQ_USER-ID']);

        $check_user_query = "SELECT * FROM user_info WHERE U_ID = '$user_id'";

        $check_user_result = mysqli_query($conn, $check_user_query);

        $fetch_data = mysqli_fetch_array($check_user_result);

        //FETCH USER DATA
        $user_role = $fetch_data['Roles'];
        $from_brgy = $fetch_data['FromBrgy'];

        //ADD USER
        if($_POST['LoadData'] == "AddUser"){
            include_once "GenerateFunctions.php";
            

            echo '<h3 class="mb-4">Add a user</h3>
                    <form action="php/UserProcess.php" method="post" class="needs-validation" novalidate>
                        <div class="row">';

                            if($user_role == "Global Administrator"){
                            
                               echo '<div class="col-md-6">
                                        <label for="U_ID" class="form-label">User ID</label>
                                        <input type="text" class="form-control" name="U_ID" id="U_ID" pattern="[0-9]+" readonly required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="FromBrgy" class="form-label">From Brgy</label>
                                        <input type="text" class="form-control" name="FromBrgy" id="FromBrgy" placeholder="Brgy" autofocus required>
                                    </div>';
                            
                            }else{
                                echo '<div class="col-md-6">
                                        <label for="U_ID" class="form-label">User ID</label>
                                        <input type="text" class="form-control" value=' . GenerateUserID() . ' name="U_ID" id="U_ID" pattern="[0-9]+" readonly required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">From Brgy</label>
                                        <input type="text" class="form-control" name="FromBrgy" value='. $from_brgy .' placeholder="Brgy" readonly required>
                                    </div>';
                            }

            echo       '</div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Fname" class="form-label">Firstname</label>
                                <input type="text" class="form-control" name="Fname" id="Fname" pattern="[A-Za-zñÑ\s]+" placeholder="Firstname" autofocus required>
                            </div>
                            <div class="col-md-6">
                                <label for="Mname" class="form-label">Middlename</label>
                                <input type="text" class="form-control" name="Mname" id="Mname" pattern="[A-Za-zñÑ\s]+" placeholder="Middlename">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Lname" class="form-label">Lastname</label>
                                <input type="text" class="form-control" name="Lname" id="Lname" pattern="[A-Za-zñÑ\s]+" placeholder="Lastname" required>
                            </div>
                            <div class="col-md-6">
                                <label for="Gender" class="form-label">Gender</label>
                                <select name="Gender" class="form-select" id="Gender" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Cntct" class="form-label">Contact no.</label>
                                <input type="text" class="form-control" value="" name="Cntct" id="Cntct" pattern="[0-9]+" maxlength="11" placeholder="Contact Number" required>
                            </div>
                            <div class="col-md-6">
                                <label for="Email" class="form-label">Email Address</label>
                                <input type="text" class="form-control" value="" name="Email" id="Email" pattern="[A-Za-z@.]+" placeholder="Email address" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="Role" class="form-label">Role</label>
                                <select name="Role" class="form-select" id="Role" required>';
                                if($user_role == "Global Administrator"){
                                    echo '<option value="Global Administrator">Global Administrator</option>
                                        <option value="User Administrator">User Administrator</option>
                                        <option value="Patient Administrator">Patient Administrator</option>';
                                }else if($user_role == "User Administrator"){
                                    echo '<option value="User Administrator">User Administrator</option>
                                    <option value="Patient Administrator">Patient Administrator</option>';
                                }else if($user_role == "Patient Administrator"){
                                    echo '<option value="Patient Administrator">Patient Administrator</option>';
                                }          
                                    echo '<option value="Monitoring Personnel">Monitoring Personnel</option>
                                        <option value="Health Worker">Health Worker</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="Addr" class="form-label">Home Address</label>
                                <textarea class="form-control" name="Addr" id="Addr" placeholder="Home Address" required></textarea>
                            </div>
                        </div>
                        <div class="mt-5 w-100 d-flex justify-content-end">
                            <input type="submit" name="btnAdd" class="btn btn-dark_color mx-1" value="Finish Adding">
                            <button type="reset" class="btn btn-danger">Cancel</button>
                        </div>
                    </form>
                    
                    <script src="js/generateUserID.js"></script>';
        }
        //END OF ADD USER

        // UPDATE USER
        if($_POST['LoadData'] == "ViewInfoUser"){

            $UserID = mysqli_real_escape_string($conn, $_POST['UserID']);

            $check_user_query = "SELECT * FROM user_info WHERE U_ID = '$UserID'";

            $check_user_result = mysqli_query($conn, $check_user_query);

            $fetch_data = mysqli_fetch_array($check_user_result);

            //FETCH DATA
            $SigninStatus = $fetch_data['SigninStatus'];
            $Image = $fetch_data['Image'];
            $ImgPath = "resources/images/UserAvatars/" . $Image;
            $Fname = $fetch_data['Fname'];
            $Mname = $fetch_data['Mname'];
            $Sname = $fetch_data['Sname'];
            $Gender = $fetch_data['Gender'];
            $ContactNum = $fetch_data['ContactNumber'];
            $Email = $fetch_data['EmailAddress'];
            $Role = $fetch_data['Roles'];
            $Addr = $fetch_data['Addr'];

            echo '<form action="php/UserProcess.php" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
                <div class="w-100 d-flex">
                    <div class="profile">
                        <div class="image-wrapper">
                            <img src="' . $ImgPath .'" alt="User Profile" id="img-preview">
                        </div>
                        <label for="imgFile" class="form-label clickable-label">Change Photo</label>
                        <input type="file" name="imgFile" id="imgFile" hidden>  
                    </div>
                    <div class="user">  
                        <label>'. substr($Fname, 0, 1) . ". " . $Sname .'</label> 
                        <div class="w-100 d-flex justify-content-between">
                            <a class="nav-link" href="php/UserProcess.php?resetpass_id='. $UserID .'">Reset Password</a>';
                            if($SigninStatus == "Block"){
                                echo '<a class="nav-link" href="php/UserProcess.php?unblock_id='. $UserID .'">Unblock sign-in</a>';
                            }else{
                                echo '<a class="nav-link" href="php/UserProcess.php?block_id='. $UserID .'">Block sign-in</a>';
                            }
                            
                    echo    '<a class="nav-link" href="php/UserProcess.php?delete_id='. $UserID .'">Delete user</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="U_ID" class="form-label">User ID</label>
                        <input type="text" class="form-control" name="U_ID" value="'. $UserID .'" readonly required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <label for="Fname" class="form-label">Firstname</label>
                        <input type="text" class="form-control" name="Fname" id="Fname" value="'. $Fname .'" pattern="[A-Za-zñÑ\s]+" placeholder="Firstname" autofocus required>
                    </div>
                    <div class="col-md-6">
                        <label for="Mname" class="form-label">Middlename</label>
                        <input type="text" class="form-control" name="Mname" id="Mname" value="'. $Mname .'" pattern="[A-Za-zñÑ\s]+" placeholder="Middlename">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="Lname" class="form-label">Lastname</label>
                        <input type="text" class="form-control" name="Lname" id="Lname" value="'. $Sname .'" pattern="[A-Za-zñÑ\s]+" placeholder="Lastname" required>
                    </div>
                    <div class="col-md-6">
                        <label for="Gender" class="form-label">Gender</label>
                        <select name="Gender" class="form-select" id="Gender" required>
                            <option value="Male"'. ($Gender == "Male" ? ' selected' : '') .'>Male</option>
                            <option value="Female"'. ($Gender == "Female" ? ' selected' : '') .'>Female</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="Cntct" class="form-label">Contact no.</label>
                        <input type="text" class="form-control" name="Cntct" id="Cntct" value="'. $ContactNum .'" pattern="[0-9]+" maxlength="11" placeholder="Contact Number" readonly required>
                    </div>
                    <div class="col-md-6">
                        <label for="Email" class="form-label">Email Address</label>
                        <input type="text" class="form-control" name="Email" id="Email" value="'. $Email .'" pattern="[A-Za-z@.]+" placeholder="Email address" readonly required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="Role" class="form-label">Role</label>
                        <select name="Role" class="form-select" id="Role" required>';
                        if($user_role == "Global Administrator"){
                            echo '<option value="Global Administrator"'. ($Role == "Global Administrator" ? ' selected' : '') .'>Global Administrator</option>
                                <option value="User Administrator"'. ($Role == "User Administrator" ? ' selected' : '') .'>User Administrator</option>
                                <option value="Patient Administrator"'. ($Role == "Patient Administrator" ? ' selected' : '') .'>Patient Administrator</option>';
                        }else if($user_role == "User Administrator"){
                            echo '<option value="User Administrator"'. ($Role == "User Administrator" ? ' selected' : '') .'>User Administrator</option>
                            <option value="Patient Administrator"'. ($Role == "Patient Administrator" ? ' selected' : '') .'>Patient Administrator</option>';
                        }else if($user_role == "Patient Administrator"){
                            echo '<option value="Patient Administrator"'. ($Role == "Patient Administrator" ? ' selected' : '') .'>Patient Administrator</option>';
                        }          
                            echo '<option value="Monitoring Personnel"'. ($Role == "Monitoring Personnel" ? ' selected' : '') .'>Monitoring Personnel</option>
                                <option value="Health Worker"'. ($Role == "Health Worker" ? ' selected' : '') .'>Health Worker</option>
                      </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="Addr" class="form-label">Home Address</label>
                        <textarea class="form-control" name="Addr" id="Addr" placeholder="Home Address" required>'. $Addr .'</textarea>
                    </div>
                </div>
                <div class="mt-5 w-100 d-flex justify-content-end">
                    <input type="submit" name="btnSave"  class="btn btn-dark_color" value="Save changes">
                </div>
            </form>';
        }
        //END OF UPDATE USER

        // RESET PASS USER
        if($_POST['LoadData'] == "ResetUserPass"){
            $arrayToReset= $_POST['arrayToReset'];
            $Names = "";

            echo '<h3>Reset Password</h3>
                    <div class="user">';
                    if(count($arrayToReset) > 1){
                        foreach($arrayToReset as $UserID){
                            $check_user_query = "SELECT * FROM user_info WHERE U_ID = '$UserID'";
            
                            $check_user_result = mysqli_query($conn, $check_user_query);
            
                            $fetch_data = mysqli_fetch_array($check_user_result);
                            
                            $Names .= substr($fetch_data['Fname'],0,1) . "." . $fetch_data['Sname'] . ", ";
                        }

                        echo count($arrayToReset) . ' users selected <span><i class="fas fa-info-circle" title="'. $Names .'" data-bs-toggle="tooltip" data-bs-placement="right"></i></span>';
                    }else{
                        foreach($arrayToReset as $UserID){
                            $check_user_query = "SELECT * FROM user_info WHERE U_ID = '$UserID'";
            
                            $check_user_result = mysqli_query($conn, $check_user_query);
            
                            $fetch_data = mysqli_fetch_array($check_user_result);
            
                            $Names .= $fetch_data['Sname'] . ", " . $fetch_data['Fname'];
                        }

                        echo '<span>'. $Names .'</span>'; 
                    }
            echo    '</div>
                    <br><br>
                    <span>Automatically replace password to default</span>
                    <br><br>
                    <form action="php/UserProcess.php" method="post">';
                        foreach($arrayToReset as $UserID){
                            echo '<input type="checkbox" name="IDsToReset[]" value="'. $UserID .'" checked readonly hidden>';
                        }

            echo        '<div class="d-flex>
                            <label for="DefaultPass" class="form-label">Default Password</label>
                            <input type="text" value="RestQpass2021" readonly>
                        </div>
                        <br><br>
                        <span>This will require the user to change their password in their first sign in.</span>
                        <br><br>
                        <div class="mt-5 w-100 d-flex justify-content-end">
                            <input type="submit" name="btnResetPass"  class="btn btn-dark_color" value="Reset Password">
                        </div>
                    </form>';         
        }
        //END OF RESET PASS USER

        //DELETE USER
        if($_POST['LoadData'] == "DeleteUser"){
            $arrayToDelete= $_POST['arrayToDelete'];
            $Names = "";
                    
            if(count($arrayToDelete) > 1){
                foreach($arrayToDelete as $UserID){
                    $check_user_query = "SELECT * FROM user_info WHERE U_ID = '$UserID'";
    
                    $check_user_result = mysqli_query($conn, $check_user_query);
    
                    $fetch_data = mysqli_fetch_array($check_user_result);
                    
                    $Names .= substr($fetch_data['Fname'],0,1) . "." . $fetch_data['Sname'] . ", ";
                }
                $btnValue = "Delete users";

                echo '<h3>Delete users</h3>
                        <div class="user">';
                echo count($arrayToDelete) . ' users selected <span><i class="fas fa-info-circle" title="'. $Names .'" data-bs-toggle="tooltip" data-bs-placement="right"></i></span>';
                  
                $Paragraph = "You can restore deleted users and their data, for up to 30 days after you delete them. After 30 days, data will be permanently deleted.";
            }else{
                foreach($arrayToDelete as $UserID){
                    $check_user_query = "SELECT * FROM user_info WHERE U_ID = '$UserID'";
    
                    $check_user_result = mysqli_query($conn, $check_user_query);
    
                    $fetch_data = mysqli_fetch_array($check_user_result);
    
                    $Names .= $fetch_data['Sname'] . ", " . $fetch_data['Fname'];
                }
                $btnValue = "Delete user";

                echo '<h3>Delete user</h3>
                    <div class="user">';
                echo '<span>'. $Names .'</span>'; 

                $Paragraph = "You can restore deleted user and their data, for up to 30 days after you delete them. After 30 days, data will be permanently deleted.";
            }
            echo '</div>
                    <br><br><br>
                    <span>'. $Paragraph .'</span>
                    <form action="php/UserProcess.php" method="post">';
                    foreach($arrayToDelete as $UserID){
                        echo '<input type="checkbox" name="IDsToDelete[]" value="'. $UserID .'" checked readonly hidden>';
                    }

            echo    '<div class="mt-5 w-100 d-flex justify-content-end">
                            <input type="submit" name="btnDeleteUser"  class="btn btn-dark_color" value="'. $btnValue .'">
                        </div>
                    </form>';
            
        }
        //END OF DELETE USER
        
        //RESTORE USER
        if($_POST['LoadData'] == "RestoreUser"){
            $UserID = mysqli_real_escape_string($conn, $_POST['UserID']);

            // POPULATE USER DATA
            $select_user = "SELECT * FROM user_info WHERE U_ID = '$UserID'";
            $user_result = mysqli_query($conn, $select_user);

            $fetch_data = mysqli_fetch_array($user_result);

            // POPULATE DELETE LOGS DATA
            $user_deleted = "SELECT * FROM user_logs WHERE U_ID = '$UserID'";
            $deleted_result = mysqli_query($conn, $user_deleted);

            $fetch_logs = mysqli_fetch_array($deleted_result);

            echo '<h3>Restore user</h3>
                    <div class="user">
                        ' . substr($fetch_data['Fname'], 0, 1) . '.' . $fetch_data['Sname'] . '
                    </div>
                    <br><br>
                    <div class="d-flex">
                        <div class="w-50">
                            <div class="form=group">
                                <label class="form-label">Deleted on</label>
                                <br>
                                <span class="ps-2">'. $fetch_data['DeletedDate'] .'</span>
                            </div>
                            <br>
                            <div class="form=group">
                                <label class="form-label">User ID</label>
                                <br>
                                <span class="ps-2">'. $UserID .'</span>
                            </div>
                            <br>
                            <div class="form=group">
                                <label class="form-label">Roles</label>
                                <br>
                                <span class="ps-2">'. $fetch_data['Roles'] .'</span>
                            </div>
                        </div>
                        <div class="w-50">
                            <div class="form=group">
                                <label class="form-label">Deleted by</label>
                                <br>
                                <span class="ps-2">'. $fetch_logs['Uname_Action'] .'</span>
                            </div>
                            <br>
                            <div class="form=group">
                                <label class="form-label">Username</label>
                                <br>
                                <span class="ps-2">'. $fetch_data['Fname'] . " " . $fetch_data['Mname'] . " " . $fetch_data['Sname'] .'</span>
                            </div>
                            <br>
                        </div>
                    </div>';

            echo    '<form action="php/UserProcess.php" method="post">
                        <input type="text" name="U_ID" value="'. $UserID .'" checked readonly hidden>
                        <br><br>
                        <div class="mt-5 w-100 d-flex justify-content-end">
                            <input type="submit" name="btnRestoreUser"  class="btn btn-dark_color" value="Restore user">
                        </div>
                    </form>';    

        }
        //END OF RESTORE USER

        // ADD PATIENT
        if($_POST['LoadData'] == "AddPatient"){
            include_once "GenerateFunctions.php";
            echo '<h3 class="mb-4">Add patient</h3>
                <form action="php/PatientProcess.php" method="post" class="needs-validation" novalidate>
                    <div class="row">';

                        if($user_role == "Global Administrator"){
                        
                        echo '<div class="col-md-6">
                                    <label for="P_ID" class="form-label">Patient ID</label>
                                    <input type="text" class="form-control" name="P_ID" id="P_ID" pattern="[0-9]+" readonly required>
                                </div>
                                <div class="col-md-6">
                                    <label for="FromBrgy" class="form-label">From Brgy</label>
                                    <input type="text" class="form-control" name="FromBrgy" id="FromBrgy" placeholder="Brgy" autofocus required>
                                </div>';
                        
                        }else{
                            echo '<div class="col-md-6">
                                    <label for="P_ID" class="form-label">Patient ID</label>
                                    <input type="text" class="form-control" value=' . GeneratePatientID() . ' name="P_ID" id="U_ID" pattern="[0-9]+" readonly required>
                                </div>
                                <div class="col-md-6">
                                    <label for="FromBrgy" class="form-label">From Brgy</label>
                                    <input type="text" class="form-control" name="FromBrgy" id="FromBrgy" value='. $from_brgy .' placeholder="Brgy" readonly required>
                                </div>';
                        }
            echo    '</div>
                    <br>
                    <div class="groupText">Personal Information</div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="Fname" class="form-label">Firstname</label>
                            <input type="text" class="form-control" name="Fname" id="Fname" pattern="[A-Za-zñÑ\s]+" placeholder="Firstname" autofocus required>
                        </div>
                        <div class="col-md-6">
                            <label for="Mname" class="form-label">Middlename</label>
                            <input type="text" class="form-control" name="Mname" id="Mname" pattern="[A-Za-zñÑ\s]+" placeholder="Middlename">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <label for="Lname" class="form-label">Lastname</label>
                            <input type="text" class="form-control" name="Lname" id="Lname" pattern="[A-Za-zñÑ\s]+" placeholder="Lastname" required>
                        </div>
                        <div class="col-md-5">
                            <label for="Gender" class="form-label">Gender</label>
                            <select name="Gender" class="form-select" id="Gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <label for="Bdate" class="form-label">Birthdate</label>
                            <input type="date" class="form-control" name="Bdate" id="Bdate" required>
                        </div>
                        <div class="col-md-7">
                            <label for="Occpt" class="form-label">Occupation</label>
                            <input type="text" class="form-control" name="Occpt" id="Occpt" pattern="[A-Za-z\s]+" placeholder="Occupation" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <label for="Nation" class="form-label">Nationality</label>
                            <input type="text" class="form-control" name="Nation" id="Nation" pattern="[A-Za-z\s]+" placeholder="Nationality" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="Cntct" class="form-label">Contact no.</label>
                            <input type="text" class="form-control" name="Cntct" id="Cntct" pattern="[0-9]+" maxlength="11" placeholder="Contact Number" required>
                        </div>
                        <div class="col-md-6">
                            <label for="Email" class="form-label">Email Address</label>
                            <input type="text" class="form-control" name="Email" id="Email" pattern="[A-Za-z@.]+" placeholder="Email address" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="Addr" class="form-label">Home Address</label>
                            <textarea class="form-control" name="Addr" id="Addr" placeholder="Home Address" required></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="groupText">Medical Information</div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Check new case if patient case is not in the selection:</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 py-2 ps-3">  
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="newCase">
                                <label class="form-check-label p-0" for="newCase">
                                    New Case
                                </label>
                            </div>
                        </div>
                        <div class="col-md-8" id="caseSelection">
                            <select name="virusCase" class="form-select" id="selectCase" required>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-8">
                            <label for="LastTrav" class="form-label">Last Travel</label>
                            <input type="text" class="form-control" name="LastTrav" id="LastTrav" placeholder="Last Travel History" required>
                        </div>
                        <div class="col-md-4">
                            <label for="Btype" class="form-label">Blood Type</label>
                            <select name="Btype" class="form-select" id="Btype" required>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="ComorB" class="form-label">Comorbidities</label>
                            <textarea class="form-control" name="ComorB" id="ComorB" placeholder="Comorbidities" required></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="groupText">Person to be notified incase of emergency</div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="PersonNotiName" class="form-label">Fullname</label>
                            <input type="text" class="form-control" name="PersonNotiName" id="PersonNotiName" pattern="[A-Za-zñÑ\s]+" placeholder="Fullname" autofocus required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="PersonNotiRelation" class="form-label">Relationship</label>
                            <select name="PersonNotiRelation" class="form-select" id="PersonNotiRelation" required>
                                <option value="Spouse">Spouse</option>
                                <option value="Parent">Parent</option>
                                <option value="Sibling">Sibling</option>
                                <option value="Children">Children</option>
                                <option value="Guardian">Guardian</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="PersonNotiCntct" class="form-label">Contact no.</label>
                            <input type="text" class="form-control" name="PersonNotiCntct" id="PersonNotiCntct" pattern="[0-9]+" maxlength="11" placeholder="Contact Number" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="PersonNotiAddr" class="form-label">Home Address</label>
                            <textarea class="form-control" name="PersonNotiAddr" id="PersonNotiAddr" placeholder="Home Address" required></textarea>
                        </div>
                    </div>
                    <div class="mt-5 w-100 d-flex justify-content-end">
                        <input type="submit" name="btnAdd" class="btn btn-dark_color mx-1" value="Finish Adding">
                        <button type="reset" class="btn btn-danger">Cancel</button>
                    </div>
                </form>
                
                <script src="js/generatePatientID.js"></script>';

        }
        // END OF ADD PATIENT
        
        // UPDATE PATIENT
        if($_POST['LoadData'] == "ViewInfoPatient"){

            $PatientID = mysqli_real_escape_string($conn, $_POST['PatientID']);

            $check_user_query = "SELECT * FROM patient_info WHERE P_ID = '$PatientID'";

            $check_user_result = mysqli_query($conn, $check_user_query);

            $fetch_data = mysqli_fetch_array($check_user_result);

            // FETCH DATA
            // USER INFO
            $Username = $fetch_data['Fname'] . " " . $fetch_data['Mname'] . " " . $fetch_data['Sname'];
            $Image = $fetch_data['Image'];
            $ImgPath = "resources/images/PatientAvatars/" . $Image;
            $Fname = $fetch_data['Fname'];
            $Mname = $fetch_data['Mname'];
            $Sname = $fetch_data['Sname'];
            $Bdate = $fetch_data['BirthDate'];
            $Gender = $fetch_data['Gender'];;
            $Occupation = $fetch_data['Occupation'];
            $ContactNum = $fetch_data['ContactNumber'];;
            $Email = $fetch_data['EmailAddress'];;
            $Addr = $fetch_data['Address'];;
            $Btype = $fetch_data['BloodType'];
            $Nation = $fetch_data['Nationality'];
            $LastTravel = $fetch_data['LastTravelHistory'];
            $Comorbidities = $fetch_data['Comorbidities'];

            // CONTACT PERSON INFO
            $PersonNotiName = $fetch_data['ContactPersonName'];
            $Relation = $fetch_data['Relationship'];
            $PersonNotiNumber = $fetch_data['ContactPersonNumber'];
            $PersonNotiAddr = $fetch_data['ContactPersonAddress'];

            echo '<form action="php/PatientProcess.php" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
                <div class="w-100 d-flex">
                    <div class="profile">
                        <div class="image-wrapper">
                            <img src="'. $ImgPath .'" alt="User Profile">
                        </div>
                    </div>
                    <div class="user">  
                        <label>'. substr($Fname, 0, 1) . ". " . $Sname .'</label> 
                        <div class="w-100 d-flex justify-content-between">
                            <a class="nav-link" href="php/PatientProcess.php?resetpass_id='. $PatientID .'">Reset Password</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <label for="P_ID" class="form-label">Patient ID</label>
                        <input type="text" class="form-control" name="P_ID" value="'. $PatientID .'" readonly required>
                    </div>
                    <div class="col-md-7">
                        <label for="Uname" class="form-label">Username</label>
                        <input type="text" class="form-control" value="'. $Username .'" readonly>
                    </div>
                </div>
                <br>
                <div class="groupText">Personal Information</div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="Fname" class="form-label">Firstname</label>
                        <input type="text" class="form-control" name="Fname" id="Fname" value="'. $Fname .'" pattern="[A-Za-zñÑ\s]+" placeholder="Firstname" autofocus required>
                    </div>
                    <div class="col-md-6">
                        <label for="Mname" class="form-label">Middlename</label>
                        <input type="text" class="form-control" name="Mname" id="Mname" value="'. $Mname .'" pattern="[A-Za-zñÑ\s]+" placeholder="Middlename">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <label for="Lname" class="form-label">Lastname</label>
                        <input type="text" class="form-control" name="Lname" id="Lname" value="'. $Sname .'" pattern="[A-Za-zñÑ\s]+" placeholder="Lastname" required>
                    </div>
                    <div class="col-md-5">
                        <label for="Gender" class="form-label">Gender</label>
                        <select name="Gender" class="form-select" id="Gender" required>
                            <option value="Male"'. ($Gender == "Male" ? ' selected' : '') .'>Male</option>
                            <option value="Female"'. ($Gender == "Female" ? ' selected' : '') .'>Female</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <label for="Bdate" class="form-label">Birthdate</label>
                        <input type="date" class="form-control" name="Bdate" id="Bdate" value="'. date("Y-m-d", strtotime($Bdate)) .'" required>
                    </div>
                    <div class="col-md-7">
                        <label for="Occpt" class="form-label">Occupation</label>
                        <input type="text" class="form-control" name="Occpt" id="Occpt" value="'. $Occupation .'" pattern="[A-Za-z\s]+" placeholder="Occupation" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <label for="Nation" class="form-label">Nationality</label>
                        <input type="text" class="form-control" name="Nation" id="Nation" value="'. $Nation .'" pattern="[A-Za-z\s]+" placeholder="Nationality" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="Cntct" class="form-label">Contact no.</label>
                        <input type="text" class="form-control" name="Cntct" id="Cntct" value="'. $ContactNum .'" pattern="[0-9]+" maxlength="11" placeholder="Contact Number" required>
                    </div>
                    <div class="col-md-6">
                        <label for="Email" class="form-label">Email Address</label>
                        <input type="text" class="form-control" name="Email" id="Email" value="'. $Email .'" pattern="[A-Za-z@.]+" placeholder="Email address" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="Addr" class="form-label">Home Address</label>
                        <textarea class="form-control" name="Addr" id="Addr" placeholder="Home Address" required>'. $Addr .'</textarea>
                    </div>
                </div>
                <br>
                <div class="groupText">Medical Information</div>
                <div class="row">
                    <div class="col-md-8">
                        <label for="LastTrav" class="form-label">Last Travel</label>
                        <input type="text" class="form-control" name="LastTrav" id="LastTrav" value="'. $LastTravel .'" placeholder="Last Travel History" required>
                    </div>
                    <div class="col-md-4">
                        <label for="Btype" class="form-label">Blood Type</label>
                        <select name="Btype" class="form-select" id="Btype" required>
                            <option value="A+"'. ($Btype == "A+" ? ' selected' : '') .'>A+</option>
                            <option value="A-"'. ($Btype == "A-" ? ' selected' : '') .'>A-</option>
                            <option value="B+"'. ($Btype == "B+" ? ' selected' : '') .'>B+</option>
                            <option value="B-"'. ($Btype == "B-" ? ' selected' : '') .'>B-</option>
                            <option value="AB+"'. ($Btype == "AB+" ? ' selected' : '') .'>AB+</option>
                            <option value="AB-"'. ($Btype == "AB-" ? ' selected' : '') .'>AB-</option>
                            <option value="O+"'. ($Btype == "O+" ? ' selected' : '') .'>O+</option>
                            <option value="O-"'. ($Btype == "O-" ? ' selected' : '') .'>O-</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="ComorB" class="form-label">Comorbidities</label>
                        <textarea class="form-control" name="ComorB" id="ComorB" placeholder="Comorbidities" required>'. $Comorbidities .'</textarea>
                    </div>
                </div>
                <br>
                <div class="groupText">Person to be notified incase of emergency</div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="PersonNotiName" class="form-label">Fullname</label>
                        <input type="text" class="form-control" name="PersonNotiName" id="PersonNotiName" value="'. $PersonNotiName .'" pattern="[A-Za-zñÑ\s]+" placeholder="Fullname" autofocus required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="PersonNotiRelation" class="form-label">Relationship</label>
                        <select name="PersonNotiRelation" class="form-select" name = "PersonNotiRelation" id="PersonNotiRelation" required>
                            <option value="Spouse"'. ($Relation == "Spouse" ? ' selected' : '') .'>Spouse</option>
                            <option value="Parent"'. ($Relation == "Parent" ? ' selected' : '') .'>Parent</option>
                            <option value="Sibling"'. ($Relation == "Sibling" ? ' selected' : '') .'>Sibling</option>
                            <option value="Children"'. ($Relation == "Children" ? ' selected' : '') .'>Children</option>
                            <option value="Guardian"'. ($Relation == "Guardian" ? ' selected' : '') .'>Guardian</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="PersonNotiCntct" class="form-label">Contact no.</label>
                        <input type="text" class="form-control" name="PersonNotiCntct" id="PersonNotiCntct" value="'. $PersonNotiNumber .'" pattern="[0-9]+" maxlength="11" placeholder="Contact Number" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="PersonNotiAddr" class="form-label">Home Address</label>
                        <textarea class="form-control" name="PersonNotiAddr" id="PersonNotiAddr" placeholder="Home Address" required>'. $PersonNotiAddr .'</textarea>
                    </div>
                </div>
                <div class="mt-5 w-100 d-flex justify-content-end">
                    <input type="submit" name="btnSave"  class="btn btn-dark_color" value="Save changes">
                </div>
            </form>';
        }
        //END OF UPDATE PATIENT

        // RESET PASS USER
        if($_POST['LoadData'] == "ResetPatientPass"){
            $arrayToReset= $_POST['arrayToReset'];
            $Names = "";

            echo '<h3>Reset Password</h3>
                    <div class="user">';
                    if(count($arrayToReset) > 1){
                        foreach($arrayToReset as $PatientID){
                            $check_user_query = "SELECT * FROM patient_info WHERE P_ID = '$PatientID'";
            
                            $check_user_result = mysqli_query($conn, $check_user_query);
            
                            $fetch_data = mysqli_fetch_array($check_user_result);
                            
                            $Names .= substr($fetch_data['Fname'],0,1) . "." . $fetch_data['Sname'] . ", \n";
                        }

                        echo count($arrayToReset) . ' patients selected <span><i class="fas fa-info-circle" title="'. $Names .'" data-bs-toggle="tooltip" data-bs-placement="right"></i></span>';
                    }else{
                        foreach($arrayToReset as $PatientID){
                            $check_user_query = "SELECT * FROM patient_info WHERE P_ID = '$PatientID'";
            
                            $check_user_result = mysqli_query($conn, $check_user_query);
            
                            $fetch_data = mysqli_fetch_array($check_user_result);
            
                            $Names .= $fetch_data['Sname'] . ", " . $fetch_data['Fname'];
                        }

                        echo '<span>'. $Names .'</span>'; 
                    }
            echo    '</div>
                    <br><br>
                    <span>Automatically replace password to default</span>
                    <br><br>
                    <form action="php/PatientProcess.php" method="post">';
                        foreach($arrayToReset as $PatientID){
                            echo '<input type="checkbox" name="IDsToReset[]" value="'. $PatientID .'" checked readonly hidden>';
                        }

            echo        '<div class="d-flex>
                            <label for="DefaultPass" class="form-label">Default Password</label>
                            <input type="text" value="RestQapp2021" readonly>
                        </div>
                        <br><br>
                        <span>This will require the user to change their password in their first sign in.</span>
                        <br><br>
                        <div class="mt-5 w-100 d-flex justify-content-end">
                            <input type="submit" name="btnResetPass"  class="btn btn-dark_color" value="Reset Password">
                        </div>
                    </form>';         
        }
        //END OF RESET PASS USER
        
        echo '<script src="js/form-validation.js"></script>
              <script src="js/img-preview.js"></script>
              <script src="js/initializeTooltip.js"></script>';
    
    }

?>