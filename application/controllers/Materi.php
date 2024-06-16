<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class materi extends CI_Controller {


	public function __construct() {
		parent::__construct();

		if ($this->session->userdata('status') !='admin_login') {
			redirect(base_url('auth'));
		}
		
	}

	public function index()
	{
		$data['materi'] = $this->m_data->get_data('tb_materi')->result();
		$this->load->view('admin/v_materi', $data);
	}

	public function materi_aksi()
	{
		$kode 		= $this->input->post('kode');
		$nama		= $this->input->post('nama');

		$data = array(
			'kode_materi'=>$kode,
			'nama_materi'=>$nama
		);
		$this->m_data->insert_data($data, 'tb_materi');
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-message"><i class="icon fa fa-check"></i><b>Selamat !<br></b> Anda telah berhasil menambahkan data Materi</div>');
		redirect(base_url('materi'));
	}

	public function hapus($id) 
	{
		$where = array(
					'id_materi'=>$id
				);
		$this->m_data->delete_data($where,'tb_materi');
		$this->session->set_flashdata('message', '<div class="alert alert-danger alert-message"><i class="icon fa fa-check"></i><b>Selamat !<br></b> Anda telah berhasil menghapus data Materi</div>');
		redirect(base_url('materi'));
	}

	public function edit($id) 
	{
		$where	= array('id_materi'=>$id);
		$data['materi']=$this->m_data->edit_data($where,'tb_materi')->result();
		$this->load->view('admin/v_materi_edit',$data);
	}

	public function update()
	{
		$id 		= $this->input->post('id');
		$kode 		= $this->input->post('kode');
		$nama		= $this->input->post('nama');

		$where = array('id_materi'=>$id);
		$data = array(
					'kode_materi'=>$kode,
					'nama_materi'=>$nama
					);
		$this->m_data->update_data($where,$data,'tb_materi');
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-message"><i class="icon fa fa-check"></i><b>Selamat !<br></b> Anda telah berhasil mengupdate data Materi</div>');
		redirect(base_url('materi'));
	}
}