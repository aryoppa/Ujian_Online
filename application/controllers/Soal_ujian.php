<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class soal_ujian extends CI_Controller {

	public function __construct() 
	{
		parent::__construct();
		if ($this->session->userdata('status') !='admin_login') {
			if ($this->session->userdata('status') !='guru_login'){
				redirect('auth');
			}
		}
		$this->load->model('m_soal');
	}

	public function index()
	{	
		if (isset($_GET['id'])) {
			$id = $this->input->get('id');
			$data['soal_ujian'] = $this->db->query('SELECT * from tb_soal_ujian join tb_materi where tb_soal_ujian.id_materi=tb_materi.id_materi and tb_materi.id_materi="'.$id.'" order by id_soal_ujian desc')->result();
			$data['kelas']=$this->m_data->get_data('tb_materi')->result();
		} else {
			$data['soal_ujian'] = $this->db->query('SELECT * FROM tb_soal_ujian join tb_materi ON tb_soal_ujian.id_materi=tb_materi.id_materi order by id_soal_ujian desc')->result();
			$data['kelas']=$this->m_data->get_data('tb_materi')->result();
		}					
		$this->load->view('admin/v_soal_ujian', $data);
	}

	public function edit($id)
	{
		$data['soal']=$this->m_soal->get_joinsoal($id)->result();
		$data['kelas']=$this->m_data->get_data('tb_materi')->result();		
		$this->load->view('admin/v_soal_ujian_edit', $data);		
	}

	public function update()
	{
		$id 				= $this->input->post('id');
		$nama_materi 		= $this->input->post('nama_materi');
		$pertanyaan			= $this->input->post('pertanyaan');
		$IPK				= $this->input->post('IPK');
		$a 					= $this->input->post('a');
		$b					= $this->input->post('b');
		$c					= $this->input->post('c');
		$d					= $this->input->post('d');
		$e					= $this->input->post('e');
		$kunci_jawaban		= $this->input->post('kunci_jawaban');
		$alasan_1			= $this->input->post('alasan_1');
		$alasan_2			= $this->input->post('alasan_2');
		$alasan_3			= $this->input->post('alasan_3');
		$alasan_4			= $this->input->post('alasan_4');
		$alasan_5			= $this->input->post('alasan_5');
		$kunci_alasan		= $this->input->post('kunci_alasan');
		$pembahasan			= $this->input->post('pembahasan');

		// // Handle file upload
		// $config['upload_path'] = './uploads/';
		// $config['allowed_types'] = 'gif|jpg|png';
		// $config['max_size'] = 2048; // 2MB
		// $config['encrypt_name'] = TRUE;

		// $this->upload->initialize($config);

		$where = array('id_soal_ujian'=>$id);
		$data = array(
			'id_materi'=>$nama_materi,
			'pertanyaan'=>$pertanyaan,
			'IPK' => $IPK,
			'a'=>$a,
			'b'=>$b,
			'c'=>$c,
			'd'=>$d,
			'e'=>$e,
			'kunci_jawaban'=>$kunci_jawaban,
			'alasan_1'=>$alasan_1,
			'alasan_2'=>$alasan_2,
			'alasan_3'=>$alasan_3,
			'alasan_4'=>$alasan_4,
			'alasan_5'=>$alasan_5,
			'kunci_alasan'=>$kunci_alasan,
			'pembahasan'=>$pembahasan,
		);
		$this->m_data->update_data($where, $data, 'tb_soal_ujian');
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Selamat, Soal telah berhasil diupdate!</h4></div>');
		redirect(base_url('soal_ujian'));
	}	

	public function hapus($id) 
	{
		$where = array(
					'id_soal_ujian'=>$id
				);
		$this->m_data->delete_data($where,'tb_soal_ujian');
		$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Perhatian, Data telah berhasil dihapus!</h4></div>');
		redirect(base_url('soal_ujian'));
	}
}