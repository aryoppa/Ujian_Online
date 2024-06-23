<?php 
$this->load->view('siswa/head');
?>

<!--tambahkan custom css disini-->
<style>
    .dropdown-menu-left {
        right: 0;
        left: auto;
    }
</style>

<?php
$this->load->view('siswa/topbar');
$this->load->view('siswa/sidebar');
?>

<!-- Content Header (Page header) -->


<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            

            <!-- Default box -->
            <div class="box box-success" style="overflow-x: scroll;">
                <div class="box box-header" >
                    <center><h3 class="box-title">Hasil Ujian</h3></center>
                </div>
              <div class="box-body">
                <table id="data" class="table table-bordered table-striped">                    
                    <thead>
                        <tr>
                            <th width="1%">No</th>
                            <th> Pelajaran</th>                            
                            <th> Tanggal Ujian</th>                            
                            <th> Jam </th>                            
                            <th> Jawaban Benar</th>                            
                            <th> Alasan Benar</th>                            
                            <th> Nilai</th>
                            <th> Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no=1;
                        foreach($hasil as $d) { ?>
                            <tr>
                                <td><?php echo $no++; ?></td>                              
                                <td><?php echo $d->nama_materi; ?></td>                                
                                <td><?php echo date('d-m-Y',strtotime($d->tanggal_ujian)); ?></td>                               
                                <td><?php echo date('H:i:s',strtotime($d->jam_ujian)); ?></td>                                
                                <td>
                                    <?php
                                    if($d->jawaban_benar == ''){
                                        echo "<span class='btn btn-xs btn-warning'>Belum Ujian</span>";
                                    }else {
                                        echo $d->jawaban_benar;
                                    }
                                    ?>
                                </td>                                
                                <td>
                                    <?php
                                    if($d->alasan_benar == ''){
                                        echo "<span class='btn btn-xs btn-warning'>Belum Ujian</span>";
                                    }else {
                                        echo $d->alasan_benar;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if($d->nilai == ''){
                                        echo "<span class='btn btn-xs btn-warning'>Belum Ujian</span>";
                                    }else {
                                        echo $d->nilai;
                                    }
                                    ?>
                                </td>
                                <td>
									<?php
                                    if ($d->nilai == '') {
										echo "<span class='btn btn-xs btn-warning'>Belum Ujian</span>";
									} else {
										echo '<div class="btn-group">
												<button type="button" class="btn btn-success btn-flat btn-xs">Detail</button>
												<button type="button" class="btn btn-success btn-xs btn-flat dropdown-toggle" data-toggle="dropdown">
													<span class="caret"></span>
													<span class="sr-only">Toggle Dropdown</span>
												</button>
												<ul class="dropdown-menu dropdown-menu-left" role="menu">
													<li><a href="' . base_url('ruang_hasil/detail/') . $d->id_peserta . '">Distribusi Jawaban dan Alasan</a></li>
													<li><a href="' . base_url('ruang_hasil/pembahasan/') . $d->id_peserta . '">Pembahasan Soal</a></li>
												</ul>
											  </div>';
									}
									?>
									
									
                                </td>
                            </tr>
                        <?php } ?>                  
                    </tbody> 
                </table>
            </div>
        </div>
        <!-- /.col-->
</div>
<!-- ./row -->
</section><!-- /.content -->

<?php 
$this->load->view('siswa/js');
?>

<!--tambahkan custom js disini-->

<script type="text/javascript">

	$(function(){
		$('#data').dataTable();
	});

	$('.alert-message').alert().delay(3000).slideUp('slow');

</script>

<?php
$this->load->view('siswa/foot');
?>

