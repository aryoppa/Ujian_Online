  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?= base_url('image/fav.png') ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?= $this->session->userdata('nama'); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
      
        <!-- Menu Home -->
        <li class="<?= $this->uri->segment(1) == 'home' ? 'active' : '' ?>">
          <a href="<?= base_url('home'); ?>"><i class="fa fa-home"></i>
            <span>Home</span>
          </a>
        </li>

        <!-- Dashboard ADMIN -->
        <?php if ($this->session->userdata('status') == 'admin_login'): ?>
            <li class="<?= $this->uri->segment(1) == 'siswa' ? 'active' : '' ?>">
              <a href="<?= base_url('siswa'); ?>"><i class="fa fa-circle-o"></i> Data Siswa</a>
            </li>
            <li class="<?= $this->uri->segment(1) == 'soal_ujian' ? 'active' : '' ?>">
              <a href="<?= base_url('soal_ujian'); ?>"><i class="fa fa-circle-o"></i> Kelola Soal Ujian</a>
            </li>
            <li class="<?= $this->uri->segment(1) == 'peserta' ? 'active' : '' ?>">
              <a href="<?= base_url('peserta'); ?>"><i class="fa fa-circle-o"></i> Kelola Peserta Ujian</a>
            </li>
            <li class="<?= $this->uri->segment(1) == 'hasil_ujian' ? 'active' : '' ?>">
              <a href="<?= base_url('hasil_ujian'); ?>"><i class="fa fa-circle-o"></i> Hasil Ujian</a>
            </li>
        <?php endif; ?>

        <li class="<?= $this->uri->segment(1) == 'password' ? 'active' : '' ?>">
          <a href="<?= base_url('password'); ?>"><i class="fa fa-lock"></i>
            <span>Ganti Password</span>
          </a>
        </li>

        <li>
          <a href="<?= base_url('logout'); ?>"><i class="fa fa-power-off"></i>
            <span>Keluar Akun</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">