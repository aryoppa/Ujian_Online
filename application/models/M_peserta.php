<?php
defined('BASEPATH') or exit('no direct script access allowed');

class M_peserta extends CI_Model
{
    public function get_all()
    {
        // SQL query to join tb_peserta, tb_siswa, tb_kelas, and tb_materi tables
    $query = "SELECT 
                    peserta.id_peserta,
                    siswa.nama_siswa,
                    kelas.nama_kelas,
                    materi.materi_name
                FROM 
                    tb_peserta peserta
                JOIN 
                    tb_siswa siswa ON peserta.id_siswa = siswa.id_siswa
                JOIN 
                    tb_kelas kelas ON siswa.id_kelas = kelas.id_kelas
                JOIN 
                    tb_materi materi ON kelas.id_kelas = materi.id_kelas;
            ";
            return $query;
    }


    public function get_joinpeserta($id)
    {
        $this->db->select('*');
        $this->db->from('tb_peserta');
        $this->db->join('tb_materi', 'tb_peserta.id_materi=tb_materi.id_materi');
        $this->db->join('tb_siswa', 'tb_peserta.id_siswa=tb_siswa.id_siswa');
        $this->db->join('tb_jenis_ujian', 'tb_peserta.id_jenis_ujian=tb_jenis_ujian.id_jenis_ujian');
        $this->db->where('tb_peserta.id_peserta', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_peserta($idkls, $idsiswa)
    {
        $array = array('tb_kelas.id_kelas' => $idkls, 'tb_siswa.id_siswa' => $idsiswa);
        $this->db->select('*');
        $this->db->from('tb_peserta');
        $this->db->join('tb_materi', 'tb_peserta.id_materi=tb_materi.id_materi');
        $this->db->join('tb_siswa', 'tb_peserta.id_siswa=tb_siswa.id_siswa');
        $this->db->join('tb_jenis_ujian', 'tb_peserta.id_jenis_ujian=tb_jenis_ujian.id_jenis_ujian');
        $this->db->join('tb_kelas', 'tb_kelas.id_kelas=tb_siswa.id_kelas', 'left');
        $this->db->where($array);
        $this->db->order_by('id_peserta', 'DESC');
        $query = $this->db->get();
        return $query;
    }
    
    public function get_peserta2($idkls)
    {
        $this->db->select('*');
        $this->db->from('tb_peserta');
        $this->db->join('tb_materi', 'tb_peserta.id_materi=tb_materi.id_materi');
        $this->db->join('tb_siswa', 'tb_peserta.id_siswa=tb_siswa.id_siswa');
        $this->db->join('tb_jenis_ujian', 'tb_peserta.id_jenis_ujian=tb_jenis_ujian.id_jenis_ujian');
        $this->db->join('tb_kelas', 'tb_kelas.id_kelas=tb_siswa.id_kelas', 'left');
        $this->db->where('tb_kelas.id_kelas', $idkls);
        $this->db->order_by('id_peserta', 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function get_peserta3($idsiswa)
    {
        $this->db->select('*');
        $this->db->from('tb_peserta');
        $this->db->join('tb_materi', 'tb_peserta.id_materi=tb_materi.id_materi');
        $this->db->join('tb_siswa', 'tb_peserta.id_siswa=tb_siswa.id_siswa');
        $this->db->join('tb_jenis_ujian', 'tb_peserta.id_jenis_ujian=tb_jenis_ujian.id_jenis_ujian');
        $this->db->join('tb_kelas', 'tb_kelas.id_kelas=tb_siswa.id_kelas', 'left');
        $this->db->where('tb_siswa.id_siswa', $idsiswa);
        $this->db->order_by('id_peserta', 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function get_peserta4()
    {
        $this->db->select('tb_peserta.*, tb_materi.nama_materi, tb_siswa.nama_siswa, tb_jenis_ujian.jenis_ujian, tb_kelas.nama_kelas');
        $this->db->from('tb_peserta');
        $this->db->join('tb_materi', 'tb_peserta.id_materi = tb_materi.id_materi', 'left');
        $this->db->join('tb_siswa', 'tb_peserta.id_siswa = tb_siswa.id_siswa', 'left');
        $this->db->join('tb_jenis_ujian', 'tb_peserta.id_jenis_ujian = tb_jenis_ujian.id_jenis_ujian', 'left');
        $this->db->join('tb_kelas', 'tb_siswa.id_kelas = tb_kelas.id_kelas', 'left');
        $this->db->order_by('tb_peserta.id_peserta', 'DESC');
        $query = $this->db->get();
        return $query;
    }
}
