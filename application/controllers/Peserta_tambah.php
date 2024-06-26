<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class peserta_tambah extends CI_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		if ($this->session->userdata('status') !='admin_login') {
			redirect(base_url().'auth?alert=belum_login');
		}
	}

	public function index()
	{
		if (isset($_GET['id_kelas'])) {
			$id = $this->input->get('id_kelas');
			$data['id_siswa'] 		= $this->db->query('SELECT * from tb_siswa join tb_kelas where tb_siswa.id_kelas=tb_kelas.id_kelas and tb_kelas.id_kelas="'.$id.'"')->result();
			
			$data['id_kelas']		= $this->m_data->get_data('tb_kelas')->result();
			$data['id_materi']		= $this->m_data->get_data('tb_materi')->result();
			$data['jenis_ujian'] 	= $this->m_data->get_data('tb_jenis_ujian')->result();
		} else {
			$data['id_siswa'] 		= $this->db->query('SELECT * from tb_siswa join tb_kelas where tb_siswa.id_kelas = tb_kelas.id_kelas')->result();
			$data['id_kelas']		= $this->m_data->get_data('tb_kelas')->result();
			$data['id_materi']		= $this->m_data->get_data('tb_materi')->result();
			$data['jenis_ujian'] 	= $this->m_data->get_data('tb_jenis_ujian')->result();
		}
		$this->load->view('admin/v_peserta_tambah',$data);
	}

	public function insert_()
	{
		$id_materi 			= $this->input->post('id_materi');
		$tanggal_ujian		= $this->input->post('tanggal_ujian');
		$jam_ujian			= $this->input->post('jam_ujian');
		$durasi_ujian		= $this->input->post('durasi_ujian');
		$id_siswa			= $this->input->post('id');

		$data = array(
			'id_materi'		=> $id_materi,
			'tanggal_ujian'	=> $tanggal_ujian,
			'jam_ujian'		=> $jam_ujian,
			'durasi_ujian'	=> $durasi_ujian,
			'id_siswa'		=> $id_siswa,
		);
		
		if ($id_materi == '' || $tanggal_ujian == '' || $jam_ujian == '') {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-message"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Input Data Peserta Gagal !</h4> Cek kembali data yang diinputkan.</div>');
			redirect(base_url('peserta_tambah'));
		} else {
			$this->m_data->insert_multiple($data);
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-message"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Peserta Ujian berhasil dibuat !</h4></div>');
			redirect(base_url('peserta'));
		}
	}	
}