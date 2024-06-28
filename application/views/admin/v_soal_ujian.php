<?php
$this->load->view('admin/head');
$this->load->view('admin/topbar');
$this->load->view('admin/sidebar');
?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title text-center">Daftar Soal Ujian</h3>
                </div>
                <form action="" method="get" class="form-horizontal">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-1 control-label">Materi</label>
                            <div class="col-sm-8">
                                <select class="select2 form-control" name="id" required>
                                    <option selected disabled>- Pilih Materi -</option>
                                    <?php foreach ($kelas as $a): ?>
                                        <option value="<?= $a->id_materi ?>"><?= $a->kode_materi; ?> | <?= $a->nama_materi; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-1 col-sm-10">
                                <button type="submit" class="btn btn-primary btn-flat" title="Filter Data Soal Ujian"><i class="fa fa-filter"></i> Filter</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <?= $this->session->flashdata('message'); ?>
            <div class="box box-success" style="overflow-x: scroll;">
                <div class="box-header with-border">
                    <a href="<?= base_url('soal') ?>" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> Tambah</a>
                    <a href="<?= base_url('materi') ?>" class="btn btn-primary btn-flat">Data Materi</a>
                </div>
                <table id="data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>MATERI</th>
                            <th>INDIKATOR PENCAPAIAN KOMPETENSI</th>
                            <th>SOAL UJIAN</th>
                            <th>KUNCI JAWABAN</th>
                            <th>ALASAN</th>
                            <th>KUNCI ALASAN</th>
                            <th>PEMBAHASAN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($soal_ujian as $index => $d): ?>
                            <tr>
                                <td><?= $index + 1; ?></td>
                                <td><?= $d->nama_materi; ?></td>
                                <td><?= $d->IPK; ?></td>
                                <td>
                                    <?= $d->pertanyaan; ?>
                                    <img src="<?= base_url('uploads/'.$d->image) ?>" alt="" width="300" onerror="this.onerror=null; this.src='<?= base_url('uploads/default.png') ?>';" style="display: <?= empty($d->image) ? 'none' : 'block'; ?>;">
                                    <?= $d->pertanyaan_2; ?>
                                    <ol type="A">
                                        <?php foreach (['a', 'b', 'c', 'd', 'e'] as $option): ?>
                                            <li<?= $d->kunci_jawaban == strtoupper($option) ? ' style="font-weight:bold;"' : ''; ?>>
                                                <?= $d->$option; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ol>
                                </td>
                                <td><strong><?= $d->kunci_jawaban; ?></strong></td>
                                <td><ol type="A">
                                        <?php foreach (['alasan_1', 'alasan_2', 'alasan_3', 'alasan_4', 'alasan_5'] as $option): ?>
                                            <li<?= $d->kunci_alasan == strtoupper($option) ? ' style="font-weight:bold;"' : ''; ?>>
                                                <?= $d->$option; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ol>
                                </td>
                                <td><strong><?= $d->kunci_alasan; ?></strong></td>
                                <td>
                                    <?= $d->pembahasan; ?>
                                    <img src="<?= base_url('uploads/'.$d->image_pembahasan) ?>" alt="" width="300" onerror="this.onerror=null; this.src='<?= base_url('uploads/default.png') ?>';" style="display: <?= empty($d->image) ? 'none' : 'block'; ?>;">
                                    <?= $d->pembahasan_2; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url() . 'soal_ujian/edit/' . $d->id_soal_ujian; ?>" class="btn btn-xs btn-success" title="Ubah"><i class="glyphicon glyphicon-edit"></i></a>
                                    <a href="<?= base_url() . 'soal_ujian/hapus/' . $d->id_soal_ujian; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Apakah yakin data soal ini akan di hapus?')" title="Hapus"><i class="glyphicon glyphicon-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php
$this->load->view('admin/js');
?>
<script type="text/javascript">
    $(function() {
        $('#data').dataTable();
        $('.select2').select2();
        $('.alert-message').alert().delay(3000).slideUp('slow');
    });
</script>
<?php
?>
