<?php 
$this->load->view('siswa/head');
?>

<!--tambahkan custom css disini-->

<?php
$this->load->view('siswa/topbar');
$this->load->view('siswa/sidebar');
?>

<!-- Content Header (Page header) -->


<!-- Main content -->
<section class="content">

    <div class="callout callout-info">
        <h4>Selamat Datang, <?= $this->session->userdata('nama'); ?> </h4>
    </div>
    <div class="box box-success box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">E-Fast</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <dl>
                <dd>
                    <ol>
                        <b>E-FAST (E-Formative Diagnostic Test) adalah platform tes online yang memungkinkan Anda untuk mengevaluasi dan memperdalam pemahaman tentang Gelombang Bunyi. Melalui serangkaian soal pilihan ganda dua tingkat, Anda bisa mengukur seberapa baik pemahaman terhadap materi-materi Gelombang Bunyi. Gunakan E-FAST dengan mudah dari browser web apa saja—seperti Google Chrome, Mozilla Firefox, atau Microsoft Edge—dan belajar lebih efektif kapan pun Anda mau!</b>
                    </ol>
                </dd>
            </dl>
        </div><!-- /.box-body -->
    </div>

    <div class="box box-success box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Petunjuk Pengisian Tes</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <dl>
                <dd>
                    <ol>
                        <li><b>Tes terdiri dari 15 butir soal pilihan ganda dua tingkat.</b></li>
                        <li><b>Tingkat pertama berupa pertanyaan dan tingkat kedua berupa alasan memilih jawaban pada tingkat pertama</b></li>
                        <li><b>Pilihlah salah satu jawaban yang Anda anggap paling tepat untuk tingkat pertama</b></li>
                        <li><b>Kemudian, pilihlah salah satu jawaban alasan yang Anda anggap paling tepat untuk tingkat kedua</b></li>
                        <li><b>Semua butir soal wajib dikerjakan</b></li>
                        <li><b>Apabila sudah yakin dan mengerjakan semua butir soal beserta alasannya, tekan tombol “submit”</b></li>
                        <li><b>Lihat hasil jawaban secara detail</b></li>
                    </ol>
                </dd>
            </dl>
        </div><!-- /.box-body -->
    </div>

</section><!-- /.content -->
  
<?php 
$this->load->view('siswa/js');
?>

<!--tambahkan custom js disini-->

<script type="text/javascript">
    $(function(){
        $('#data-tables').dataTable();
    });

    $('.alert-message').alert().delay(3000).slideUp('slow');
</script>

<?php
$this->load->view('admin/foot');
?>
