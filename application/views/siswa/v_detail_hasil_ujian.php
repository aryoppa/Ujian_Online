<?php
$this->load->view('siswa/head');
$this->load->view('siswa/topbar');
$this->load->view('siswa/sidebar');
?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header text-center">
                    <h4 class="box-title">Hasil Ujian Anda</h4>
                </div>
                <div class="box-body">
                    <h3>Nilai Anda: <?= $nilai; ?></h3>
                    <h4>Jawaban Benar: <?= $jawaban_benar; ?></h4>
                    <h4>Alasan Benar: <?= $alasan_benar; ?></h4>
                    <hr>
                    <h4>Detail Jawaban:</h4>
                    <?php $no = 1; ?>
                    <?php foreach ($jawaban as $j): ?>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <p><strong><?= $no; ?>. Pertanyaan:</strong> <?= $j->pertanyaan; ?></p>
                                <p><strong>Jawaban Anda:</strong> 
                                    <div style="display: flex; align-items: start; gap: 10px;">
                                        <div>
                                            <?= $j->jawaban; ?>.
                                        </div>
                                        <div>
                                            <?= $j->jawaban_text; ?>
                                            <?php if ($j->jawaban_text == $j->kunci_jawaban_text): ?>
                                                <span style="color: green;">(Benar)</span>
                                            <?php else: ?>
                                                <span style="color: red;">(Salah)</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </p>
                                <p><strong>Alasan Jawaban Anda:</strong>
                                    <div style="display: flex; align-items: start; gap: 10px;">
                                        <div>
                                            (<?= $j->alasan; ?>)
                                        </div>
                                        <div>
                                            <?= $j->alasan_text; ?>
                                            <?php if ($j->alasan_text == $j->kunci_alasan_text): ?>
                                                <span style="color: green;">(Benar)</span>
                                            <?php else: ?>
                                                <span style="color: red;">(Salah)</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </p>
								<br/>
                                <p><strong>Jawaban yang Benar:</strong>
                                    <div style="display: flex; align-items: start; gap: 10px;">
                                        <div>
                                            <?= strtolower($j->kunci_jawaban); ?>.
                                        </div>
                                        <div>
                                            <?= $j->kunci_jawaban_text; ?>
                                        </div>
                                    </div>
                                </p>
                                <p><strong>Alasan yang Benar:</strong>
                                    <div style="display: flex; align-items: start; gap: 10px;">
                                        <div>
                                            (<?= $j->kunci_alasan; ?>)
                                        </div>
                                        <div>
                                            <?= $j->kunci_alasan_text; ?>
                                        </div>
                                    </div>
                                </p>
                            </div>
                        </div>
                        <?php $no++; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$this->load->view('ujian/js');
// $this->load->view('ujian/foot');
?>
