<?php
defined('BASEPATH') or exit('No direct script access allowed');

class jadwal_ujian extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') != 'siswa_login') {
			redirect(base_url() . 'auth?alert=belum_login');
		}
	}

	public function index()
	{
		$id_siswa = $_SESSION['id'];
		$data['peserta'] = $this->m_data->get_peserta($id_siswa);
		// $data['peserta'] = $this->db->query('SELECT tb_peserta.id_peserta, tb_materi.kode_materi, tb_materi.nama_materi, tb_materi.id_materi, tb_siswa.nama_siswa, tb_siswa.nis, tanggal_ujian, jam_ujian, durasi_ujian, tb_jenis_ujian.jenis_ujian, status_ujian  FROM tb_peserta, tb_materi, tb_siswa, tb_jenis_ujian WHERE tb_peserta.id_jenis_ujian=tb_jenis_ujian.id_jenis_ujian and tb_peserta.id_materi=tb_materi.id_materi and tb_peserta.id_siswa=tb_siswa.id_siswa and tb_siswa.nama_siswa="' . $this->session->userdata('nama') . '" ')->result();
		$this->load->view('siswa/v_jadwal_ujian', $data);
	}
}
