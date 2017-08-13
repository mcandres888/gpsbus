<?php

# this wil act as the holder of the templates
include "template/body_header.php";
include "template/body_navbar_top.php";
include "template/body_navbar_right.php";
include "template/body_navbar_left.php";


# add content here
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Buses
        <small>Edit Bus </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-bus"></i> Buses</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->

 <div class="row">
        <div class="col-md-6">
          <div class="box">
          <div class="box-body box-profile">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Bus</h3>
            </div>
            <!-- form content -->
            <form role='form' action='' method='post' enctype='multipart/form-data'>
               <input type="hidden" name="id" value="<?=$bus_id?>">
               <div class='box-body'>
               <div class='form-group'>
                   <label for='company'>Company</label>
                   <input type='text' class='form-control' id='company' name='company' placeholder='Company' value='<?=$bus_data['company']?>'>
              </div>

               <div class='form-group'>
                   <label for='bus_name'>Bus Name</label>
                   <input type='text' class='form-control' id='bus_name' name='bus_name' placeholder='Bus Name' value='<?=$bus_data['bus_name']?>'>
              </div>
 
               <div class='form-group'>
                   <label for='plate_number'>Plate Number</label>
                   <input type='text' class='form-control' id='plate_number' name='plate_number' placeholder='Plate Number' value='<?=$bus_data['plate_number']?>'>
              </div>
              <div class='form-group'>
                   <label for='route'>Route</label>
                   <input type='text' class='form-control' id='route' name='route' placeholder='Route' value='<?=$bus_data['route']?>'>
              </div>
    
              <div class='form-group'>
                   <label for='gps_id'>GPS Id</label>
                   <input type='text' class='form-control' id='gps_id' name='gps_id' placeholder='GPS Id' value='<?=$bus_data['gps_id']?>'>
              </div>

               <div class='box-footer'>
                   <button type='submit' class='btn btn-primary'>Update Bus</button>
                   <a href="<?=$base?>index.php/main/bus_delete/<?=$bus_id?>" ><button  class='btn btn-danger'>Delete Bus</button></a>
               </div>
               </div>
            </form>
            <!-- form content end-->

          </div>
          </div>
        </div>

      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->









<?php
include "template/body_settings.php";
include "template/body_footer.php";
?>


