<?php include_once "includes/header.php"; ?>
    <div class="container-fluid px-3 py-2">
        <div class="notification-preview-wrapper m-auto px-2">
            <?php
                if(isset($_GET['token_id'])){
                    $token_id = $_GET['token_id'];
                    if($token_id <> ""){

                        $fetch_notifs_query = mysqli_query($conn, "SELECT * FROM alertlogs A, patient_info P WHERE A.P_ID = P.P_ID");
                        
                        while($row = mysqli_fetch_array($fetch_notifs_query)){
                            $correct_id = $row['Alert_ID'];
                            $encrypt_id = sha1($correct_id);

                            if($token_id == $encrypt_id){
                                $alertType = $row['alertType'];
                                $alertMessage = $row['alertMessage'];
                                $profile = $row['Image'];
                                $name = $row['Fname'] . " " . substr($row['Mname'], 0, 1) . ". " . $row['Sname'];
                                $datetime = $row['DateNotify'] . " - " . $row['TimeNotify']; 
                                $P_ID = $row['P_ID'];
                            }else{
                                $alertType = "";
                                $alertMessage = "";
                                $profile = "";
                                $name = "";
                                $datetime = "";
                                $P_ID = "";
                                echo "<script>
                                            window.location.assign('redirect.php');
                                      </script>";
                            }
                        }
                    }else{
                        $alertType = "";
                        $alertMessage = "";
                        $profile = "";
                        $name = "";
                        $datetime = "";
                        $P_ID = "";
                        echo "<script>
                                window.location.assign('redirect.php');
                          </script>";
                    }
                }else{
                    $alertType = "";
                    $alertMessage = "";
                    $profile = "";
                    $name = "";
                    $datetime = "";
                    $P_ID = "";
                    echo "<script>
                                window.location.assign('redirect.php');
                          </script>";
                   
                }

            ?>
            <div class="notification-preview-content">
                <div class="notification-preview-header d-flex">
                    <figure><img src="<?= 'resources/images/PatientAvatars/' . $profile ?>" alt="" class="user-profile"></figure>
                    <div class="notification-column">
                        <span id="ContactPersonID" hidden><?= $P_ID ?></span>
                        <span class="notif-user"><?= $name ?></span>
                        <span class="notif-dt"><?= $datetime ?></span>
                    </div>
                </div>
                <div class="notification-preview-body p-3">
                    <label>Type of Alert: &nbsp;</label><span class="badge bg-danger"><?= $alertType ?></span>
                    <br><br>
                    <?= $alertMessage ?>
                </div>
                <div class="notification-preview-footer p-2 d-flex justify-content-between">
                    <button class="btn btn-dark_color" data-bs-toggle="modal" data-bs-target="#smsModal"><i class="fa-solid fa-envelope"></i> Send SMS</button>
                    <button class="btn btn-base_color" data-bs-toggle="modal" data-bs-target="#callassistModal"><i class="fas fa-headset"></i> Call for Assistance</button>
                </div>
            </div>
        </div>
    </div>

<?php include_once "includes/footer.php"?>
<!-- MODALS -->
    <!-- SEND SMS MODAL -->
        <div class="modal fade" id="smsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="smsModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="fw-bold">Message Contact Person</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <textarea class="form-control" style="height : 100px" placeholder="Compose a message..." id="txtMessage"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-base_color" id="btnSendSms"><i class="fa-solid fa-paper-plane"></i>&nbsp; Send</button>
                    </div>
                </div>
            </div>
        </div>

    <!-- CALL FOR ASSISTANCE MODAL -->
        <div class="modal fade" id="callassistModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="callassistModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="fw-bold">CALL FOR ASSISTANCE</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-4">
                            <input type="search" class="form-control" id="searchPersonnel">
                        </div>
                        <h5 class="fw-bold">LIST OF AVAILABLE PERSONNEL</h5>
                        <div id="assistance_list">
                            <!-- PERSONNEL LIST -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-base_color" id="btnDeployPerson">Deploy personnel</button>
                    </div>
                </div>
            </div>
        </div>
<script src="js/notificationView.js"></script>