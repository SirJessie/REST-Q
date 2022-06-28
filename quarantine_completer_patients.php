<?php include_once "includes/header.php"?>

    <div class="container-fluid p-4">
        <div class="row">
            <h6 class="fw-bold p-2">PATIENT MANAGEMENT / QUARANTINE COMPLETER PATIENTS</h6>
            <div class="col-md-12 container-sm table-responsive table-container p-4 pt-2">
                <table id="data-table" class="table">
                    <thead>
                        <tr>
                            <th>PATIENT ID</th>
                            <th>PATIENT NAME</th>
                            <th>CASE</th>
                            <th>DATE COMPLETED</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $populate_patients = "SELECT * FROM patient_info WHERE QuarantineEnd <= '$dateNow' AND QuarantineEnd <> '' ORDER BY QuarantineEnd DESC";
                            $populate_result = mysqli_query($conn, $populate_patients);
                            
                            while($patient_table = mysqli_fetch_array($populate_result)):
                        ?>
                            <tr>
                                <td><label for="<?= $patient_table['P_ID']?>"><?= $patient_table['P_ID']?></label></td>
                                <td><label for="<?= $patient_table['P_ID']?>"><?= $patient_table['Fname'] . " " . substr($patient_table['Mname'],0,1) . ". " . $patient_table['Sname']?></label></td>
                                <td><label for="<?= $patient_table['P_ID']?>"><?= $patient_table['InfectiousDisease']?></label></td>
                                <td><label for="<?= $patient_table['P_ID']?>"><?= date("Y-m-d", strtotime($patient_table['QuarantineEnd']))?></label></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php include_once "includes/footer.php"?>