<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hasil_ujian extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') != 'admin_login') {
			redirect(base_url('auth'));
		}
		$this->load->model('m_hasil');
		$this->load->library('mypdf');
	}

	public function index()
	{
		if (isset($_GET['id'])) {
			$id = $this->input->get('id');
			$data['hasil'] = $this->m_hasil->get_peserta2($id);
			$data['kelas']=$this->m_data->get_data('tb_materi')->result();
		} else {
			$data['hasil'] = $this->m_hasil->get_peserta3();
			$data['kelas']=$this->m_data->get_data('tb_materi')->result();
		}		
		$this->load->view('admin/v_hasil', $data);
	}

	public function print_all()
	{	
		if (isset($_GET['id'])) {
			$id = $this->input->get('id');
			$data['cetak'] = $this->m_hasil->get_peserta2($id);
		} else {
			$data['cetak'] = $this->m_hasil->get_peserta3();
		}
		$this->mypdf->generate('admin/v_cetak', $data, 'Cetak Hasil Ujian ujian', 'A4', 'Landscape');
	}

	public function cetak($id)
	{
		$where = array('id_peserta' => $id);
		$id = $where['id_peserta'];
		$data['cetak'] = $this->m_hasil->cetak($id);
		$this->mypdf->generate('admin/v_cetak', $data, 'Cetak Hasil Ujian ujian', 'A4', 'Landscape');
	}

	public function distribusi($id)
	{
		$query = $this->db->query("SELECT * FROM tb_peserta WHERE id_peserta = $id");

		if ($query === FALSE) {
				show_error('Database query error');
				return;
		}

		$data['detail'] = $query->result();

		$jawaban_benar = 0;
		$alasan_benar = 0;

		foreach ($data['detail'] as $item) {
				if ($item->jawaban_benar) {
						$jawaban_benar = $item->jawaban_benar;
				}
				if ($item->alasan_benar) {
						$alasan_benar = $item->alasan_benar;
				}
		}

		$totalQuestions = 15;

		$incorrectJawaban = $totalQuestions - $jawaban_benar;
		$incorrectAlasan = $totalQuestions - $alasan_benar;

		$data['dataPointsJawaban'] = array(
				array("label" => "Benar", "y" => $jawaban_benar),
				array("label" => "Salah", "y" => $incorrectJawaban)
		);

		$data['dataPointsAlasan'] = array(
				array("label" => "Benar", "y" => $alasan_benar),
				array("label" => "Salah", "y" => $incorrectAlasan)
		);

		$data['id_peserta'] = $id;

		$this->load->view('admin/v_distribusi', $data);
	}
}
