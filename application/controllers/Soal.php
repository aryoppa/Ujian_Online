<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Soal extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
        $this->load->library('upload');
		if ($this->session->userdata('status') != 'admin_login') {
			if ($this->session->userdata('status') != 'guru_login') {
				redirect('auth');
			}
		}
	}

	public function index()
	{
		$data['soal'] = $this->m_data->get_data('tb_materi')->result();
		$this->load->view('admin/v_soal', $data);
	}

	public function insert()
	{
		
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
		
		// Handle file upload
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = 2048; // 2MB
		$config['encrypt_name'] = TRUE;

		$this->upload->initialize($config);

	

		if (!$this->upload->do_upload('image')) {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-message alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Maaf, Input Soal Gagal!</h4>' . $error['error'] . '</div>');
            redirect(base_url('soal'));
        } else {
            $data = $this->upload->data();
            $image = $data['file_name'];

            $data = array(
                'id_materi' => $nama_materi,
                'pertanyaan' => $pertanyaan,
				'IPK' => $IPK,
                'a' => $a,
                'b' => $b,
                'c' => $c,
                'd' => $d,
                'e' => $e,
                'kunci_jawaban' => $kunci_jawaban,
                'alasan_1' => $alasan_1,
                'alasan_2' => $alasan_2,
                'alasan_3' => $alasan_3,
                'alasan_4' => $alasan_4,
                'alasan_5' => $alasan_5,
                'kunci_alasan' => $kunci_alasan,
                'pembahasan' => $pembahasan,
                'image' => $image // Save the uploaded image file name
            );

            if ($nama_materi == '' && $pertanyaan == '') {
                echo($id_materi);
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-message alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Maaf, Input Soal Gagal!</h4> Mata Kuliah dan Pertanyaan Soal tidak boleh dikosongkan. ' . $nama_materi . '</div>');
                redirect(base_url('soal'));
            } else {
                $this->m_data->insert_data($data, 'tb_soal_ujian');
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-message alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Selamat, Soal berhasil dibuat!</h4>untuk melihat soal tersebut bisa anda lihat di menu <b>Daftar Soal ujian</b>.</div>');
                redirect(base_url('soal_ujian'));
            }
        }
				
	}
}