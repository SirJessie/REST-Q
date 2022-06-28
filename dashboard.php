<?php include_once "includes/header.php"; ?>
    <div class="container-fluid px-3 py-2">

        <!-- STATISTICS -->
        <div class="section-wrap">
            <div class="w-100 d-flex justify-content-end" id="selectCategory">
                <label class="fw-bold form-label my-auto">INFECTIOUS DISEASE&nbsp;&nbsp;</label>
                    <select class="form-select" id="selectInfect" style="text-align : center">
                        <?php
                            $sql ="SELECT * FROM patient_info";
                            $result = mysqli_query($conn,$sql);
                            if(mysqli_num_rows($result) > 0){
                                $data = array();
                                while($row = mysqli_fetch_array($result)){
                                    array_push($data, $row['InfectiousDisease']);
                                }
                                $new_data = array_unique($data);
                                
                                foreach($new_data as $item){
                                    echo "<option value='" . $item . "'>" . $item ."</option>";
                                }
                            }
                        ?>
                    </select>
            </div>
            <div class="header-dashboard">
                <div class="w-50">
                    <h6 class="fw-bold">DASHBOARD / ADMIN</h6>
                </div>
                <div class="w-50 d-flex justify-content-end">
                    <button type="submit" class="btn btn-base_color">Create Report</button>
                </div>
            </div>
            <section id="statistics">
                <!-- NUMBER OF HOME QUARANTINE PATIENTS -->
                <div class="statistic-item">
                    <span class="stat-desc"><i class="fas fa-user"></i>&nbsp;&nbsp;Home Quarantine Patients</span>
                    <div class="text-wrap">
                        <span id="numberHQP" class="stat-number"></span>
                    </div>
                </div>

                <!-- ADDED CASES TODAY -->
                <div class="statistic-item">
                    <span class="stat-desc">Added Cases Today</span>
                    <div class="text-wrap">
                        <span id="numberCT" class="stat-number"></span>
                    </div>
                </div>

                <!-- ACTIVE DEVICES -->
                <div class="statistic-item">
                    <span class="stat-desc">Active Device</span>
                    <div class="text-wrap">
                        <span id="numberAD" class="stat-number"></span>
                    </div>
                </div>

                <!-- ALERT STATUS -->
                <div class="statistic-item">
                    <span class="stat-desc">Alert Status</span>
                    <div class="text-wrap">
                        <span id="numberAS" class="stat-number"></span>
                    </div>
                </div>
            </section>
        </div>
        
        <!-- GRAPH -->
        <div class="section-wrap">
            <section id="graphical-chart" class="row">
                <div class="col-md-8 col-sm-12 chart1 mb-2 me-5">
                    <canvas id="chart1"></canvas>
                </div>
                <div class="col-md-3 col-sm-12 summary-wrap">
                    <div class="summary-text">SUMMARY</div>
                    <div class="summary-group">
                        <b>TOTAL CASES</b>
                        <span class="number" id="totalCases"></span>
                    </div>
                    <div class="summary-group">
                        <b>ACTIVE</b>
                        <span class="number" id="totalActive"></span>
                    </div>
                    <div class="summary-group">
                        <b>RECOVERIES</b>
                        <span class="number" id="totalRecovery"></span>
                    </div>
                    <div class="summary-group">
                        <b>DEATHS</b>
                        <span class="number" id="totalDecease"></span>
                    </div>
                </div>
            </section>
        </div>
        
        <!-- MAPPING -->
        <div class="section-wrap">
            <section class="patient-map-outer-wrapper">
                <div class="patient-map-inner-wrapper">
                    <div id="patient-mapping">

                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        populateMarker();

        $("#selectInfect").on('change',function () {

            populateMarker();

        });
        
        function populateMarker(){
            $.ajax({
            url : 'php/JSONLocation.php',
			method : 'post',
			data : { Brgy : $("#BrgyValue").text(), Disease : $("#selectInfect").val()},
			cache : false,
			success : function(data){
                    var locations = JSON.parse(data);

                    var map = new google.maps.Map(document.getElementById('patient-mapping'), {
                        zoom: 12,
                        center: { lat: 14.7783761, lng: 121.0521872 },
                    });

                    var infowindow = new google.maps.InfoWindow();

                    var marker, i;

                    for (i = 0; i < locations.length; i++) {
                        marker = new google.maps.Marker({
                            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                            map: map
                        });


                        google.maps.event.addListener(marker, 'click', (function(marker, i) {
                            return function() {
                                infowindow.setContent(
                                    "<div class='infoWindowContent'>" +
                                        "<img src="+ 'resources/images/PatientAvatars/' + locations[i][3] +">" +
                                        "<div class='infoWindowBody'>" + 
                                            "<h6 class='my-2'>" + locations[i][0] + "</h6>" +
                                            "<span><i class='fa-solid fa-user'></i>&nbsp;&nbsp;" + locations[i][4] + ' ' + locations[i][5].substring(0, 1) + '. ' + locations[i][6] + "</span>" +
                                            "<span><i class='fa-solid fa-location-dot'></i>&nbsp;&nbsp;" + locations[i][7] + "</span>" +
                                            "<span><i class='fa-solid fa-hashtag'></i>&nbsp;&nbsp;" + locations[i][8] + "</span>" +
                                        "</div>" +
                                    "</div>"
                                );
                                infowindow.open(map, marker);
                            }
                        })(marker, i));

                    }
            	}
            })
        }  
    </script>
<?php include_once "includes/footer.php"?>
