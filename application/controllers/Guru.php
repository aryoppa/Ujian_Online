<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// The Guru controller extends the CI_Controller class, making it a part of the CodeIgniter framework.
class guru extends CI_Controller {

	// The constructor function runs when a new object of the class is created.
	public function __construct() {
		parent::__construct(); // Calls the constructor of the parent class (CI_Controller).

		// Checks if the user's session status is not 'admin_login', and if so, redirects to the 'auth' page.
		if ($this->session->userdata('status') !='admin_login') {
			redirect(base_url('auth'));
		}
	}

	// The index method is the default method that gets called when no other method is specified.
	public function index()
	{
		// Retrieves data from the 'tb_guru' table and stores it in the $data array under the key 'guru'.
		$data['guru'] = $this->m_data->get_data('tb_guru')->result();
		// Loads the view 'v_guru' from the 'admin' folder and passes the $data array to it.
		$this->load->view('admin/v_guru', $data);
	}

	// The guru_aksi method handles the action of adding a new 'guru' (teacher) to the database.
	public function guru_aksi()
	{
		// Retrieves input data from a form submission.
		$nik		= $this->input->post('nik');
		$nama 		= $this->input->post('nama');		
		$username	= $this->input->post('username');
		$password	= $this->input->post('password');

		// Prepares the data for insertion into the database.
		$data = array(
			'id_guru'=>$nik,
			'nama_guru'=>$nama,
			'username'=>$username,
			'password'=>$password,
		);

		// Inserts the data into the 'tb_guru' table.
		$this->m_data->insert_data($data, 'tb_guru');
		// Sets a flash message to indicate success.
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-message"><i class="icon fa fa-check"></i><b>Selamat ! <br></b> Anda telah berhasil menambahkan data guru</div>');
		// Redirects to the 'guru' page.
		redirect(base_url('guru'));
	}

	// The hapus method handles the action of deleting a 'guru' (teacher) from the database.
	public function hapus($id) 
	{
		// Prepares the condition for the delete operation.
		$where = array(
					'id_guru'=>$id
				);

		// Deletes the data from the 'tb_guru' table where the condition is met.
		$this->m_data->delete_data($where,'tb_guru');
		// Sets a flash message to indicate success.
		$this->session->set_flashdata('message', '<div class="alert alert-danger alert-message"><i class="icon fa fa-check"></i><b>Selamat ! <br></b> Anda telah berhasil menghapus data guru</div>');
		// Redirects to the 'guru' page.
		redirect(base_url('guru'));
	}

	// The edit method retrieves the data of a specific 'guru' (teacher) for editing.
	public function edit($id) 
	{
		// Prepares the condition to retrieve the specific data.
		$where	= array('id_guru'=>$id);
		// Retrieves the data and stores it in the $data array under the key 'guru'.
		$data['guru']=$this->m_data->edit_data($where,'tb_guru')->result();
		// Loads the view 'v_guru_edit' from the 'admin' folder and passes the $data array to it.
		$this->load->view('admin/v_guru_edit',$data);
	}
	
	// The update method handles the action of updating a 'guru' (teacher) data in the database.
	public function update()
	{
		// Retrieves input data from a form submission.
		$id 		= $this->input->post('nik');
		$nama 		= $this->input->post('nama');
		$username	= $this->input->post('username');
		$password	= $this->input->post('password');

		// Prepares the condition for the update operation.
		$where = array('id_guru'=>$id);		
		// Prepares the new data for the update operation.
		$data = array(
						'nama_guru'=>$nama,
						'username'=> $username,
						'password'=>$password,
					);
		// Updates the data in the 'tb_guru' table where the condition is met.
		$this->m_data->update_data($where,$data,'tb_guru');
		// Sets a flash message to indicate success.
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-message"><i class="icon fa fa-check"></i><b>Selamat ! <br></b> Anda telah berhasil mengupdate data guru</div>');
		// Redirects to the 'guru' page.
		redirect(base_url('guru'));
	}
}
