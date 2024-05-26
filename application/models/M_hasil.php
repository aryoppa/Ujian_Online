<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_hasil extends CI_Model
{
    public function get_peserta2($id)
    {
        $this->db->select('*');
        $this->db->from('tb_peserta');
        $this->db->join('tb_materi', 'tb_peserta.id_materi = tb_materi.id_materi');
        $this->db->join('tb_jenis_ujian', 'tb_peserta.id_jenis_ujian = tb_jenis_ujian.id_jenis_ujian');
        $this->db->join('tb_siswa', 'tb_peserta.id_siswa = tb_siswa.id_siswa');
        $this->db->where('tb_peserta.id_materi', $id);
        $this->db->order_by('nilai', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_peserta3()
    {
        $this->db->select('*');
        $this->db->from('tb_peserta');
        $this->db->join('tb_materi', 'tb_peserta.id_materi = tb_materi.id_materi');
        $this->db->join('tb_jenis_ujian', 'tb_peserta.id_jenis_ujian = tb_jenis_ujian.id_jenis_ujian');
        $this->db->join('tb_siswa', 'tb_peserta.id_siswa = tb_siswa.id_siswa');
        $this->db->order_by('nilai', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function cetak($id)
    {
        $this->db->select('*');
        $this->db->from('tb_peserta');
        $this->db->join('tb_materi', 'tb_peserta.id_materi = tb_materi.id_materi');
        $this->db->join('tb_jenis_ujian', 'tb_peserta.id_jenis_ujian = tb_jenis_ujian.id_jenis_ujian');
        $this->db->join('tb_siswa', 'tb_peserta.id_siswa = tb_siswa.id_siswa');
        $this->db->where('tb_peserta.id_peserta', $id);
        $query = $this->db->get();
        return $query->result();
    }
}
