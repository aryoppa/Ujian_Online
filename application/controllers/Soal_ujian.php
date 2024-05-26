<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class soal_ujian extends CI_Controller {

	public function __construct() 
	{
		parent::__construct();
		$this->redirectIfNotLoggedIn();
		$this->load->model('m_soal');
	}

	private function redirectIfNotLoggedIn() {
		if (!$this->session->userdata('status') == 'admin_login' && !$this->session->userdata('status') == 'guru_login') {
			redirect('auth');
		}
	}

	public function index()
	{	
		$id = $this->input->get('id');
		$query = $id ? 'SELECT * FROM tb_soal_ujian JOIN tb_matapelajaran ON tb_soal_ujian.id_matapelajaran=tb_matapelajaran.id_matapelajaran WHERE tb_matapelajaran.id_matapelajaran=? ORDER BY id_soal_ujian DESC' : 'SELECT * FROM tb_soal_ujian JOIN tb_matapelajaran ON tb_soal_ujian.id_matapelajaran=tb_matapelajaran.id_matapelajaran ORDER BY id_soal_ujian DESC';
		$data['soal_ujian'] = $this->db->query($query, array($id))->result();
		$data['kelas'] = $this->m_data->get_data('tb_matapelajaran')->result();
		$this->load->view('admin/v_soal_ujian', $data);
	}

	public function edit($id)
	{
		$data['soal'] = $this->m_soal->get_joinsoal($id)->result();
		$data['kelas'] = $this->m_data->get_data('tb_matapelajaran')->result();		
		$this->load->view('admin/v_soal_ujian_edit', $data);		
	}

	public function update()
	{
		$postData = $this->input->post();
		$where = array('id_soal_ujian' => $postData['id']);
		$data = array(
			'id_matapelajaran' => $postData['nama_matapelajaran'],
			'pertanyaan' => $postData['soal'],
			'a' => $postData['a'],
			'b' => $postData['b'],
			'c' => $postData['c'],
			'd' => $postData['d'],
			'e' => $postData['e'],
			'kunci_jawaban' => $postData['kunci']
		);
		$this->m_data->update_data($where, $data, 'tb_soal_ujian');
		$this->setFlashAndRedirect('message', 'success', 'Selamat, Soal telah berhasil diupdate!', 'soal_ujian');
	}	

	public function hapus($id) 
	{
		$where = array('id_soal_ujian' => $id);
		$this->m_data->delete_data($where, 'tb_soal_ujian');
		$this->setFlashAndRedirect('message', 'danger', 'Perhatian, Data telah berhasil dihapus!', 'soal_ujian');
	}

	private function setFlashAndRedirect($key, $type, $message, $redirectUrl) {
		$flashMessage = "<div class='alert alert-$type alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4><i class='icon fa fa-check'></i> $message</h4></div>";
		$this->session->set_flashdata($key, $flashMessage);
		redirect(base_url($redirectUrl));
	}
}
