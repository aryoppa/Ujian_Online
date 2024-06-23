<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruang_hasil extends CI_Controller {

	public function __construct() 
	{
		parent::__construct();
		if ($this->session->userdata('status') !='siswa_login') {
			redirect(base_url('auth'));
		}		
	}

	public function index() 
	{
		$id_siswa = $_SESSION['id'];
		$data['hasil'] = $this->m_data->get_peserta($id_siswa);
		$this->load->view('siswa/v_hasil', $data);
	}

	public function detail($id)
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

		if ($this->session->userdata('status') =='admin_login') {
			$this->load->view('admin/v_hasil_ujian', $data);
		} else {
			$this->load->view('siswa/v_hasil_ujian', $data);
		}
	}

	public function pembahasan($id_peserta)
    {
      $query = $this->db->query("
				SELECT 
					s.pertanyaan,
					j.jawaban,
					s.kunci_jawaban,
					CASE 
						WHEN j.jawaban = 'a' THEN s.a
						WHEN j.jawaban = 'b' THEN s.b
						WHEN j.jawaban = 'c' THEN s.c
						WHEN j.jawaban = 'd' THEN s.d
						WHEN j.jawaban = 'e' THEN s.e
						ELSE 'Jawaban tidak valid'
					END AS jawaban_text,
					CASE 
						WHEN s.kunci_jawaban = 'a' THEN s.a
						WHEN s.kunci_jawaban = 'b' THEN s.b
						WHEN s.kunci_jawaban = 'c' THEN s.c
						WHEN s.kunci_jawaban = 'd' THEN s.d
						WHEN s.kunci_jawaban = 'e' THEN s.e
						ELSE 'Kunci jawaban tidak valid'
					END AS kunci_jawaban_text,
					j.alasan,
					s.kunci_alasan,
					CASE 
						WHEN j.alasan = 'alasan_1' THEN s.alasan_1
						WHEN j.alasan = 'alasan_2' THEN s.alasan_2
						WHEN j.alasan = 'alasan_3' THEN s.alasan_3
						WHEN j.alasan = 'alasan_4' THEN s.alasan_4
						WHEN j.alasan = 'alasan_5' THEN s.alasan_5
						ELSE 'Alasan tidak valid'
					END AS alasan_text,
					CASE 
						WHEN s.kunci_alasan = 'alasan_1' THEN s.alasan_1
						WHEN s.kunci_alasan = 'alasan_2' THEN s.alasan_2
						WHEN s.kunci_alasan = 'alasan_3' THEN s.alasan_3
						WHEN s.kunci_alasan = 'alasan_4' THEN s.alasan_4
						WHEN s.kunci_alasan = 'alasan_5' THEN s.alasan_5
						ELSE 'Kunci alasan tidak valid'
					END AS kunci_alasan_text,
					p.nilai,
					s.pembahasan
			FROM 
				tb_soal_ujian s
			JOIN 
				tb_jawaban j ON s.id_soal_ujian = j.id_soal_ujian
			JOIN 
				tb_peserta p ON j.id_peserta = p.id_peserta
			WHERE 
				j.id_peserta = $id_peserta;
		");

		if ($query === FALSE) {
				show_error('Database query error');
				return;
		}

		$data['jawaban'] = $query->result();

		$data['nilai'] = 0;
		$data['jawaban_benar'] = 0;
		$data['alasan_benar'] = 0;

		foreach ($data['jawaban'] as $j) {
				if ($j->jawaban_text == $j->kunci_jawaban_text) {
						$data['jawaban_benar']++;
				}
				if ($j->alasan_text == $j->kunci_alasan_text) {
						$data['alasan_benar']++;
				}
	$data['nilai'] =$j->nilai;
		}


		$this->load->view('siswa/v_pembahasan', $data);
  }
}

