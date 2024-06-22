<?php
$this->load->view('siswa/head');
?>

<!-- tambahkan custom css disini -->

<?php
$this->load->view('siswa/topbar');
$this->load->view('siswa/sidebar');
?>

<!DOCTYPE HTML>
<html>
<head>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script>
window.onload = function() {
    var chartJawaban = new CanvasJS.Chart("chartContainerJawaban", {
        animationEnabled: true,
        title: {
            text: "Distribusi Jawaban"
        },
        data: [{
            type: "pie",
            indexLabel: "{label} ({y})",
            dataPoints: <?php echo json_encode($dataPointsJawaban, JSON_NUMERIC_CHECK); ?>
        }]
    });

    var chartAlasan = new CanvasJS.Chart("chartContainerAlasan", {
        animationEnabled: true,
        title: {
            text: "Distribusi Alasan Jawaban"
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
    <h1>
        Detail Hasil Ujian
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div style="display: flex; justify-content: space-between;">
        <div id="chartContainerJawaban" style="height: 370px; width: 48%;"></div>
        <div id="chartContainerAlasan" style="height: 370px; width: 48%;"></div>
    </div>
	<br/>
    <div>
		<a href="<?= base_url('detail_ujian/hasil/') . $id_peserta; ?>" class='btn btn-success'>Lihat Hasil</a>
	</div>
</section>

<?php 
$this->load->view('siswa/js');
?>

<!-- tambahkan custom js disini -->

<script type="text/javascript">
    $(function(){
        $('#data-tables').dataTable();
    });

    $('.alert-message').alert().delay(3000).slideUp('slow');
</script>

<?php
$this->load->view('admin/foot');
?>
</body>
</html>
