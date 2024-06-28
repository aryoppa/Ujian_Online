<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruang_hasil extends CI_Controller {

    public function __construct() 
    {
        parent::__construct();
        if ($this->session->userdata('status') != 'siswa_login') {
            redirect(base_url('auth'));
        }
    }

    public function index() 
    {
        $id_siswa = $_SESSION['id'];
        $data['hasil'] = $this->m_data->get_peserta($id_siswa);
        $this->load->view('siswa/v_hasil', $data);
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

        $this->load->view('siswa/v_rekapitulasi', $data);
    }

    public function pembahasan($id_peserta)
    {
        $query = $this->db->query("
            SELECT 
                s.pertanyaan,
                s.image,
                s.pertanyaan_2,
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
                s.pembahasan,
                s.image_pembahasan,
                s.pembahasan_2
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
            $data['nilai'] = $j->nilai;
        }

        $this->load->view('siswa/v_pembahasan', $data);
    }
}
?>
