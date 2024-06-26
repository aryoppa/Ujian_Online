<?php
$this->load->view('ujian/head');
$this->load->view('ujian/topbar');
// $lewat = isset($_SESSION["waktu_start"]) ? time() - $_SESSION["waktu_start"] : $_SESSION["waktu_start"] = time();
?>

<!-- <style>
    #timer_place, #counter {
        text-align: center;
        margin: 0 auto;
    }
    #counter {
        border-radius: 7px;
        border: 2px solid gray;
        padding: 7px;
        font-size: 2em;
        font-weight: bolder;
    }
</style> -->

<section class="content">
  <div class="row">
    <!-- <div class="col-md-12">
        <div class="box box-success">
            <div class="box-header text-center">
              <h4 class="box-title">Waktu Anda</h4>
            </div>
            <div class="box-body" id="timer_place">
                <span id="counter"></span>
            </div>
        </div>
    </div> -->
    <div class="col-md-12">
        <div class="box-header with-border text-center">
           <h3 class="box-title">Soal Ujian</h3>
        </div>
        <div class="box-body" style="height: 100%; width: 100%;">
            <form id="formSoal" role="form" action="<?= base_url('ruang_ujian/jawab_aksi'); ?>" method="post" onsubmit="return confirm('Anda Yakin ?')">
            <input type="hidden" name="id_materi" value="<?= $id['id_materi']; ?>">    
            <input type="hidden" name="id_peserta" value="<?= $id['id_peserta']; ?>">
                <input type="hidden" name="jumlah_soal" value="<?= $total_soal; ?>">
                <?php foreach ($soal as $index => $s): ?>
                    <div class="form-group">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td width="1%"><?= $index + 1; ?>.</td>
                                    <td>
                                        <figure class="easyimage easyimage-full">
                                            <figcaption><?= $s->pertanyaan; ?></figcaption>
                                            <img src="<?= base_url('uploads/'.$s->image) ?>" alt="" width="300" />
                                        </figure>
                                        <input type='hidden' name='pertanyaan[]' value='<?= $s->id_soal_ujian; ?>' />
                                        <?php foreach (['a', 'b', 'c', 'd', 'e'] as $index => $option): ?>
                                            <input type="radio" name="jawaban[<?= $s->id_soal_ujian; ?>]" value="<?= $option; ?>" required /> <?= chr(65 + $index) . ". " . $s->$option; ?><br> <!-- Moved to a new line -->
                                        <?php endforeach; ?>
                                        <br>
                                        <?= "Alasan Menjawab:" ?>
                                        <br>
                                        <?php foreach (['alasan_1', 'alasan_2', 'alasan_3', 'alasan_4', 'alasan_5'] as $opsi): ?>
                                            <input type="radio" name="alasan[<?= $s->id_soal_ujian; ?>]" value="<?= $opsi; ?>" required /> <?= $s->$opsi; ?><br> <!-- Moved to a new line -->
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
                <button type="submit" class="btn btn-primary btn-flat pull-right">Simpan</button>
            </form>
        </div>
        
    </div>    
</div>
</section>

<?php
$this->load->view('ujian/js');
// $this->load->view('ujian/foot');
?>

<script type="text/javascript">
    function waktuHabis(){
        alert('Waktu Anda telah habis, Jawaban anda akan disimpan secara otomatis.');
        document.getElementById("formSoal").submit(); 
    }
    function hampirHabis(periods){
        if($.countdown.periodsToSeconds(periods) == 60){
            $("#counter").css({color:"red"});
        }
    }
    $(function(){
        var sisa_waktu = <?= $max_time; ?> - <?= $lewat; ?>;
        $("#counter").countdown({
            until: sisa_waktu,
            compact: true,
            onExpiry: waktuHabis,
            onTick: hampirHabis
        });
    });

    window.location.hash = "no-back-button";
    window.onhashchange = function(){ window.location.hash = "no-back-button"; }
</script>
