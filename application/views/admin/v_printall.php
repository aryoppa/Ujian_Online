<!DOCTYPE html>
<html>
<head>
    <title>Cetak Hasil Ujian</title>
    <style>
        .container {
            width: 100%;
            margin: auto;
            padding: 20px;
        }
        .content-wrapper {
            page-break-after: always;
        }
        .header {
            text-align: center;
            font-size: 14px;
        }
        .header b {
            font-size: 16px;
        }
        .student-info {
            margin: 20px 0;
            width: 100%;
            text-align: left;
        }
        .student-info div {
            margin-bottom: 10px;
            font-size: 14px;
        }
        .student-info .label {
            display: inline-block;
            width: 100px;
            font-weight: bold;
        }
        .content-header h3 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th {
            background-color: #D3D3D3;
            font-size: 14px;
        }
        td {
            font-size: 12px;
            text-align: center;
            padding: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        foreach ($cetak as $nama_siswa => $jawaban_list) {
        ?>
        <div class="content-wrapper">
            <img src="image/logo1.png" style="width: 65px; height: auto; position: absolute;">

            <div class="header">
                <span>KEMENTRIAN AGAMA REPUBLIK INDONESIA <br> <b>MADRASAH TSANAWIYAH NEGERI</b> <br> JL. Ratukalinyamat, Gg. II Melati, Kecamatan Tayu, Kabupaten Pati</span>
                <hr>
            </div>

            <section class="content-header">
                <h3>Laporan Hasil Ujian</h3>
            </section>

            <div class="student-info">
                <div>
                    <span class="label">Nama Siswa</span>
                    <span>: <?php echo $nama_siswa; ?></span>
                </div>
                <div>
                    <span class="label">NIS</span>
                    <span>: <?php echo $jawaban_list[0]['nis']; ?></span>
                </div>
            </div>

            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <table>
                            <thead align="center" style="background-color:#D3D3D3">
                                <tr>
                                    <th>No</th>
                                    <th>Konsep</th>
                                    <th>Indikator Pencapaian Kompetensi</th>
                                    <th>Jawaban</th>
                                    <th>Alasan</th>
                                    <th>Profil Konsepsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($jawaban_list as $d) {
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $d['Konsep']; ?></td>
                                    <td><?php echo $d['IPK']; ?></td>
                                    <td><?php echo $d['Jawaban']; ?></td>
                                    <td><?php echo $d['Alasan']; ?></td>
                                    <td><?php echo $d['Profil_Konsepsi']; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <div class="footer">
                <?php 
                $date = date("d/m/Y");
                $time = date("H:i:s");
                echo "Laporan dicetak pada tanggal $date Jam $time"; 
                ?>
            </div>
        </div>
        <?php } ?>
    </div>

    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>
