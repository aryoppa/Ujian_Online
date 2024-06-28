<?php
$this->load->view('siswa/head');
$this->load->view('siswa/topbar');
$this->load->view('siswa/sidebar');
?>

<!DOCTYPE HTML>
<html>
<head>
    <style>
        .panel-heading {
            background-color: #fff;
            border-radius: 10px;
        }
        #chartContainerSkor {
            margin: auto;
            height: 370px;
            width: 100%;
			padding: 20px;
        }
        .value-box {
            position: absolute;
            top: 0;
            right: 0;
            border-radius: 5px;
            font-family: 'Source Sans Pro', Helvetica Neue;
            font-weight: 600;
        }
		.badge {
			font-size: 0.7em;
			padding: 10px;
			margin-left: 5px;
			background-color: #009688;
		}
    </style>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script>
        window.onload = function() {
            var totalQuestions = 15;

            var dataPointsSkor = <?php echo json_encode($dataPointsSkor, JSON_NUMERIC_CHECK); ?>;
            dataPointsSkor.forEach(function(point) {
                point.y = Math.round((point.y / totalQuestions) * 100);
                point.indexLabel = point.label + " (" + point.y + "%)";
            });

            var chartSkor = new CanvasJS.Chart("chartContainerSkor", {
                animationEnabled: true,
                backgroundColor: "#ecf0f5",
                title: {
                    text: "PERSENTASE PROFIL KONSEPSI",
                    fontFamily: "Source Sans Pro, Helvetica Neue",
                    fontWeight: 600,
                    fontSize: 23
                },
                data: [{
                    type: "pie",
                    indexLabel: "{indexLabel}",
                    dataPoints: dataPointsSkor
                }]
            });

            chartSkor.render();
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
            Rekapitulasi Jawaban
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div style="padding: 20px;" class="panel-heading">
            <table id="data-tables" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Konsep</th>
                        <th>Indikator Pencapaian Kompetensi</th>
                        <th>Jawaban</th>
                        <th>Alasan</th>
                        <th>Profil konsepsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rekap as $index => $row) : ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $row->Konsep; ?></td>
                            <td><?php echo $row->IPK; ?></td>
                            <td><?php echo $row->Jawaban; ?></td>
                            <td><?php echo $row->Alasan; ?></td>
                            <td><?php echo $row->Profil_Konsepsi; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div style="padding: 50px; position: relative;">
            <div class="value-box">
				<h3 style="font-weight: 550; font-size: 20px">Nilai Anda: <span class="badge badge-success"	style="font-size: 16px"><?= $nilai; ?></span></h3>
            </div>
            <div id="chartContainerSkor"></div>
        </div>
    </section>

    <?php
    $this->load->view('siswa/js');
    ?>

    <!-- tambahkan custom js disini -->
    <script type="text/javascript">
        $(function() {
            $('#data-tables').dataTable();
        });

        $('.alert-message').alert().delay(3000).slideUp('slow');
    </script>

    <?php
    $this->load->view('siswa/foot');
    ?>
</body>
</html>
