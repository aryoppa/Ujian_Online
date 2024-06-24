<?php
$this->load->view('admin/head');
?>

<!-- tambahkan custom css disini -->

<?php
$this->load->view('admin/topbar');
$this->load->view('admin/sidebar');
?>

<!DOCTYPE HTML>
<html>

<head>
	<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
	<script>
		window.onload = function() {
			var chartJawaban = new CanvasJS.Chart("chartContainerJawaban", {
				animationEnabled: true,
				backgroundColor: "#ecf0f5",
				title: {
					text: "JAWABAN",
					fontFamily: "Source Sans Pro, Helvetica Neue",
					fontWeight: 600,
					fontSize: 23
				},
				data: [{
					type: "pie",
					indexLabel: "{label} ({y})",
					dataPoints: <?php echo json_encode($dataPointsJawaban, JSON_NUMERIC_CHECK); ?>
				}]
			});

			var chartAlasan = new CanvasJS.Chart("chartContainerAlasan", {
				animationEnabled: true,
				backgroundColor: "#ecf0f5",
				title: {
					text: "ALASAN JAWABAN",
					fontFamily: "Source Sans Pro, Helvetica Neue",
					fontWeight: 600,
					fontSize: 23
				},
				data: [{
					type: "pie",
					indexLabel: "{label} ({y})",
					dataPoints: <?php echo json_encode($dataPointsAlasan, JSON_NUMERIC_CHECK); ?>
				}]
			});

			chartJawaban.render();
			chartAlasan.render();
		}
	</script>
</head>

<body>

	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1 style="padding: 10px; font-family: Source Sans Pro, Helvetica Neue; font-weight: 600; display: flex; align-items: center; gap: 10px;">
			<a href="javascript:history.back()" style="text-decoration: none; color: inherit; font-size: 25px;">
				<i class="fa fa-angle-left" aria-hidden="true"></i>
			</a>
			Distribusi Hasil Ujian
		</h1>
	</section>

	<!-- Main content -->
	<section class="content">
		<div style="display: flex; justify-content: space-between; padding: 50px;">
			<div id="chartContainerJawaban" style="height: 370px; width: 48%;"></div>
			<div id="chartContainerAlasan" style="height: 370px; width: 48%;"></div>
		</div>
	</section>

	<?php
	$this->load->view('admin/js');
	?>

	<!-- tambahkan custom js disini -->

	<script type="text/javascript">
		$(function() {
			$('#data-tables').dataTable();
		});

		$('.alert-message').alert().delay(3000).slideUp('slow');
	</script>

	<?php
	$this->load->view('admin/foot');
	?>
</body>

</html>
