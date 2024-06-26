<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ruang_ujian extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') != 'siswa_login') {
			redirect(base_url() . 'auth?alert=belum_login');
		}
	}

	public function soal()
	{
		$id_peserta = $this->uri->segment(3);		
		$id = $this->db->query('SELECT * FROM tb_peserta WHERE id_peserta="' . $id_peserta . '"  ')->row_array();
		$soal_ujian = $this->db->query('SELECT * FROM tb_soal_ujian WHERE id_materi="'.$id['id_materi'].'" ORDER BY RAND()');
		$where = array('id_peserta' => $id_peserta);
		$data2 = array('status_ujian_ujian' => 1);
		$this->m_data->update_data($where,$data2,'tb_peserta');
		$time = $id['timer_ujian'];
		$data = array(
			"soal" => $soal_ujian->result(),
			"total_soal" => $soal_ujian->num_rows(),
			"max_time" => $time,
			"id" => $id,
			"id_materi" => $id['id_materi'] // Save id_materi to data array
		);
		// echo '<pre>' . print_r($data, true) . '</pre>';
		$this->load->view('ujian/v_soalujian', $data);
	}

	public function jawab_aksi()
	{
		$id_peserta = $this->input->post('id_peserta');
		$id_materi = $this->input->post('id_materi'); // Get id_materi from POST data
		$jumlah 	= $_POST['jumlah_soal'];
		$id_soal 	= $_POST['pertanyaan'];
		$jawaban 	= $_POST['jawaban'];
		$alasan		= $_POST['alasan'];
		for ($i = 0; $i < $jumlah; $i++) {
			$nomor = $id_soal[$i];
			$jawaban[$nomor];
			$data[] = array(
				'id_materi' => $id_materi,
				'id_peserta' => $id_peserta,
				'id_soal_ujian' => $nomor,
				'jawaban' => $jawaban[$nomor],
				'alasan'	=> $alasan[$nomor],
			);
		}
		// echo '<pre>' . print_r($data, true) . '</pre>';
		$this->db->insert_batch('tb_jawaban', $data);
		$cek = $this->db->query('SELECT id_jawaban, jawaban, alasan, tb_soal_ujian.kunci_jawaban, tb_soal_ujian.kunci_alasan FROM tb_jawaban join tb_soal_ujian ON tb_jawaban.id_soal_ujian=tb_soal_ujian.id_soal_ujian WHERE id_peserta="' . $id_peserta . '"');
		$jumlah = $cek->num_rows();
		foreach ($cek->result_array() as $d) {
			$where = $d['id_jawaban'];
			if (strtolower($d['jawaban']) == strtolower($d['kunci_jawaban']) && $d['alasan'] == $d['kunci_alasan']) {
				$data = array(
					'skor' => 3,
				);
				$this->m_data->UpdateNilai($where, $data, 'tb_jawaban');
			} elseif (strtolower($d['jawaban']) == strtolower($d['kunci_jawaban']) && $d['alasan'] != $d['kunci_alasan']) {
				$data = array(
					'skor' => 2,
				);
				$this->m_data->UpdateNilai($where, $data, 'tb_jawaban');
			} elseif (strtolower($d['jawaban']) != strtolower($d['kunci_jawaban']) && $d['alasan'] == $d['kunci_alasan']) {
				$data = array(
					'skor' => 1,
				);
				$this->m_data->UpdateNilai($where, $data, 'tb_jawaban');
			} else {
				$data = array(
					'skor' => 0,
				);
				$this->m_data->UpdateNilai($where, $data, 'tb_jawaban');
			}
		}

		$jawaban_benar = 0;
		$alasan_benar = 0;
		$total_nilai = 0;
		$cek2 = $this->db->query('SELECT id_jawaban, jawaban, alasan, skor, tb_soal_ujian.kunci_jawaban, tb_soal_ujian.kunci_alasan FROM tb_jawaban join tb_soal_ujian ON tb_jawaban.id_soal_ujian=tb_soal_ujian.id_soal_ujian WHERE id_peserta="' . $id_peserta . '"');

		$where = $id_peserta;
		foreach ($cek2->result_array() as $c) {
			if ($c['skor'] == 3 ) {
				$jawaban_benar++;
				$alasan_benar++;
			} elseif($c['skor'] == 2) {
				$jawaban_benar++;
			} elseif($c['skor'] == 1) {
				$alasan_benar++;
			}
	
			$total_nilai += $c['skor'] / 45 * 100;
			
		}
		$data = array(
			'jawaban_benar' => $jawaban_benar,
			'alasan_benar' => $alasan_benar,
			'status_ujian' => 2,
			'status_ujian_ujian' => 2,
			'nilai' => $total_nilai,
		);
		$this->m_data->UpdateNilai2($where, $data, 'tb_peserta');
		redirect(base_url('ruang_hasil'));
	}

	
}
