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
        $view_data['base'] = $base;

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

	public function bus_edit($bus_id) {
        $view_data = $this->init_view_data();

        if ($this->session->userdata('username') == "") {

        	$this->load->view('login', $view_data);
        	#$this->load->view('starter', $view_data);
        } else {
          $this->load->model('buses');
          $bus = new buses();
          $bus->id = $bus_id;
          $bus->get();
           // if action is get load view else post ( add to model )
          if ($this->input->server('REQUEST_METHOD') == 'POST') {
              log_message("debug", "create bus");
              $bus->update_thru_post();
              redirect("/main/buses");
          }
          $view_data['bus_data'] = $bus->get_data();
          $view_data['bus_id'] = $bus_id;
#          echo print_r($view_data);
          
   	  $this->load->view('bus_edit', $view_data);
		}

	}

	public function bus_delete($bus_id) {
        $view_data = $this->init_view_data();

        if ($this->session->userdata('username') == "") {

        	$this->load->view('login', $view_data);
        	#$this->load->view('starter', $view_data);
        } else {
          $this->load->model('buses');
          $bus = new buses();
          $bus->id = $bus_id;
          $bus->get();
          //echo json_encode($bus->get_data());
          $bus->delete();
          redirect("/main/buses");

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

	public function sched_edit($sched_id) {
        $view_data = $this->init_view_data();

        if ($this->session->userdata('username') == "") {

        	$this->load->view('login', $view_data);
        	#$this->load->view('starter', $view_data);
        } else {
          $this->load->model('schedule');
          $sched = new schedule();
          $sched->id = $sched_id;
          $sched->get();
           // if action is get load view else post ( add to model )
          if ($this->input->server('REQUEST_METHOD') == 'POST') {
              log_message("debug", "create bus");
              $sched->update_thru_post();
              redirect("/main/schedule");
          }
          $view_data['sched_data'] = $sched->get_data();
          $view_data['sched_id'] = $sched_id;
#          echo print_r($view_data);
           $this->load->model('buses');
          $bus = new buses();
          $view_data['buses'] = $bus->getAll();
          
   	  $this->load->view('sched_edit', $view_data);
		}

	}

	public function sched_delete($sched_id) {
        $view_data = $this->init_view_data();

        if ($this->session->userdata('username') == "") {

        	$this->load->view('login', $view_data);
        	#$this->load->view('starter', $view_data);
        } else {
          $this->load->model('schedule');
          $sched = new schedule();
          $sched->id = $sched_id;
          $sched->delete();
          redirect("/main/schedule");

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
          $view_data['gps_url'] = "/index.php/main/gps_getall" ;
    	  $this->load->view('monitor', $view_data);
		}

	}


	public function track( $bus_id ) {
        $view_data = $this->init_view_data();

        if ($this->session->userdata('username') == "") {

        	$this->load->view('login', $view_data);
        	#$this->load->view('starter', $view_data);
        } else {
           // if action is get load view else post ( add to model )
 //         $view_data['map'] = "AIzaSyAf95jw2G_qM-_6h6-_gZth0473gMdQmLU";
          $view_data['map'] = "AIzaSyASyWNYgbgg3SQ5IieJvOOpnXgqknY1zL0";
          $view_data['gps_url'] = "/index.php/main/gps_getone/" . $bus_id ;
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



    public function gps($gps_id) {

       $long = $this->input->get('long');
       $lat = $this->input->get('lat');

       $this->load->model('buses');
       $bus = new buses();
       $bus->updateBusCoordinates($gps_id, $long, $lat);
       echo json_encode("ok " . $gps_id) ;
      return;

    }

    public function schedule_getall() {


       $this->load->model('schedule');
       $sched = new schedule();
       $data = $sched->getAll();
       $temp['schedules'] = $data;
       echo json_encode($temp) ;
      return;

    }


    public function gps_getone($bus_id) {


       $this->load->model('buses');
       $bus = new buses();
       $bus->id = $bus_id;
       $bus->get();
       $data = array();
       $data[] = $bus->get_data();
       echo json_encode($data) ;
      return;

    }



    public function gps_getall() {


       $this->load->model('buses');
       $bus = new buses();
       $data = $bus->getAll();
       echo json_encode($data) ;
      return;

    }

    public function gps_getall_mobile() {


       $this->load->model('buses');
       $bus = new buses();
       $data = $bus->getAll();
       $temp['locations'] = $data;
       echo json_encode($temp) ;
      return;

    }


    public function buses_getall() {


       $this->load->model('buses');
       $bus = new buses();
       $data = $bus->getAll();
       $temp['buses'] = $data;
       echo json_encode($temp) ;
      return;

    }





}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
