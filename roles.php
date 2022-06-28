<?php include_once "includes/header.php"; ?>
    <div class="container-fluid p-3">
        <h4 class="fw-bold p-2 m-auto">DESCRIPTION OF ROLES</h4>
        <div class="accordion" id="accordionWrapper">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGlobalAdmin" aria-expanded="false" aria-controls="collapseGlobalAdmin">
                        Global Administrator
                    </button>
                </h2>
                <div id="collapseGlobalAdmin" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionWrapper">
                    <div class="accordion-body">
                        The Global Administrator is the one who manage the access to all administrative features in RestQ Web System, and assign administrator roles to other user.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUserAdmin" aria-expanded="false" aria-controls="collapseUserAdmin">
                        User Administrator
                    </button>
                </h2>
                <div id="collapseUserAdmin" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionWrapper">
                    <div class="accordion-body">
                        The User Administrator is the one who manages the other web system user information and account status.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePatientAdmin" aria-expanded="false" aria-controls="collapsePatientAdmin">
                        Patient Administrator
                    </button>
                </h2>
                <div id="collapsePatientAdmin" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionWrapper">
                    <div class="accordion-body">
                        The Patient Administrator is the one who administer patient's information and account status.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHealthWorker" aria-expanded="false" aria-controls="collapsePatientAdmin">
                        Health Worker
                    </button>
                </h2>
                <div id="collapseHealthWorker" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionWrapper">
                    <div class="accordion-body">
                        The Health Worker is the one who welcome the patients and perform a range of specific tasks, including admitting and interviewing patients and recording patient information and/or vital signs.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMonitoring" aria-expanded="false" aria-controls="collapsePatientAdmin">
                        Monitoring Personnel
                    </button>
                </h2>
                <div id="collapseMonitoring" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionWrapper">
                    <div class="accordion-body">
                        The Monitoring Personnel helps healthcare providers to monitor physiological signals of a patient's health.
                    </div>
                </div>
            </div>
        </div>
        

        <div class="mt-5">
            <h4 class="fw-bold p-2 m-auto">ASSIGN WORK AND RESTRICTION OF ROLES</h4>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col" class="text-center">Global Admin</th>
                        <th scope="col" class="text-center">User Admin</th>
                        <th scope="col" class="text-center">Patient Admin</th>
                        <th scope="col" class="text-center">Health Worker</th>
                        <th scope="col" class="text-center">Monitoring Personnel</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">Manage all users</th>
                        <td class="text-center">YES</td>
                        <td class="text-center">NO</td>
                        <td class="text-center">NO</td>
                        <td class="text-center">NO</td>
                        <td class="text-center">NO</td>
                    </tr>
                    <tr>
                        <th scope="row">Adding user</th>
                        <td class="text-center">YES</td>
                        <td class="text-center">YES</td>
                        <td class="text-center">NO</td>
                        <td class="text-center">NO</td>
                        <td class="text-center">NO</td>
                    </tr>
                    <tr>
                        <th scope="row">Editing user info</th>
                        <td class="text-center">YES</td>
                        <td class="text-center">YES</td>
                        <td class="text-center">NO</td>
                        <td class="text-center">NO</td>
                        <td class="text-center">NO</td>
                    </tr>
                    <tr>
                        <th scope="row">Removing user</th>
                        <td class="text-center">YES</td>
                        <td class="text-center">YES</td>
                        <td class="text-center">NO</td>
                        <td class="text-center">NO</td>
                        <td class="text-center">NO</td>
                    </tr>
                    <tr>
                        <th scope="row">Assign monitong personnel/health worker in emergency</th>
                        <td class="text-center">YES</td>
                        <td class="text-center">YES</td>
                        <td class="text-center">NO</td>
                        <td class="text-center">NO</td>
                        <td class="text-center">NO</td>
                    </tr>
                    <tr>
                        <th scope="row">Register patient</th>
                        <td class="text-center">YES</td>
                        <td class="text-center">YES</td>
                        <td class="text-center">YES</td>
                        <td class="text-center">NO</td>
                        <td class="text-center">NO</td>
                    </tr>
                    <tr>
                        <th scope="row">Edit patient information</th>
                        <td class="text-center">YES</td>
                        <td class="text-center">YES</td>
                        <td class="text-center">YES</td>
                        <td class="text-center">NO</td>
                        <td class="text-center">NO</td>
                    </tr>
                    <tr>
                        <th scope="row">Assigned to check patients if needs</th>
                        <td class="text-center">NO</td>
                        <td class="text-center">NO</td>
                        <td class="text-center">NO</td>
                        <td class="text-center">YES</td>
                        <td class="text-center">YES</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php include_once "includes/footer.php"?>