<?php


class User extends CI_Model {
	
    
    var $caller ;
    var $table_name = 'users';
    	
    var $id;
    var $username;
    var $password;
    var $firstname;
    var $lastname;
    var $type;

   
	function __construct() {
 		// Call the Model constructor
   	parent::__construct();
		$this->caller =& get_instance();
 	}
  
	function get_data () {
  	$data = array(
			'username' => $this->username,
			'password' => $this->password,
			'firstname' => $this->firstname,
			'lastname' => $this->lastname,
			'type' => $this->type,
    );
		return $data;
	}
   
	function add ( ) {
    // database insert
		$this->caller->db->insert($this->table_name, $this->get_data());
		// get the id from the last insert
		$this->id  = $this->caller->db->insert_id();
		return $this->id;		 
 	}
    
	function update ( ) {
		$this->caller->db->where('id', $this->id);
		// database update
		$this->caller->db->update($this->table_name, $this->get_data());    	
	}
    
	function delete ( ) {
		$query = $this->db->query("DELETE FROM $this->table_name WHERE id='$this->id'");
	}

	function get ( ) {
		$query = $this->caller->db->query("SELECT * FROM $this->table_name WHERE id='$this->id' LIMIT 1");
   	foreach ($query->result() as $row) {
			$this->id = $row->id;
			$this->username = $row->username;
			$this->firstname = $row->firstname;
			$this->lastname = $row->lastname;
			$this->type = $row->type;
		}
	}
    
	function add_thru_post ( ) {
		// get the information first and update the model
		$this->username = $this->caller->input->post('username');
		$this->password = $this->caller->input->post('password');
		$this->firstname = $this->caller->input->post('firstname');
		$this->lastname = $this->caller->input->post('lastname');
		$this->type = $this->caller->input->post('type');

		// then add the instance of that model
		$id = $this->add();
		return $id;
	}
		
	function update_thru_post () {
		// get the information first and update the model
		$this->id = $this->caller->input->get('id');
		$this->username = $this->caller->input->post('username');
		$this->password = $this->caller->input->post('password');
		$this->firstname = $this->caller->input->post('firstname');
		$this->lastname = $this->caller->input->post('lastname');
		$this->type = $this->caller->input->post('type');

		$this->update();
	}
	
	function delete_thru_post () {
		// get the information first and update the model
		$this->id = $this->caller->input->post('id');
		$this->delete();
	}

	function getAll () {
    $query = $this->caller->db->query("SELECT * FROM $this->table_name");
    $total = $this->caller->db->affected_rows();
		$data = array();
   	foreach ($query->result() as $row) {
      $data[] = $row;
    }
    return $data;
	}

 function getAllFilteredAsCSV () {
    $filter_arr = [];

    $search_username = $this->caller->input->post('search_username');
    if ($search_username != "Search username") {
      $filter_arr[] = " username LIKE '%". $search_username ."%' ";
    }

    $search_firstname = $this->caller->input->post('search_firstname');
    if ($search_firstname != "Search firstname") {
      $filter_arr[] = " firstname LIKE '%". $search_firstname ."%' ";
    }

    $search_lastname = $this->caller->input->post('search_lastname');
    if ($search_lastname != "Search lastname") {
      $filter_arr[] = " lastname LIKE '%". $search_lastname ."%' ";
    }

    $search_type = $this->caller->input->post('search_type');
    if ($search_type != "Search type") {
      $filter_arr[] = " type LIKE '%". $search_type ."%' ";
    }


    $query_str = "SELECT * FROM $this->table_name ";
    if (count($filter_arr) == 1)  {
      $query_str .= "WHERE " . $filter_arr[0];
    } else if ( count($filter_arr) > 1) {
      $query_str .= "WHERE " ;
      $x = 1;
      foreach ($filter_arr as $filter) {
        if ( $x > 1) {
          $query_str .= " AND " ;
        }
        $query_str .= $filter ;
        $x = $x + 1;
      }
    }

    $query = $this->caller->db->query($query_str);
    $total = $this->caller->db->affected_rows();
    $data = array();
    # add header
    $csv_str = "No.,Username,Firstname,Lastname,Type\n";
    $x = 1;
    foreach ($query->result() as $row) {
      $data[] = $row;
      $csv_str .= $x . "," . $row->username . "," . $row->firstname . "," . $row->lastname . "," . $row->type . "\n";
      $x = $x + 1;
    }
    return $csv_str;
  }



    function isPasswordOk ( $username, $password ) {

      $query = $this->caller->db->query("SELECT * FROM $this->table_name WHERE username='$username' AND password='$password' LIMIT 1");
      $result = $query->result();
      return count($result);
    }

    function getUserInfo ( $username, $password ) {

      $query = $this->caller->db->query("SELECT * FROM $this->table_name WHERE username='$username' AND password='$password' LIMIT 1");
      foreach ($query->result() as $row) {
          return $row;
      }
    }



}
?>
