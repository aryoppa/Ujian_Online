<?php 
defined('BASEPATH') OR exit('no direct script access allowed');

Class M_login extends CI_Model {

	/**
	 * This function attempts to log in a user by checking the provided credentials.
	 * 
	 * @param array $data Contains the username and password provided by the user.
	 * @return bool Returns true if the login is successful, false otherwise.
	 */
	public function login($data) 
	{
	    // Select the password field from the 'admin' table.
	    $this->db->select('password');
	    $this->db->from('admin');
	    // Apply a condition to the query to find the row with the matching username.
	    $this->db->where('username', $data['username']);
	    // Limit the results to 1 to ensure only one record is returned.
	    $this->db->limit(1);
	    // Execute the query and store the result.
	    $query = $this->db->get();

	    // Check if exactly one row is found with the provided username.
	    if ($query->num_rows() == 1) {
	    	// Retrieve the row as an associative array.
	    	$record = $query->row_array();
	    	// Verify the provided password against the hashed password in the database.
	    	return password_verify($data['password'], $record['password']);
	    } else {
	    	// If no matching record is found, or more than one record is found, return false.
	    	return false;
	    }
	}

}