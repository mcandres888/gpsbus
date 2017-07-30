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
        Schedule
        <small>Add / Delete Schedules </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-calendar"></i> Schedule</a></li>
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
              <h3 class="box-title">Create Schedule</h3>
            </div>
            <!-- form content -->
            <form role='form' action='' method='post' enctype='multipart/form-data'>
               <div class='box-body'>
               <div class='form-group'>
                   <label for='bus'>Bus Name</label>
                <select class='form-control' id='bus' name='bus' >
                    <? foreach ($buses as $bus) { ?>
                    <option value='<?=$bus->id?>^<?=$bus->bus_name?>'><?=$bus->bus_name?></option>
                    <? } ?>
               </select>
              </div>

               <div class='form-group'>
                   <label for='direction'>Direction Name</label>
                   <select class='form-control' id='direction' name='direction' >
                       <option value='NorthBound'>NorthBound</option>
                       <option value='SouthBound'>SouthBound</option>
                   </select>
              </div>
 

              <div class="bootstrap-timepicker">
                <div class="form-group">
                  <label>Time </label>

                  <div class="input-group">
                    <input type="text" id="time" name="time" class="form-control timepicker">

                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
              </div>

              <div class='form-group'>
                   <label for='route'>Location</label>
                   <input type='text' class='form-control' id='location' name='location' placeholder='Location' value=''>
              </div>
    

               <div class='box-footer'>
                   <button type='submit' class='btn btn-primary'>Create Bus Schedule</button>
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
                  <th>Bus Name</th>
                  <th>Direction</th>
                  <th>Time</th>
                  <th>Location</th>
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


