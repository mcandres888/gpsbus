<?php


class Schedule extends CI_Model {
	
    
    var $caller ;
    var $table_name = 'schedule';
    	
    var $id;
    var $bus_id;
    var $bus_name;
    var $direction;
    var $time;
    var $location;

   
	function __construct() {
 		// Call the Model constructor
   	parent::__construct();
		$this->caller =& get_instance();
 	}
  



	function get_data () {
  	$data = array(
			'bus_id' => $this->bus_id,
			'bus_name' => $this->bus_name,
			'direction' => $this->direction,
			'time' => $this->time,
			'location' => $this->location,
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
			$this->bus_id = $row->bus_id;
			$this->bus_name = $row->bus_name;
			$this->direction = $row->direction;
			$this->time = $row->time;
			$this->location = $row->location;
		}
	}
    
	function add_thru_post ( ) {
		// get the information first and update the model
		$bus = $this->caller->input->post('bus');

        $split = explode("^", $bus);

		$this->bus_id = $split[0];
		$this->bus_name = $split[1];
		$this->direction = $this->caller->input->post('direction');
		$this->time = $this->caller->input->post('time');
		$this->location = $this->caller->input->post('location');


		// then add the instance of that model
		$id = $this->add();
		return $id;
	}
		
	function update_thru_post () {
		// get the information first and update the model
		$this->id = $this->caller->input->post('id');
		$bus = $this->caller->input->post('bus');

                $split = explode("^", $bus);

		$this->bus_id = $split[0];
		$this->bus_name = $split[1];

		$this->direction = $this->caller->input->post('direction');
		$this->time = $this->caller->input->post('time');
		$this->location = $this->caller->input->post('location');




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
          $row->id = intval($row->id);
      $data[] = $row;
    }
    return $data;
	}


   function getList() {

       $draw = $this->caller->input->get("draw");
       $start = $this->caller->input->get("start");
       $length = $this->caller->input->get("length");
       $search = $this->caller->input->get("search")['value'] ;

       $tabledata = array();

       $query = $this->caller->db->query("SELECT * FROM $this->table_name");
       $tabledata['recordsFiltered'] = $this->caller->db->affected_rows();
       
       $query_str = "SELECT * FROM $this->table_name WHERE bus_name LIKE '%$search%' LIMIT $start,$length";
       $query = $this->caller->db->query($query_str);
       log_message("debug", "query $query_str");
       $tabledata['recordsTotal'] = $this->caller->db->affected_rows();
       $tabledata['draw'] = $draw + 1;
       $tabledata['data'] = array();
       $base = base_url() . "index.php/main";

   	   foreach ($query->result() as $row) {

         $temp = array();
         $temp[] = $row->bus_name;
         $temp[] = $row->direction;
         $temp[] = $row->time;
         $temp[] = $row->location;
         $actions = "<a href='$base/sched_edit/$row->id'><button type='button' class='btn btn-danger'> Edit </button></a>" ;


         $temp[] = $actions;
         $tabledata['data'][] = $temp;

       }
       return $tabledata;
	


   }


}
?>
