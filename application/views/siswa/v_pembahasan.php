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
                    <h4 class="box-title" style="font-weight: 600">PEMBAHASAN SOAL</h4>
                </div>
                <div class="box-body">
                    <div class="well well-lg text-center" style="display: flex; justify-content: space-between; align-items: center;">
						<div style="text-align: left; display: flex; gap: 20px">
							<div>
								<h4 style="font-weight: 550; font-size: 18px">Jawaban Benar</h4>
								<h5 style="font-weight: 550; font-size: 18px">Alasan Benar</h5>
							</div>
							<div>
								<h4 style="font-weight: 550; font-size: 18px">:</h4>
								<h5 style="font-weight: 550; font-size: 18px">:</h5>
							</div>
							<div>
								<h5>
									<span style="color: #009688; font-size: 18px"><?= $jawaban_benar; ?></span>
									<span style="color: gray;">/15</span>
								</h5>
								<h5>
									<span style="color: #009688; font-size: 18px"><?= $alasan_benar; ?></span>
									<span style="color: gray;">/15</span>
								</h5>
							</div>
						</div>
                        <h3 style="font-weight: 550; font-size: 18px">Nilai Anda: <span class="badge badge-success"	style="font-size: 16px"><?= $nilai; ?></span></h3>
                    </div>
                    <hr>
                    <h4>Detail Jawaban:</h4>
                    <?php $no = 1; ?>
                    <?php foreach ($jawaban as $j): ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <strong><?= $no; ?>. Pertanyaan:</strong> <?= $j->pertanyaan; ?>
                            </div>
                            <div class="panel-body">
                                <div><strong>Jawaban dan Alasan Anda:</strong></div>
                                <div style="display: flex; align-items: start; gap: 62px;">
                                    <div>
										<p style="font-weight: 600;">
											<?= $j->jawaban; ?>.
										</p>
                                    </div>
                                    <div>
                                        <?= $j->jawaban_text; ?>
                                        <?php if ($j->jawaban_text == $j->kunci_jawaban_text): ?>
                                            <span class="text-success">(Benar)</span>
                                        <?php else: ?>
                                            <span class="text-danger">(Salah)</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div style="display: flex; align-items: start; gap: 20px;">
                                    <div>
										<p style="font-weight: 600;">
											<?= $j->alasan; ?>
										</p>
                                    </div>
                                    <div>
                                        <?= $j->alasan_text; ?>
                                        <?php if ($j->alasan_text == $j->kunci_alasan_text): ?>
                                            <span class="text-success">(Benar)</span>
                                        <?php else: ?>
                                            <span class="text-danger">(Salah)</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <br/>
                                <div><strong>Jawaban dan Alasan yang Benar:</strong></div>
                                <div style="display: flex; align-items: start; gap: 62px">
                                    <div>
										<p style="font-weight: 600;">
											<?= strtolower($j->kunci_jawaban); ?>.
										</p>
                                    </div>
                                    <div>
                                        <?= $j->kunci_jawaban_text; ?>
                                    </div>
                                </div>
                                <div style="display: flex; align-items: start; gap: 20px">
                                    <div>
										<p style="font-weight: 600;">
											<?= $j->kunci_alasan; ?>
										</p>
                                    </div>
                                    <div>
                                        <?= $j->kunci_alasan_text; ?>
                                    </div>
                                </div>
								<br/>
								<div class="panel-content">
									<strong>Pembahasan:</strong>
							
									<div>
										<?= $j->pembahasan; ?>
									</div>
								</div>
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
?>

<style>
    .badge {
        font-size: 0.7em;
        padding: 10px;
		background-color: #009688;
    }

    .panel-heading {
        background-color: #f5f5f5;
        border-bottom: 1px solid #ddd;
    }

    .panel-body p {
        margin: 10px 0;
    }

	.panel-content {
        background-color: #f5f5f5;
        padding: 10px;
		border-radius: 3px;
    }

    .text-success {
        color: green;
    }

    .text-danger {
        color: red;
    }
</style>
