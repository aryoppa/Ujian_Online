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

	public function rekapitulasi($id, $id_materi)
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

			$score_query = $this->db->query("
					SELECT 
							SUM(CASE WHEN skor = 3 THEN 1 ELSE 0 END) AS PahamKonsep,
							SUM(CASE WHEN skor = 2 THEN 1 ELSE 0 END) AS Miskonsepsi,
							SUM(CASE WHEN skor = 1 THEN 1 ELSE 0 END) AS Menebak,
							SUM(CASE WHEN skor = 0 THEN 1 ELSE 0 END) AS TidakPahamKonsep
					FROM 
							tb_jawaban
					WHERE
							id_peserta = $id AND
							id_materi = $id_materi
			");

			if ($score_query === FALSE) {
					show_error('Database query error');
					return;
			}

			$score_result = $score_query->row();
			$data['dataPointsSkor'] = array(
					array("label" => "Paham Konsep", "y" => $score_result->PahamKonsep),
					array("label" => "Menebak", "y" => $score_result->Menebak),
					array("label" => "Miskonsepsi", "y" => $score_result->Miskonsepsi),
					array("label" => "Tidak Paham Konsep", "y" => $score_result->TidakPahamKonsep)
			);

			$data['id_peserta'] = $id;

			$query = $this->db->query("
					SELECT 
							m.nama_materi AS Konsep,
							s.IPK,
							CASE 
									WHEN j.skor = 3 THEN 'Benar'
									WHEN j.skor = 2 THEN 'Benar'
									WHEN j.skor = 1 THEN 'Salah'
									WHEN j.skor = 0 THEN 'Salah'
							END AS Jawaban,
							CASE 
									WHEN j.skor = 3 THEN 'Benar'
									WHEN j.skor = 2 THEN 'Salah'
									WHEN j.skor = 1 THEN 'Benar'
									WHEN j.skor = 0 THEN 'Salah'
							END AS Alasan,
							CASE 
									WHEN j.skor = 3 THEN 'Paham Konsep'
									WHEN j.skor = 2 THEN 'Miskonsepsi'
									WHEN j.skor = 1 THEN 'Menebak'
									WHEN j.skor = 0 THEN 'Tidak Paham Konsep'
							END AS Profil_Konsepsi
					FROM 
							tb_jawaban j
					JOIN 
							tb_soal_ujian s ON j.id_soal_ujian = s.id_soal_ujian
					JOIN 
							tb_materi m ON s.id_materi = m.id_materi
					WHERE 
							j.id_peserta = $id AND s.id_materi = $id_materi;
			");

			if ($query === FALSE) {
					show_error('Database query error');
					return;
			}

			$data['rekap'] = $query->result();

			$this->load->view('admin/v_rekapitulasi', $data);
	}
}
