<?php
	try {
		$host = 'localhost';
		$dbname = 'db_iot';
		$username = 'root';
		$password = '';

		$dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

		/* ====== GET ALL DATA ====== */
		$tableName = 'station1';
		$stmt = $dbh->prepare("SELECT * FROM $tableName");
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		/* ====== GET ALL DATA ====== */

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

	<title>Activity Log</title>
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

					<li class="sidebar-item">
						<a class="sidebar-link" href="index.php">
							<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
						</a>
					</li>

					

					<li class="sidebar-header">
						Activity Log
					</li>

					<li class="sidebar-item active">
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
							<h3><strong>Log Data</strong> Dashboard</h3>
						</div>
					</div>
					<div class="row">
						<!-- DataTales Example -->
						<div class="card shadow mb-4">
							<div class="card-header py-3 d-flex justify-content-between align-items-center">
								<h5 class="card-title mb-0">Log Data</h5>
								<div class="ml-auto">
									<button class="btn btn-outline-secondary mr-2" onclick="exportToExcel()">Export to Excel</button>
									<button class="btn btn-outline-secondary" onclick="exportToJSON()">Export to JSON</button>
								</div>
							</div>
							
							
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
										<thead>
											<tr>
												<th>ID</th>
												<th>Data Created</th>
												<th>Temperature</th>
												<th>Temperature Difference</th>
												<th>Percent Temperature</th>
												<th>Humidity</th>
												<th>Humidity Difference</th>
												<th>Percent Humidity</th>
											</tr>
										</thead>
										<tbody>
											<?php
												foreach ($result as $row) {
													echo "<tr>";
													echo "<td>{$row['id']}</td>";
													echo "<td>{$row['created_at']}</td>";
													echo "<td>{$row['temp']}</td>";
													if ($row['difftemp'] < 0) {
												        echo "<td style='color: red;'>{$row['difftemp']}</td>";
												    } else {
												        echo "<td style='color: green;'>{$row['difftemp']}</td>";
												    }
												    echo "<td>{$row['perctemp']}%</td>";
												    echo "<td>{$row['hum']}</td>";
												    
												    if ($row['diffhum'] < 0) {
												        echo "<td style='color: red;'>{$row['diffhum']}</td>";
												    } else {
												        echo "<td style='color: green;'>{$row['diffhum']}</td>";
												    }
													echo "<td>{$row['perchum']}%</td>";
													echo "</tr>";
												}
											?>
										</tbody>
									</table>
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

  	<!-- Export to Excel And JSON JavaScript -->
  	<script src="vendor/xlsx/xlsx.full.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
  	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script> -->
  	
  	<script>
    // Initialize DataTable
  		$(document).ready(function () {
  			$('#dataTable').DataTable({
  				"lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
  				"searching": true
  			});
  		});
  	</script>
  	<script>
    	// Function to Export Data to Excel
  		function exportToExcel(allData = false) {
  			let table = document.getElementById("dataTable");
  			let ws = XLSX.utils.table_to_sheet(table);
  			let wb = XLSX.utils.book_new();
  			if (!allData) {
        		// Export only displayed rows if allData is false
  				let displayedRows = $('#dataTable').DataTable().rows({ search: 'applied' }).data().toArray();
  				ws = XLSX.utils.json_to_sheet(displayedRows, { skipHeader: true });
  			}
  			XLSX.utils.book_append_sheet(wb, ws, "Log Data");
  			let wbout = XLSX.write(wb, { bookType: "xlsx", type: "array" });
  			saveAs(new Blob([wbout], { type: "application/octet-stream" }), "log_data.xlsx");
  		}

		// Function to Export Data to JSON
  		function exportToJSON(allData = false) {
  			let table = document.getElementById("dataTable");
  			let data = [];
  			let headers = [];
  			let rowsToExport = table.rows;
  			if (!allData) {
        		// Export only displayed rows if allData is false
  				rowsToExport = $('#dataTable').DataTable().rows({ search: 'applied' }).nodes();
  			}
  			for (let i = 0; i < rowsToExport.length; i++) {
  				let row = {};
  				for (let j = 0; j < rowsToExport[i].cells.length; j++) {
  					if (i === 0) {
                		// Collect table headers
  						headers[j] = rowsToExport[i].cells[j].textContent.trim();
  					} else {
  						row[headers[j]] = rowsToExport[i].cells[j].textContent.trim();
  					}
  				}
  				if (i !== 0) {
  					data.push(row);
  				}
  			}
  			let jsonData = JSON.stringify(data, null, 2);
  			let blob = new Blob([jsonData], { type: "application/json;charset=utf-8" });
  			saveAs(blob, "log_data.json");
  		}
  	</script>

</body>
</html>