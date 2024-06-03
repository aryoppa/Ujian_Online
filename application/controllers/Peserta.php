<?php
defined('BASEPATH') or exit('No direct script access allowed');

class peserta extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') != 'admin_login') {
			redirect(base_url('auth'));
		}
		$this->load->model('m_peserta');
		
	}

	/**
	 * The index function for the Peserta controller.
	 * It loads a list of participants (peserta) based on the class ID (id_kelas) and/or student ID (id_siswa).
	 * If both class ID and student ID are provided, it fetches participants for that specific class and student.
	 * If only class ID is provided, it fetches all participants in that class.
	 * If only student ID is provided, it fetches all classes that the student is participating in.
	 * If neither is provided, it fetches all participants.
	 * It then loads the 'admin/v_peserta' view, passing the participants, classes, and students data.
	 */
	public function index()
	{
		
		$data['peserta'] = $this->m_peserta->get_peserta4()->result();

		// Load the view with the data
		$this->load->view('admin/v_peserta', $data);
	}

	public function hapus($id)
	{
		$where = array(
			'id_peserta' => $id
		);
		$this->m_data->delete_data($where, 'tb_peserta');
		$this->session->set_flashdata('message', '<div class="alert alert-danger alert-message"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Data Peserta Ujian berhasil di hapus !</h4></div>');
		redirect(base_url('peserta'));
	}


	public function edit($id)
	{
		$data['peserta'] = $this->m_peserta->get_joinpeserta($id);
		$data['nama_materi'] = $this->m_data->get_data('tb_materi')->result();
		$data['siswa'] = $this->m_data->get_data('tb_siswa')->result();
		$data['jenis_ujian'] = $this->m_data->get_data('tb_jenis_ujian')->result();
		$this->load->view('admin/v_peserta_edit', $data);
	}

	public function update()
	{
		$id_peserta 	= $this->input->post('id_peserta');
		$nama_materi 	= $this->input->post('nama_materi');
		$tanggal_ujian	= $this->input->post('tanggal_ujian');
		$jam_ujian		= $this->input->post('jam_ujian');
		$durasi_ujian	= $this->input->post('durasi_ujian');
		$id_jenis_ujian	= $this->input->post('id_jenis_ujian');
		$timer_ujian 	= $durasi_ujian*60;
		$where  = array('id_peserta' => $this->input->post('id'));

	
		$data = array(
			'id_siswa'			=> $peserta,
			'id_materi'			=> $id_materi,
			'id_jenis_ujian'	=> $id_jenis_ujian,
			'tanggal_ujian'		=> $tanggal_ujian,
			'jam_ujian'			=> $jam_ujian,
			'durasi_ujian'		=> $durasi_ujian,
			'timer_ujian'		=> $timer_ujian,
			'status_ujian'		=> 1
			
		);

		$this->m_data->update_data($where, $data, 'tb_peserta');
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-message"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Data berhasil di Update.</h4></div>');
		redirect(base_url('peserta'));
	}

	
	
}
