<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


    public function init_view_data() {
		$view_data['username'] = $this->session->userdata('username');
		$view_data['usertype'] = $this->session->userdata('usertype');

        
        $view_data['error'] = "";
        $view_data['config']['title1'] = "Bus";
        $view_data['config']['title2'] = "GPS";

        $view_data['nav'] = array();
        $base = base_url();

        $view_data['nav'][] = array("href" => $base  ."index.php/main/buses", "class"=> "fa fa-bus", "text"=>"Buses");
        $view_data['nav'][] = array("href" => $base  ."index.php/main/schedule", "class"=> "fa fa-calendar", "text"=>"Schedule");
        $view_data['nav'][] = array("href" => $base  ."index.php/main/monitor", "class"=> "fa fa-map-marker", "text"=>"Monitor");
 //       $view_data['nav'][] = array("href" => $base  ."index.php/main/users", "class"=> "fa fa-users", "text"=>"Users");


        return $view_data;
	}

	public function buses() {
        $view_data = $this->init_view_data();

        if ($this->session->userdata('username') == "") {

        	$this->load->view('login', $view_data);
        	#$this->load->view('starter', $view_data);
        } else {
           // if action is get load view else post ( add to model )
          if ($this->input->server('REQUEST_METHOD') == 'POST') {
              log_message("debug", "create bus");
              $this->load->model('buses');
              $bus = new buses();
              $bus->add_thru_post();
          }
          $view_data['ajaxtable'] = base_url() . "index.php/main/buses_list";
    	  $this->load->view('buses', $view_data);
		}

	}


   public function buses_list() {
       $this->load->model('buses');
       $bus = new buses();
       echo json_encode($bus->getList());
   }



	public function schedule() {
        $view_data = $this->init_view_data();

        if ($this->session->userdata('username') == "") {

        	$this->load->view('login', $view_data);
        	#$this->load->view('starter', $view_data);
        } else {
           // if action is get load view else post ( add to model )
          if ($this->input->server('REQUEST_METHOD') == 'POST') {
              $this->load->model('schedule');
              $sched = new schedule();
              $sched->add_thru_post();
          }
          $view_data['ajaxtable'] = base_url() . "index.php/main/schedule_list";
          $this->load->model('buses');
          $bus = new buses();
          $view_data['buses'] = $bus->getAll();
    	  $this->load->view('schedule', $view_data);
		}

	}


   public function schedule_list() {
       $this->load->model('schedule');
       $sched = new schedule();
       echo json_encode($sched->getList());
   }


	public function monitor() {
        $view_data = $this->init_view_data();

        if ($this->session->userdata('username') == "") {

        	$this->load->view('login', $view_data);
        	#$this->load->view('starter', $view_data);
        } else {
           // if action is get load view else post ( add to model )
 //         $view_data['map'] = "AIzaSyAf95jw2G_qM-_6h6-_gZth0473gMdQmLU";
          $view_data['map'] = "AIzaSyASyWNYgbgg3SQ5IieJvOOpnXgqknY1zL0";
    	  $this->load->view('monitor', $view_data);
		}

	}



	public function index() {
        $view_data = $this->init_view_data();

        if ($this->session->userdata('username') == "") {

        	$this->load->view('login', $view_data);
        	#$this->load->view('starter', $view_data);
        } else {
    	   // $this->load->view('main', $view_data);

          $view_data['ajaxtable'] = base_url() . "index.php/main/buses_list";
    	  $this->load->view('buses', $view_data);
		}

	}

  public function getsentitems () {
    $this->load->model('sentitems');
    $inc = new sentitems();
		$incident_data = $inc->getAll();

    echo json_encode($incident_data);

	}



  public function getIncidentJSON () {
    $this->load->model('incident_types');
    $inc = new incident_types();
		$incident_data = $inc->getIncidentJSON();

    echo json_encode($incident_data);

	}

  public function verify()
  {

    $this->load->model('user');
    $user = new user();

    $username = $this->input->post('username');
    $password = $this->input->post('password');

    log_message("debug", "verify");
    $view_data = $this->init_view_data();
    if ( $user->isPasswordOk($username, $password) ) {

      $userInfo = $user->getUserInfo($username, $password);
      $this->session->set_userdata('username', $username);
      $this->session->set_userdata('usertype', $userInfo->type);
      $this->session->set_userdata('userid', $userInfo->id);
      $this->session->set_userdata('login_state', TRUE);


      $temp  = base_url() . "" ;
	  redirect($temp);

    } else {
      $view_data['error'] = "Incorrect Username/Password!";
      $this->session->set_userdata('page', "");
      $this->load->view('login', $view_data);

    }

  }


  public function logout()
  {

    $this->session->sess_destroy();
    $this->session->set_userdata('login_state', FALSE);
    $this->session->set_userdata('username', "");
    $this->session->set_userdata('usertype', "");

		$temp  = base_url() . "" ;
		redirect($temp);
  }



	public function dashboard() {
    $view_data = $this->init_view_data();

    $this->load->model('operation_type');
    $op = new operation_type();
		$operations = $op->getAll();
    $ops = array();
    foreach ($operations as $operation) {
      $count = $this->getTableCount("SELECT * FROM incident WHERE operation_type=" . $operation->id );
			$temp =  array( "name" => $operation->operation, "count" => $count );
      $ops[] = $temp;
		}
    
		$view_data['operations'] = $ops;


    $this->load->model('incident_types');
    $it = new incident_types();
		$inc_types = $it->getAll();
    $icts = array();
    foreach ($inc_types as $in) {
      $count = $this->getTableCount("SELECT * FROM incident WHERE incident_type_id=" . $in->id );
			$temp =  array( "name" => $in->name, "count" => $count );
      $icts[] = $temp;
		}
    
		$view_data['incident_types_arr'] = $icts;









		
    $this->load->model('reference');
    $ref = new reference();
		
		// get data counts
		$view_data['message_recieved'] = $this->getTableCount("SELECT * FROM inbox");
		$view_data['message_sent'] = $this->getTableCount("SELECT * FROM sentitems");
		$view_data['incidents'] = $this->getTableCount("SELECT * FROM incident");
		$view_data['contacts'] = $this->getTableCount("SELECT * FROM contacts");
		$view_data['groups'] = $this->getTableCount("SELECT * FROM contact_group");
		$view_data['users'] = $this->getTableCount("SELECT * FROM users");
		$view_data['incident_types'] = $this->getTableCount("SELECT * FROM incident_types");
		$view_data['operation_types'] = $this->getTableCount("SELECT * FROM operation_type");
		$view_data['reference'] = $ref->getReference();
		$view_data['smart'] = $this->getTableCount("SELECT * FROM sentitems WHERE SenderID='smart' ");
		$view_data['globe'] = $this->getTableCount("SELECT * FROM sentitems WHERE SenderID='globe' ");

    


		$this->load->view('dashboard', $view_data);
	}

  public function getTableCount($query_str) {
		$query = $this->db->query($query_str);
    $total = $this->db->affected_rows();
    return $total;
	}











	public function messages() {
    $view_data = $this->init_view_data();
    $this->load->model('inbox');
    $inbox = new inbox();
		$view_data['messages'] = $inbox->getAll();
		$view_data['status'] = "inbox";
		$this->load->view('inbox', $view_data);
	
	}


	public function view_temp( $message_id ) {
    $view_data = $this->init_view_data();
    $temp  = base_url() . "#index.php/main/view_message/" . $message_id ;
		redirect($temp);
	
	}

	public function redirect_inbox(  ) {
    $temp  = base_url() . "#index.php/main/messages";
		redirect($temp);
	
	}


	
	public function view_message( $message_id ) {
    $view_data = $this->init_view_data();
    $this->load->model('inbox');
    $inbox = new inbox();
		$view_data['messages'] = $inbox->getMessage( $message_id );
		$view_data['message_id'] = $message_id;
		$view_data['status'] = "inbox";
		$this->load->view('view_message', $view_data);
	
	}



	public function sent() {
    $view_data = $this->init_view_data();
    $this->load->model('sentitems');
    $sentitems = new sentitems();
		$view_data['messages'] = $sentitems->getAll();
		$view_data['status'] = "sent";
		$this->load->view('sentitems', $view_data);
	
	}

	public function outbox() {
    $view_data = $this->init_view_data();
    $this->load->model('outbox');
    $outbox = new outbox();
		$view_data['messages'] = $outbox->getAll();
		$view_data['status'] = "queue";
		$this->load->view('outbox', $view_data);
	}


	public function draft() {
		$this->load->view('messages');
	}

	public function trash() {
   	$view_data = $this->init_view_data();
    $this->load->model('message');
    $message = new message();
		$view_data['messages'] = $message->getAllStat('trash');
		$view_data['status'] = "trash";
		$this->load->view('messages2', $view_data);
	
	}

	public function create() {

    $view_data = $this->init_view_data();
    $this->load->model('contact');
    $contact = new contact();
		$view_data['contacts'] = $contact->getAll();
		$this->load->view('create_message', $view_data);
	}

	public function create_incident() {

    $view_data = $this->init_view_data();
    $this->load->model('group');
    $this->load->model('incident_types');
    $this->load->model('reference');
    $this->load->model('cities');
    $this->load->model('operation_type');
    $city = new cities();
    $group = new group();
    $ref = new reference();
    $op = new operation_type();
    $ref_num = intval($ref->getReference()) + 1;
    $ref_num = str_pad($ref_num, 5, '0', STR_PAD_LEFT);
    $incident_type = new incident_types();
    
    $ref_number = "REF#" .date('y') . date('m') . "-" . $ref_num;


		$view_data['reference'] = $ref_number;
		$view_data['groups'] = $group->getAll();
		$view_data['cities'] = $city->getAll();
		$view_data['operations'] = $op->getAll();
		$view_data['incident_types'] = $incident_type->getAll();
		$view_data['sms_data'] = "";
		$view_data['report_from'] = "";
	
		$this->load->view('create_incident', $view_data);
	}


  public function red_forward( $id ) {

    $temp  = base_url() . "#index.php/main/forwardinbox/" . $id;
    redirect($temp);
  }



	public function forwardinbox( $id ) {


    $view_data = $this->init_view_data();
    $this->load->model('inbox');
    $inbox = new inbox();
    $message = $inbox->getMessage( $id );
    $view_data['message_id'] = $id;

    $this->load->model('group');
    $this->load->model('incident_types');
    $this->load->model('reference');
    $this->load->model('cities');
    $this->load->model('operation_type');
    $city = new cities();
    $group = new group();
    $ref = new reference();
    $op = new operation_type();
    $ref_num = intval($ref->getReference()) + 1;
    $ref_num = str_pad($ref_num, 5, '0', STR_PAD_LEFT);
    $incident_type = new incident_types();
    
    $ref_number = "REF#" .date('y') . date('m') . "-" . $ref_num;


		$view_data['reference'] = $ref_number;
		$view_data['groups'] = $group->getAll();
		$view_data['cities'] = $city->getAll();
		$view_data['operations'] = $op->getAll();
		$view_data['incident_types'] = $incident_type->getAll();
		$view_data['sms_data'] = $message[0]->TextDecoded;
		$view_data['report_from'] = $message[0]->contact_name . " on " . $message[0]->ReceivingDateTime;
	
		$this->load->view('create_incident', $view_data);
	}




	public function database_settings() {

    $view_data = $this->init_view_data();
		$this->load->view('database_settings', $view_data);
	}

	public function group_message() {

    $view_data = $this->init_view_data();
    $this->load->model('group');
    $group = new group();
		$view_data['groups'] = $group->getAll();
		$this->load->view('group_message', $view_data);

	}

	public function modems() {
    $view_data = $this->init_view_data();

    $this->load->model('modem');
    $modem = new modem();
		$view_data['modems'] = $modem->getAll();
		$this->load->view('modems', $view_data);
	}


	public function incidents() {
    $view_data = $this->init_view_data();

    $this->load->model('incident');
    $this->load->model('incident_types');
    $inc = new incident();
    $inc_typ = new incident_types();
		$view_data['incidents'] = $inc->getAll();
		$view_data['incident_types'] = $inc_typ->getAll();
		$this->load->view('incident_lists', $view_data);
	}


	public function groups() {
    $view_data = $this->init_view_data();

    $this->load->model('group');
    $group = new group();
		$view_data['groups'] = $group->getAll();
		$this->load->view('groups', $view_data);
	}

	public function delete_contact( $id ) {
    $view_data = $this->init_view_data();
    $this->load->model('contact');
    $contact = new contact();
    $contact->id = $id;
    $contact->delete();

    $temp  = base_url() . "#index.php/main/contacts";
		redirect($temp);
	}

	public function delete_group( $id ) {
    $view_data = $this->init_view_data();
    $this->load->model('group');
    $group = new group();
    $group->id = $id;
    $group->delete();

    $temp  = base_url() . "#index.php/main/groups";
		redirect($temp);
	}




	public function contacts() {
    $view_data = $this->init_view_data();

    $this->load->model('contact');
    $contact = new contact();
		$view_data['contacts'] = $contact->getAll();
		$this->load->view('contacts', $view_data);
	}

	public function users() {
    $view_data = $this->init_view_data();
    $this->load->model('user');
    $user = new user();
		$view_data['users'] = $user->getAll();
		$this->load->view('users', $view_data);
	}


	public function incident_types() {
    $view_data = $this->init_view_data();
    $this->load->model('incident_types');
    $incident_types = new incident_types();
		$view_data['incident_types'] = $incident_types->getAll();
		$this->load->view('incident_types', $view_data);
	}

	public function delete_inbox( $id ) {
    $view_data = $this->init_view_data();
    $this->load->model('inbox');
    $inbox = new inbox();
    $inbox->id = $id;
    $inbox->delete();

    $temp  = base_url() . "#index.php/main/messages";
		redirect($temp);
	}


	public function delete_sentitem( $id ) {
    $view_data = $this->init_view_data();
    $this->load->model('sentitems');
    $sentitems = new sentitems();
    $sentitems->id = $id;
    $sentitems->deleteID( $id);

    $temp  = base_url() . "#index.php/main/sent";
		redirect($temp);
	}




	public function delete_incident_types( $id ) {
    $view_data = $this->init_view_data();
    $this->load->model('incident_types');
    $incident_types = new incident_types();
    $incident_types->id = $id;
    $incident_types->delete();

    $temp  = base_url() . "#index.php/main/incident_types";
		redirect($temp);
	}

	public function contact_filtered() {
    $view_data = $this->init_view_data();

    $this->load->model('contact');
    $contact = new contact();
		$csv_str = $contact->getAllFilteredAsCSV();
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=contacts.csv');
		echo $csv_str;
	}

	public function message_filtered( $status ) {
    $view_data = $this->init_view_data();

    $this->load->model('message');
    $message = new message();
		$csv_str = $message->getAllFilteredAsCSV( $status );
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=message.csv');
		echo $csv_str;
	}

	public function inbox_filtered( ) {
    $view_data = $this->init_view_data();

    $this->load->model('inbox');
    $inbox = new inbox();
		$csv_str = $inbox->getAllFilteredAsCSV( );
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=inbox.csv');
		echo $csv_str;
	}

	public function outbox_filtered( ) {
    $view_data = $this->init_view_data();

    $this->load->model('outbox');
    $outbox = new outbox();
		$csv_str = $outbox->getAllFilteredAsCSV( );
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=outbox.csv');
		echo $csv_str;
	}

	public function sent_filtered( ) {
    $view_data = $this->init_view_data();

    $this->load->model('sentitems');
    $sentitems = new sentitems();
		$csv_str = $sentitems->getAllFilteredAsCSV( );
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=sentitems.csv');
		echo $csv_str;
	}


	public function user_filtered(  ) {
    $view_data = $this->init_view_data();

    $this->load->model('user');
    $user = new user();
		$csv_str = $user->getAllFilteredAsCSV( );
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=user.csv');
		echo $csv_str;
	}





	public function create_contact() {

    $view_data = $this->init_view_data();

    $this->load->model('group');
    $group = new group();
		$view_data['groups'] = $group->getAll();
		$this->load->view('create_contact', $view_data);
	}


	public function edit_contact( $id ) {

    $view_data = $this->init_view_data();
    $this->load->model('contact');
    $contact = new contact();
    $contact->id = $id;
    $contact->get();

    $this->load->model('group');
    $group = new group();
		$view_data['groups'] = $group->getAll();
		$view_data['contact'] = $contact;
		$this->load->view('edit_contact', $view_data);
	}


	public function update_contact( ) {

    $view_data = $this->init_view_data();
    $this->load->model('contact');
    $contact = new contact();
    $contact->update_thru_post();

    $temp  = base_url() . "#index.php/main/contacts";
		redirect($temp);
	}





	public function create_user() {

    $view_data = $this->init_view_data();
		$this->load->view('create_user', $view_data);
	}

	public function reference() {

    $view_data = $this->init_view_data();

    $this->load->model('reference');
    $ref = new reference();
    $view_data['reference'] = $ref->getReference();
		$this->load->view('reference', $view_data);
	}


	public function red_edit_incident( $id ) {

    $temp  = base_url() . "#index.php/main/edit_incident/" . $id;
		redirect($temp);

	}

	public function red_edit_contact( $id ) {

    $temp  = base_url() . "#index.php/main/edit_contact/" . $id;
		redirect($temp);

	}


	public function edit_incident( $id ) {

    $view_data = $this->init_view_data();
    $this->load->model('group');
    $this->load->model('incident_types');
    $this->load->model('incident');
    $this->load->model('cities');
    $this->load->model('operation_type');
    $city = new cities();
    $group = new group();
    $op = new operation_type();
    $inc = new incident();
    $inc->id = $id;
    $inc->get();
    $incident_type = new incident_types();
    
		$view_data['inc'] = $inc;
		$view_data['groups'] = $group->getAll();
		$view_data['cities'] = $city->getAll();
		$view_data['operations'] = $op->getAll();
		$view_data['incident_types'] = $incident_type->getAll();
		$view_data['sms_data'] = "";
		$view_data['report_from'] = "";
	
		$this->load->view('edit_incident', $view_data);
	}




	public function create_incident_type() {

    $view_data = $this->init_view_data();
		$this->load->view('create_incident_type', $view_data);
	}

	public function edit_incident_type( $incident_id) {

    $view_data = $this->init_view_data();
    $this->load->model('incident_types');
    $inc = new incident_types();
		$inc->id = $incident_id;
    $inc->get();
    $view_data['incident_name'] = $inc->name;
    $view_data['incident_id'] = $inc->id;
  
		$this->load->view('edit_incident_type', $view_data);
	}


	public function red_edit_incident_type( $id ) {

    $temp  = base_url() . "#index.php/main/edit_incident_type/" . $id;
		redirect($temp);

	}


	public function red_incident_sub_type( $id ) {

    $temp  = base_url() . "#index.php/main/add_incident_sub_type/" . $id;
		redirect($temp);

	}


	public function add_incident_sub_type( $id ) {

    $this->load->model('incident_types');
    $inc = new incident_types();
		$inc->id = $id;
    $inc->get();
    $view_data = $this->init_view_data();
    $this->load->model('subincident_type');
    $sub_inc = new subincident_type();
		$view_data['subtypes'] = $sub_inc->getAllWithIncidentType($id);
		$view_data['incident_id'] = $id;
		$view_data['incident_name'] = $inc->name;
		$this->load->view('add_subtype', $view_data);
	}


	public function submit_incident_sub_type( $id ) {

    $this->load->model('subincident_type');
    $sub_inc = new subincident_type();
    $sub_inc->add_thru_post();

    $temp  = base_url() . "#index.php/main/add_incident_sub_type/" . $id;
		redirect($temp);


	}


	public function delete_incident_sub_type( $id, $sub_id ) {

    $this->load->model('subincident_type');
    $sub_inc = new subincident_type();
    $sub_inc->id = $sub_id;
    $sub_inc->delete();

    $temp  = base_url() . "#index.php/main/add_incident_sub_type/" . $id;
		redirect($temp);


	}


	public function red_operation_type( $id ) {

    $temp  = base_url() . "#index.php/main/add_operation_type/" . $id;
		redirect($temp);

	}


	public function add_operation_type( ) {

    $view_data = $this->init_view_data();
    $this->load->model('operation_type');
    $op = new operation_type();
		$view_data['operations'] = $op->getAll();
		$this->load->view('add_operation', $view_data);
	}


	public function submit_operation_type( ) {

    $this->load->model('operation_type');
    $op = new operation_type();
    $op->add_thru_post();

    $temp  = base_url() . "#index.php/main/add_operation_type/";
		redirect($temp);


	}


	public function delete_operation_type( $id ) {

    $this->load->model('operation_type');
    $op = new operation_type();
    $op->id = $id;
    $op->delete();

    $temp  = base_url() . "#index.php/main/add_operation_type/";
		redirect($temp);


	}







	public function create_group() {
		$this->load->view('create_group');
	}

	public function submit_contact() {
    $view_data = $this->init_view_data();
    $this->load->model('contact');
    $contact = new contact();
    $contact->add_thru_post();
    $temp  = base_url() . "#index.php/main/create_contact";
		redirect($temp);
	}

	public function submit_user() {
    $view_data = $this->init_view_data();
    $this->load->model('user');
    $user = new user();
    $user->add_thru_post();
    $temp  = base_url() . "#index.php/main/create_user";
		redirect($temp);
	}

	public function submit_incident() {
    $view_data = $this->init_view_data();
    $this->load->model('incident');
    $inc = new incident();
    $inc->add_thru_post();
    $this->load->model('reference');
    $ref = new reference();
    $ref_num = intval($ref->getReference()) + 1;
    $ref_num = str_pad($ref_num, 5, '0', STR_PAD_LEFT);
    $ref->updateRef($ref_num);


    $temp  = base_url() . "#index.php/main/create_incident";
		redirect($temp);
	}


	public function submit_incident_update() {
    $view_data = $this->init_view_data();
    $this->load->model('incident');
    $inc = new incident();
    $inc->update_thru_post();

    $temp  = base_url() . "#index.php/main/incidents";
		redirect($temp);
	}





	public function submit_reference_number() {
    $view_data = $this->init_view_data();
    $this->load->model('reference');
    $ref = new reference();
    $ref->update_thru_post();
    $temp  = base_url() . "#index.php/main/reference";
		redirect($temp);
	}


	public function submit_incident_type() {
    $view_data = $this->init_view_data();
    $this->load->model('incident_types');
    $incident_type = new incident_types();
    $incident_type->add_thru_post();
    $temp  = base_url() . "#index.php/main/create_incident_type";
		redirect($temp);
	}

	public function update_incident_type() {
    $view_data = $this->init_view_data();
    $this->load->model('incident_types');
    $incident_type = new incident_types();
    $incident_type->update_thru_post();
    $temp  = base_url() . "#index.php/main/incident_types";
		redirect($temp);
	}


	public function submit_group() {
    $view_data = $this->init_view_data();
    $this->load->model('group');
    $group = new group();
    $group->add_thru_post();
    $temp  = base_url() . "#index.php/main/create_group";
		redirect($temp);
	}

	public function submit_message() {
    $view_data = $this->init_view_data();
    $this->load->model('message');
    $message = new message();
    $message->add_thru_post();
    $temp  = base_url() . "#index.php/main/create";
		redirect($temp);
	

	}

	public function reply_message() {
    $view_data = $this->init_view_data();
    $this->load->model('message');
    $message = new message();
    $message->add_thru_post();
    $temp  = base_url() . "#index.php/main/messages";
		redirect($temp);
	

	}

	public function submit_group_message() {
    $view_data = $this->init_view_data();
    $this->load->model('group');
    $group = new group();
    $group->sendToGroup();
    $temp  = base_url() . "#index.php/main/group_message";
		redirect($temp);
	

	}
  public function checkDuplicates() {

    $this->load->model('incident');
    $_incident = new incident();
    $_incident->checkDuplicates();
    
  }

	public function getCount () {
    $this->load->model('inbox');
    $inbox = new inbox();
		$count = $inbox->getUnreadCount();
		echo $count;
	}

  public function exportTable ($table ) {

   $this->load->model("operation_type");
   $_op = new operation_type();
   $select = "SELECT * FROM $table";
   $header = "";
   $data = "";
    $export = mysql_query ( $select ) or die ( "Sql error : " . mysql_error( ) );
    $fields = mysql_num_fields ( $export );
    $operation_tag = "";
    for ( $i = 0; $i < $fields; $i++ )
    {
      $header_temp = mysql_field_name( $export , $i );
      if ($header_temp == "coke_sachets") {
         $header_temp = "coke_packs";
      } else if ( $header_temp == "coke_grams") {
         $header_temp = "coke_blocks";
      }
      $header .= $header_temp . ",";
      if ( $header_temp == "operation_type") {
        $operation_tag = $i;
      }
    }
    while( $row = mysql_fetch_row( $export ) )
    {
        $line = '';
        $x = 0;
        foreach( $row as $value )
        {
          if ( ( !isset( $value ) ) || ( $value == "" ) ) {
            $value = ",";
           } else {
            $value = str_replace( '"' , '""' , $value );
            
            if ($operation_tag != "" && $x == $operation_tag) {
                $value = $_op->getOperationType($value);
            }

            $value = '"' . $value . '"' . ",";
           }
          $line .= $value;
          $x = $x + 1;
        }
       $data .= trim( $line ) . "\n";
    }
    $data = str_replace( "\r" , "" , $data );

    if ( $data == "" )
    {
      $data = "\n(0) Records Found!\n";
    }

		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$table.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo "$header\n$data";

	}




  public function export_incident ( ) {

   $this->load->model("operation_type");
   $_op = new operation_type();

   $inc_type = $this->input->post('incident_type');
   $from_date = $this->input->post('from_date');
   $to_date = $this->input->post('to_date');

   $select = "SELECT * FROM incident";
   $query_inc = "";
   if ( $inc_type > 0) {
     $query_inc = " incident_type_id = $inc_type "; 
   }
   $query_date = "";
   if ( $from_date != "" AND $to_date !="") {
      $from_date_s = explode("/",$from_date) ;
      $from_date = $from_date_s[2] . "-" . $from_date_s[0]. "-" . $from_date_s[1];

      $to_date_s = explode("/",$to_date) ;
      $to_date = $to_date_s[2] . "-" . $to_date_s[0]. "-" . $to_date_s[1];
      $query_date = "(date BETWEEN '". $from_date ."' AND '". $to_date ."')";
   }

   if ($query_inc != "") {
       $select .= " WHERE " . $query_inc;

       if ( $query_date != "" ) {
           $select .= " AND " . $query_date;
       }
   } else {

       if ( $query_date != "" ) {
           $select .= " WHERE " . $query_date;
       }

   }
   


   $header = "";
   $data = "";
    $export = mysql_query ( $select ) or die ( "Sql error : " . mysql_error( ) );
    $fields = mysql_num_fields ( $export );
    $operation_tag = "";
    for ( $i = 0; $i < $fields; $i++ )
    {
      $header_temp = mysql_field_name( $export , $i );
      if ($header_temp == "coke_sachets") {
         $header_temp = "coke_packs";
      } else if ( $header_temp == "coke_grams") {
         $header_temp = "coke_blocks";
      }
      $header .= $header_temp . ",";
      if ( $header_temp == "operation_type") {
        $operation_tag = $i;
      }
    }
    while( $row = mysql_fetch_row( $export ) )
    {
        $line = '';
        $x = 0;
        foreach( $row as $value )
        {
          if ( ( !isset( $value ) ) || ( $value == "" ) ) {
            $value = ",";
           } else {
            $value = str_replace( '"' , '""' , $value );
            
            if ($operation_tag != "" && $x == $operation_tag) {
                $value = $_op->getOperationType($value);
            }

            $value = '"' . $value . '"' . ",";
           }
          $line .= $value;
          $x = $x + 1;
        }
       $data .= trim( $line ) . "\n";
    }
    $data = str_replace( "\r" , "" , $data );

    if ( $data == "" )
    {
      $data = "\n(0) Records Found!\n";
    }

		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=incidents.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo "$header\n$data";

	}






}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
