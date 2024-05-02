<?php
	try {
		$host = 'localhost';
		$dbname = 'db_iot';
		$username = 'root';
		$password = '';

		$dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

		/* ====== Jumlah Data Terbesar dalam Field ====== */
		$tableName = 'station1';
		$queryHighData = "SELECT * FROM $tableName WHERE (temp) = (SELECT MAX(temp) FROM $tableName)";
		$stmt = $dbh->prepare($queryHighData);
		$stmt->execute();

		$HighestData = $stmt->rowCount();
		/* ====== Jumlah Data Terbesar dalam Field ====== */


		/* ====== Jumlah Data ====== */
		$queryData = "SELECT COUNT(*) as jumlah FROM $tableName";
		$stmt = $dbh->prepare($queryData);
		$stmt->execute();

		$resultData = $stmt->fetch(PDO::FETCH_ASSOC);
		/* ====== Jumlah Data ====== */


		/* ====== Tanggal Update Data ====== */
		$queryDate = "SELECT DATE_FORMAT(MAX(created_at), '%Y-%m-%d') as tanggal_terbaru, COUNT(*) as jumlah_data 
		FROM $tableName 
		WHERE created_at IS NOT NULL";
		$stmt = $dbh->prepare($queryDate);
		$stmt->execute();

		$resultDate = $stmt->fetch(PDO::FETCH_ASSOC);
		/* ====== Tanggal Update Data ====== */


		/* ====== Waktu Update Data ====== */
		$queryTime = "SELECT DATE_FORMAT(MAX(created_at), '%H:%i:%S') as waktu_terbaru, COUNT(*) as jumlah_data 
		FROM $tableName 
		WHERE created_at IS NOT NULL";
		$stmt = $dbh->prepare($queryTime);
		$stmt->execute();

		$resultTime = $stmt->fetch(PDO::FETCH_ASSOC);
		/* ====== Waktu Update Data ====== */

		$dbh = null;
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Dashboard</title>
	<link rel="icon" type="image/png" href="../data/images/icons/favicon.ico"/>

	<!-- Custom fonts -->
	<!-- <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> -->

	<!-- Custom styles -->
	<link href="css/app.css" rel="stylesheet">

	<!-- Custom styles for this page -->
  	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="index.php">
					<span class="align-middle">Enigma</span>
				</a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						Admin
					</li>

					<li class="sidebar-item active">
						<a class="sidebar-link" href="index.php">
							<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
						</a>
					</li>

					

					<li class="sidebar-header">
						Activity Log
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="activityLog.php">
							<i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle">Log Data</span>
						</a>
					</li>

				</ul>
				
			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle d-flex">
					<i class="hamburger align-self-center"></i>
				</a>


				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-toggle="dropdown">
								<i class="align-middle" data-feather="settings"></i>
							</a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="dropdown">
								<img src="../data/images/admin.jpg" class="avatar img-fluid rounded-circle" /> <span class="text-dark">Admin</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="#"><i class="align-middle mr-1" data-feather="user"></i> Profile</a>
								<a class="dropdown-item" href="#"><i class="align-middle mr-1" data-feather="pie-chart"></i> Analytics</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#"><i class="align-middle mr-1" data-feather="settings"></i> Settings </a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i class="align-middle mr-1" data-feather="log-out"></i>Log out</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>

			<main class="content">
				<div class="container-fluid p-0">

					<div class="row mb-2 mb-xl-3">
						<div class="col-auto d-none d-sm-block">
							<h3><strong>Analytics</strong> Dashboard</h3>
						</div>
					</div>
					<div class="row">
						<div class="col-xl-6 col-xxl-5 d-flex">
							<div class="w-100">
								<div class="row">
									<div class="col-sm-6">
										<div class="card">
											<div class="card-body">
												<h5 class="card-title mb-4">Highest Data on <strong>Temperature</strong> </h5>
												<h1 class="mt-1 mb-3"><?php echo $HighestData ?></h1>
												<div class="mb-1">
													<span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> Data Value </span>
													<span class="text-muted"> Ini data </span>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-body">
												<h5 class="card-title mb-4">Amount of Data</h5>
												<h1 class="mt-1 mb-3"><?php echo $resultData['jumlah'] ?></h1>
												<div class="mb-1">
													<span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> Data Value </span>
													<span class="text-muted"> Ini data </span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="card">
											<div class="card-body">
												<h5 class="card-title mb-4">Data Update Date</h5>
												<h1 class="mt-1 mb-3"><?php echo $resultDate['tanggal_terbaru'] ?></h1>
												<div class="mb-1">
													<span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> Data Value </span>
													<span class="text-muted"> Ini data </span>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-body">
												<h5 class="card-title mb-4">Data Update Time</h5>
												<h1 class="mt-1 mb-3"><?php echo $resultTime['waktu_terbaru'] ?></h1>
												<div class="mb-1">
													<span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> Data Value </span>
													<span class="text-muted"> Ini data </span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xl-6 col-xxl-7">
							<div class="card flex-fill w-100">
								<div class="card-header">
									<h5 class="card-title mb-0">Chart Presentation</h5>
								</div>
								<div class="card-body py-3">
									<div class="chart chart-sm">
										<canvas id="myAllAreaChart"></canvas>
									</div>
								</div>
							</div>
						</div>

						<!-- <div class="col-xl-6 col-xxl-7">
							<div class="card flex-fill w-100">
								<div class="card-header">
									<h5 class="card-title mb-0">Chart Presentation</h5>
								</div>
								<div class="card-body py-3">
									<div class="chart chart-sm">
										<canvas id="myAreaChartJarak"></canvas>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xl-6 col-xxl-7">
							<div class="card flex-fill w-100">
								<div class="card-header">
									<h5 class="card-title mb-0">Chart Presentation</h5>
								</div>
								<div class="card-body py-3">
									<div class="chart chart-sm">
										<canvas id="myAreaChartPompa"></canvas>
									</div>
								</div>
							</div>
						</div>

						<div class="col-12 col-md-6 col-lg-5">
							<div class="card flex-fill w-100">
								<img class="card-img-top" src="../data/images/unsplash.jpg" alt="Unsplash">
								<div class="card-header">
									<h5 class="card-title mb-0">Ini foto</h5>
								</div>
							</div>
						</div> -->

					</div>

					<div class="row">
						<div class="col-xl-6 col-xxl-6 d-flex order-1 order-xxl-2">
							<div class="card flex-fill w-100">
								<div class="card-header">
									<h5 class="card-title mb-0">Percent Chart Presentation</h5>
								</div>
								<div class="card-body py-3">
									<div class="chart chart-sm">
										<canvas id="myAreaChartAllPerc"></canvas>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xl-6 col-xxl-6 d-flex order-1 order-xxl-1">
							<div class="card flex-fill w-100">
								<div class="card-header">
									<h5 class="card-title mb-0">Difference Chart Presentation</h5>
								</div>
								<div class="card-body py-3">
									<div class="chart chart-sm">
										<canvas id="myAreaChartAllDiff"></canvas>
									</div>
								</div>
							</div>
						</div>
						

						<!-- <div class="col-12 col-md-6 col-xxl-3 d-flex order-1 order-xxl-1">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Chart Presentation</h5>
								</div>
								<div class="card-body d-flex w-100">
									<div class="align-self-center chart chart-lg">
										<canvas id="chartjs-dashboard-bar"></canvas>
									</div>
								</div>
							</div>
						</div>

						<div class="col-12 col-md-6 col-xxl-3 d-flex order-2 order-xxl-3">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Browser Usage</h5>
								</div>
								<div class="card-body d-flex">
									<div class="align-self-center w-100">
										<div class="py-3">
											<div class="chart chart-xs">
												<canvas id="chartjs-dashboard-pie"></canvas>
											</div>
										</div>

										<table class="table mb-0">
											<tbody>
												<tr>
													<td>Chrome</td>
													<td class="text-right">4306</td>
												</tr>
												<tr>
													<td>Firefox</td>
													<td class="text-right">3801</td>
												</tr>
												<tr>
													<td>IE</td>
													<td class="text-right">1689</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

						<div class="col-12 col-md-12 col-xxl-6 d-flex order-3 order-xxl-2">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">World Map</h5>
								</div>
								<div class="card-body px-4">
									<div id="world_map" style="height:350px;"></div>
								</div>
							</div>
						</div> -->


					</div>

					<!-- DataTable's -->
					<div class="row">
						<!-- <div class="col-12"> --> <!-- Responsive -->
						<div class="col-12 col-lg-8 col-xxl-9 d-flex"> <!-- slot for calendar -->
							<div class="card flex-fill shadow mb-4">
								<div class="card-header py-3">
									<h5 class="card-title mb-0">Real-Time Data</h5>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
											<thead>
												<tr>
													<th>ID</th>
													<th>Data Created</th>
													<th>Temp</th>
													<th>Temp Diff</th>
													<th>Percent Temp</th>
													<th>Humidity</th>
													<th>Hum Diff</th>
													<th>Percent Hum</th>
													<!-- <th>Action</th> -->
												</tr>
											</thead>
										</table>
									</div>
								</div>
							</div>
						</div>

						<div class="col-12 col-lg-4 col-xxl-3 d-flex">
							<div class="card flex-fill">
								<div class="card-header">

									<h5 class="card-title mb-0">Calendar</h5>
								</div>
								<div class="card-body d-flex">
									<div class="align-self-center w-100">
										<div class="chart">
											<div id="datetimepicker-dashboard"></div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>

				</div>
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-left">
							<p class="mb-0">
								<a href="index.php" class="text-muted"><strong>Copyright &copy; Nugroho Eko S Batubara</a> - <?= date("Y"); ?></strong></a>
							</p>
						</div>
					</div>
				</div>
			</footer>

		</div>
	</div>


	<!-- Logout Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
					<a class="btn btn-primary" href="../index.php">Logout</a>
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap core JavaScript-->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- Core plugin JavaScript-->
	<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

	<!-- Custom scripts for all pages-->
	<script src="js/sb-admin-2.min.js"></script>
	<script src="js/app.js"></script>

	<!-- Page level plugins -->
	<script src="vendor/datatables/jquery.dataTables.min.js"></script>
	<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
  
  	<!-- Page level plugins -->
  	<script src="vendor/chart.js/Chart.min.js"></script>
  	<script src="vendor/jquery/moment.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			var table = $('#dataTable').DataTable( {
				ajax: {
					url: 'http://localhost/iot/webapi/api/read.php',
					dataSrc: 'data_log'
				}, 
				columns: [
					{ data: null},
					{ data: 'created_at' },
					{ data: 'temp' },
					{ data: 'difftemp' },
					{ data: 'perctemp' },
					{ data: 'hum' },
					{ data: 'diffhum' },
					{ data: 'perchum' }
					/*{
						data: null,
						defaultContent: '<button type="button" class="btn btn-outline-secondary btn-sm edit"><i class="fas fa-pen"></i></button>	&nbsp;	<button type="button" class="btn btn-outline-danger btn-sm delete"><i class="fas fa-trash"></i></button>'
					}*/

					/*{ defaultContent: '<button type="button" name="edit" id="1" class="btn btn-success btn-sm edit"><span class="fa fa-edit"></span> Edit</button>&nbsp;<button type="button" name="delete" id="1" class="btn btn-danger btn-sm delete"><span class="fa fa-trash"></span> Delete</button>'}*/
					],
				columnDefs: [ {
					searchable: false,
					orderable: false,
					targets: 0
				} ],
				columnDefs: [
            		{
		                targets: 4, // Kolom 'perctemp'
		                render: function(data, type, row, meta) {
		                    return data + '%';
		                }
            		},
            		{
		                targets: 7, // Kolom 'perchum'
		                render: function(data, type, row, meta) {
		                    return data + '%';
		                }
		            }
		        ],
				order: [[ 1, 'asc' ]]
			} );	
			table.on( 'order.dt search.dt', function () {
				table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
					cell.innerHTML = i+1;
				} );
			} ).draw();

			/* Edit and Delete Data Table */
			/*$('#dataTable tbody').on('click', '.edit', function () {
				var data = table.row($(this).parents('tr')).data();
            	// Implement your edit logic here
				alert('Edit clicked for ID: ' + data.id);
			});

			$('#dataTable tbody').on('click', '.delete', function () {
				var data = table.row($(this).parents('tr')).data();
            	// Implement your delete logic here
				alert('Delete clicked for ID: ' + data.id);
			});*/

			//renderDataTable()
			getChartData();	
			setInterval( function () {
				table.ajax.reload();
			}, 60000 );

			setInterval(getChartData,60000);
			
		} );


		function renderChart1(data, labels) {
			var ctx = document.getElementById("myAllAreaChart").getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: labels,
					datasets: [
					{
						label: 'Temperature',
						data: data[0],
						borderColor: 'rgba(61, 204, 249, 1)',
						backgroundColor: 'rgba(56, 221, 244, 0.2)',
					},
					{
						label: 'Humidity',
						data: data[1],
						borderColor: 'rgba(89, 223, 172, 1)',
						backgroundColor: 'rgba(192, 255, 209, 0.2)',
					}
					]
				},
				options: {
					maintainAspectRatio: false,
					
					tooltips: {
						intersect: false
					},
					hover: {
						intersect: true
					},
					plugins: {
						filler: {
							propagate: false
						}
					},
					scales: {
						xAxes: [{
							reverse: true,
							gridLines: {
								color: "rgba(0,0,0,0.05)"
							}
						}],
						yAxes: [{
							ticks: {
								suggestedMin: 15,
								suggestedMax: 50
							},
							display: true,
							borderDash: [5, 5],
							gridLines: {
								color: "rgba(0,0,0,0)",
								fontColor: "#fff"
							}
						}]
					}
				}
			});
		}

		function renderChart2(data, labels) {
			var ctx = document.getElementById("myAreaChartAllDiff").getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: labels,
					datasets: [
					{
						label: 'Temperature',
						data: data[2],
						borderColor: 'rgba(61, 204, 249, 1)',
						backgroundColor: 'rgba(56, 221, 244, 0.2)',
					},
					{
						label: 'Humidity',
						data: data[3],
						borderColor: 'rgba(89, 223, 172, 1)',
						backgroundColor: 'rgba(192, 255, 209, 0.2)',
					}
					]
				},
				options: {
					maintainAspectRatio: false,
					
					tooltips: {
						intersect: false
					},
					hover: {
						intersect: true
					},
					plugins: {
						filler: {
							propagate: false
						}
					},
					scales: {
						xAxes: [{
							reverse: true,
							gridLines: {
								color: "rgba(0,0,0,0.05)"
							}
						}],
						yAxes: [{
							ticks: {
								suggestedMin: -1,
								suggestedMax: 1
							},
							display: true,
							borderDash: [5, 5],
							gridLines: {
								color: "rgba(0,0,0,0)",
								fontColor: "#fff"
							}
						}]
					}
				}
			});
		}

		function renderChart3(data, labels) {
			var ctx = document.getElementById("myAreaChartAllPerc").getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: labels,
					datasets: [
					{
						label: 'Temperature',
						data: data[4],
						borderColor: 'rgba(61, 204, 249, 1)',
						backgroundColor: 'rgba(56, 221, 244, 0.2)',
					},
					{
						label: 'Humidity',
						data: data[5],
						borderColor: 'rgba(89, 223, 172, 1)',
						backgroundColor: 'rgba(192, 255, 209, 0.2)',
					}
					]
				},
				options: {
					maintainAspectRatio: false,
					
					tooltips: {
						intersect: false
					},
					hover: {
						intersect: true
					},
					plugins: {
						filler: {
							propagate: false
						}
					},
					scales: {
						xAxes: [{
							reverse: true,
							gridLines: {
								color: "rgba(0,0,0,0.05)"
							}
						}],
						yAxes: [{
							ticks: {
								suggestedMin: -1,
								suggestedMax: 1
							},
							display: true,
							borderDash: [5, 5],
							gridLines: {
								color: "rgba(0,0,0,0)",
								fontColor: "#fff"
							}
						}]
					}
				}
			});
		}

		/*function renderChart2(data, labels) {
			var ctx = document.getElementById("myAreaChartPompa").getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: labels,
					datasets: [
					{
						label: 'Pompa',
						data: data[1],
						borderColor: 'rgba(89, 223, 172, 1)',
						backgroundColor: 'rgba(192, 255, 209, 0.2)',
					}
					]
				},
				options: {
					maintainAspectRatio: false,
					
					tooltips: {
						intersect: false
					},
					hover: {
						intersect: true
					},
					plugins: {
						filler: {
							propagate: false
						}
					},
					scales: {
						xAxes: [{
							reverse: true,
							gridLines: {
								color: "rgba(0,0,0,0.05)"
							}
						}],
						yAxes: [{
							ticks: {
								suggestedMin: 5,
								suggestedMax: 10
							},
							display: true,
							borderDash: [5, 5],
							gridLines: {
								color: "rgba(0,0,0,0)",
								fontColor: "#fff"
							}
						}]
					}
				}
			});
		}*/

		/*function renderChartBar(data, labels) {
			var ctx = document.getElementById("chartjs-dashboard-bar").getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: labels,
					datasets: [
					{
						label: 'Luas',
						data: data[2],
						borderColor: 'rgba(60, 110, 198, 1)',
						backgroundColor: 'rgba(60, 110, 198, 1)',
					}
					]
				},
				options: {
					maintainAspectRatio: false,
					
					tooltips: {
						intersect: false
					},
					hover: {
						intersect: true
					},
					plugins: {
						filler: {
							propagate: false
						}
					},
					scales: {
						xAxes: [{
							reverse: true,
							gridLines: {
								color: "rgba(0,0,0,0.05)"
							}
						}],
						yAxes: [{
							ticks: {
								suggestedMin: 20,
								suggestedMax: 80
							},
							display: true,
							borderDash: [5, 5],
							gridLines: {
								color: "rgba(0,0,0,0)",
								fontColor: "#fff"
							}
						}]
					}
				}
			});
		}

		function renderChartPie() {

		}*/



		function getChartData() {
			$.ajax({
				url: "http://localhost/iot/webapi/api/read.php",
				method: "GET",
				dataType: 'JSON',
				success: function (result) {
					var labels = result.data_log.map(function(e) {
						var a = moment(e.created_at).format('HH:mm');
				   		//return e.created_at;
						return a;
					});
					var data1 = result.data_log.map(function(e) {
						return e.temp;
					});
					var data2 = result.data_log.map(function(e) {
						return e.hum;
					});
					var data3 = result.data_log.map(function(e) {
						return e.difftemp;
					});
					var data4 = result.data_log.map(function(e) {
						return e.diffhum;
					});
					var data5 = result.data_log.map(function(e) {
						return e.perctemp;
					});
					var data6 = result.data_log.map(function(e) {
						return e.perchum;
					});
					var data=[];
					data[0]=data1;
					data[1]=data2;
					data[2]=data3;
					data[3]=data4;
					data[4]=data5;
					data[5]=data6;
					//console.log(result);		
					renderChart1(data, labels); // Gabungan Jarak, Pompa
					renderChart2(data, labels); // Gabungan Diff Temp dan Hum
					renderChart3(data, labels); // Gabungan Percent Temp dan Hum
					//renderChartPie(data, labels); // Chart panjang, tinggi, luas
				},
				error: function (err) {
					console.log('Get data Error', err);
				}
			});
		}

		function float2dollar(value) {
			return "U$ " + (value).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
		}


		/* Calendar */
		document.addEventListener("DOMContentLoaded", function() {
			document.getElementById("datetimepicker-dashboard").flatpickr({
				inline: true,
				prevArrow: "<span class=\"fas fa-chevron-left\" title=\"Previous month\"></span>",
				nextArrow: "<span class=\"fas fa-chevron-right\" title=\"Next month\"></span>",
			});
		});
	</script>
	<!-- <script>
		document.addEventListener("DOMContentLoaded", function() {
			// Pie chart
			new Chart(document.getElementById("chartjs-dashboard-pie"), {
				type: "pie",
				data: {
					labels: ["Chrome", "Firefox", "IE"],
					datasets: [{
						label: ['Chrome', 'Firefox', 'IE'],
						data: [4306, 3801, 1689],
						backgroundColor: [
							window.theme.primary,
							window.theme.warning,
							window.theme.danger
							],
						borderWidth: 5
					}]
				},
				options: {
					responsive: !window.MSInputMethodContext,
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					cutoutPercentage: 75
				}
			});
		});
	</script> -->
	<!-- <script>
		document.addEventListener("DOMContentLoaded", function() {
			var markers = [{
				coords: [-6.175110, 106.865036],
				name: "Jakarta"
			},
			{
				coords: [35.689487, 139.691711],
				name: "Tokyo"
			}
			];
			var map = new JsVectorMap({
				map: "world",
				selector: "#world_map",
				zoomButtons: true,
				markers: markers,
				markerStyle: {
					initial: {
						r: 9,
						strokeWidth: 7,
						stokeOpacity: .4,
						fill: window.theme.primary
					},
					hover: {
						fill: window.theme.primary,
						stroke: window.theme.primary
					}
				}
			});
			window.addEventListener("resize", () => {
				map.updateSize();
			});
		});
	</script> -->
	
		
</body>
</html>