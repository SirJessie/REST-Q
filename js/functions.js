$(document).ready(function () {
	makeGraphChart();
	
	setInterval(function(){

		totalQuarantined();
		totalActiveDevice()
		totalAlertStatus()
        totalCaseToday();
		totalCases();
		totalRecovery();
		totalDecease();
		
		
			
	}, 1000);

	setInterval(function() {
		CountNotifs();
		CountLogs();
	}, 5000);

	setInterval(function(){

		makeGraphChart();
		populateCases();
		
	
	}, 25000);

    $("#selectInfect").on('change',function () {

        totalQuarantined();
		totalActiveDevice()
		totalAlertStatus()
        totalCaseToday();
		totalCases();
		totalRecovery();
		totalDecease();
		makeGraphChart();

    });

	
	function CountNotifs(){
		$.ajax({
			url : 'php/Notifications.php',
			method : 'post',
			data : { Data : 'CountNotifs'},
			cache : false,
			success : function(response){
				if(response > 0){
					$("#countBadge").show();
					$("#countNum").html(response);
					
				}else{
					$("#countBadge").hide();
				}
			}
		})
	}
	function CountLogs(){
		$.ajax({
			url : 'php/UserLogs.php',
			method : 'post',
			data : { Data : 'CountUserLogs'},
			cache : false,
			success : function(response){
				if(response > 0){
					$("#countBadge").show();
					$("#countLogs").html(response);
				}else{
					$("#countBadge").hide();
				}
			}
		})
	}
	function totalQuarantined() {
		var InfectiousDisease = $("#selectInfect").val();
		var Brgy = $("#BrgyValue").text();

		$.ajax({
			url : 'php/StatisticData.php',
			method : 'post',
			data : { Data : 'TotalQuarantined', InfectiousDisease : InfectiousDisease, Brgy : Brgy},
			cache : false,
			success : function(data){
				$("#totalActive").html(data);
				$("#numberHQP").html(data);
			}
		})
	}
	function totalActiveDevice() {
		var InfectiousDisease = $("#selectInfect").val();
		var Brgy = $("#BrgyValue").text();

		$.ajax({
			url : 'php/StatisticData.php',
			method : 'post',
			data : { Data : 'TotalActiveDevice', InfectiousDisease : InfectiousDisease, Brgy : Brgy},
			cache : false,
			success : function(data){
				$("#numberAD").html(data);
			}
		})
	}
	function totalAlertStatus() {
		var InfectiousDisease = $("#selectInfect").val();
		var Brgy = $("#BrgyValue").text();

		$.ajax({
			url : 'php/StatisticData.php',
			method : 'post',
			data : { Data : 'TotalAlert', InfectiousDisease : InfectiousDisease, Brgy : Brgy},
			cache : false,
			success : function(data){
				$("#numberAS").html(data);
			}
		})
	}
	function totalCaseToday() {
		var InfectiousDisease = $("#selectInfect").val();
		var Brgy = $("#BrgyValue").text();

		$.ajax({
			url : 'php/StatisticData.php',
			method : 'post',
			data : { Data : 'TotalCaseToday', InfectiousDisease : InfectiousDisease, Brgy : Brgy},
			cache : false,
			success : function(data){
				$("#numberCT").html(data);
			}
		})
	}
	function makeGraphChart() {
		let yearNow =  new Date().getFullYear();
		var InfectiousDisease = $("#selectInfect").val();
		var Brgy = $("#BrgyValue").text();


		$.ajax({
			url : 'php/StatisticData.php',
			method : 'post',
			data: {Data : 'FetchChartValue', InfectiousDisease : InfectiousDisease, Brgy : Brgy},
			cache : false,
			dataType : 'JSON',
			success:function(response) {
				$("#chart1").show();
				$("#chart-error").hide();
				let chartStatus = Chart.getChart("chart1");
				if (chartStatus != undefined) {
					chartStatus.destroy();
				}

				var ctx = document.getElementById('chart1').getContext('2d');

				new Chart(ctx, {
					type: 'line',
					data: {
						labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul','Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
						datasets: [{
							label: 'Total Cases',
							data: response,
							backgroundColor: '#8FB3DC',
							borderWidth: 5,
							fill: true,
							tension: 0.1,
						}]
					},
					options: {
						responsive : true,
						scales: {
							x: {
								display: true,
								title: {
								  display: true,
								  text: 'MONTH'
								}
							  },
							y: {
								display: true,
								title: {
									display: true,
									text: 'VALUE'
								},
								beginAtZero: true,
								suggestedMax : 20
							  }
						},
						plugins: {
							title: {
							  display: true,
							  text: 'NUMBERS OF ' + InfectiousDisease + ' CASE THIS ' + yearNow
							},
						  },
					}
				});
			},
			error:function () {
				$("#chart1").hide();
				$("#chart-error").show();
			}
		})
	}
	function populateCases(){
		$("#selectInfect").html("");
		$.ajax({
			url : 'php/StatisticData.php',
			method : 'post',
			data : { Data : 'PopulateCases'},
			cache : false,
			success : function(data){
				$("#selectInfect").html(data);
			}
		})
	}
	function totalCases() {
		var InfectiousDisease = $("#selectInfect").val();
		var Brgy = $("#BrgyValue").text();

		$.ajax({
			url : 'php/StatisticData.php',
			method : 'post',
			data : { Data : 'TotalCases', InfectiousDisease : InfectiousDisease, Brgy : Brgy},
			cache : false,
			success : function(data){
				$("#totalCases").html(data);
			}
		})
	}
	function totalRecovery() {
		var InfectiousDisease = $("#selectInfect").val();
		var Brgy = $("#BrgyValue").text();

		$.ajax({
			url : 'php/StatisticData.php',
			method : 'post',
			data : { Data : 'TotalRecoveries', InfectiousDisease : InfectiousDisease, Brgy : Brgy},
			cache : false,
			success : function(data){
				$("#totalRecovery").html(data);
			}
		})
	}
	function totalDecease() {
		var InfectiousDisease = $("#selectInfect").val();
		var Brgy = $("#BrgyValue").text();

		$.ajax({
			url : 'php/StatisticData.php',
			method : 'post',
			data : { Data : 'TotalDeceases', InfectiousDisease : InfectiousDisease, Brgy : Brgy},
			cache : false,
			success : function(data){
				$("#totalDecease").html(data);
			}
		})
	}
		
});