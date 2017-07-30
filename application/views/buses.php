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
        <small>Add / Delete Buses </small>
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
        <div class="col-md-3">
          <div class="box">
          <div class="box-body box-profile">
            <div class="box-header with-border">
              <h3 class="box-title">Create Bus</h3>
            </div>
            <!-- form content -->
            <form role='form' action='' method='post' enctype='multipart/form-data'>
               <div class='box-body'>
               <div class='form-group'>
                   <label for='company'>Company</label>
                   <input type='text' class='form-control' id='company' name='company' placeholder='Company' value=''>
              </div>

               <div class='form-group'>
                   <label for='bus_name'>Bus Name</label>
                   <input type='text' class='form-control' id='bus_name' name='bus_name' placeholder='Bus Name' value=''>
              </div>
 
               <div class='form-group'>
                   <label for='plate_number'>Plate Number</label>
                   <input type='text' class='form-control' id='plate_number' name='plate_number' placeholder='Plate Number' value=''>
              </div>
              <div class='form-group'>
                   <label for='route'>Route</label>
                   <input type='text' class='form-control' id='route' name='route' placeholder='Route' value=''>
              </div>
    
              <div class='form-group'>
                   <label for='gps_id'>GPS Id</label>
                   <input type='text' class='form-control' id='gps_id' name='gps_id' placeholder='GPS Id' value=''>
              </div>

               <div class='box-footer'>
                   <button type='submit' class='btn btn-primary'>Create Bus</button>
               </div>
               </div>
            </form>
            <!-- form content end-->

          </div>
          </div>
        </div>

        <div class="col-xs-9">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Bus Table</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">

                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="tableData" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Company</th>
                  <th>Bus Name</th>
                  <th>Plate Number</th>
                  <th>Route</th>
                  <th>GPS ID</th>
                  <th>Actions</th>
                </tr>
                </thead>
             </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
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


