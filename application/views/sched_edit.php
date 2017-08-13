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
        <small>Edit Schedule </small>
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
        <div class="col-md-6">
          <div class="box">
          <div class="box-body box-profile">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Schedule</h3>
            </div>
            <!-- form content -->
            <form role='form' action='' method='post' enctype='multipart/form-data'>
            <input type="hidden" name="id" value="<?=$sched_id?>">
               <div class='box-body'>
               <div class='form-group'>
                   <label for='bus'>Bus Name</label>
                <select class='form-control' id='bus' name='bus' >
                    <? foreach ($buses as $bus) { ?>
                    <? if ($sched_data['bus_id'] == $bus->id ) { ?>
                    <option value='<?=$bus->id?>^<?=$bus->bus_name?>' selected><?=$bus->bus_name?></option>
                    <? } else { ?>
                    <option value='<?=$bus->id?>^<?=$bus->bus_name?>'><?=$bus->bus_name?></option>
                    <? } ?>
                    <? } ?>
               </select>
              </div>

               <div class='form-group'>
                   <label for='direction'>Direction Name</label>
                   <select class='form-control' id='direction' name='direction' >
                    <? if ($sched_data['direction'] == "NorthBound" ) { ?>
                       <option value='NorthBound' selected>NorthBound</option>
                       <option value='SouthBound'>SouthBound</option>
                    <? } else { ?>
                       <option value='SouthBound' selected >SouthBound</option>
                       <option value='NorthBound'>NorthBound</option>
                    <? } ?>
                    
                   </select>
              </div>
 

              <div class="bootstrap-timepicker">
                <div class="form-group">
                  <label>Time </label>

                  <div class="input-group">
                    <input type="text" id="time" name="time" class="form-control timepicker" value="<?=$sched_data['time']?>">

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
                   <input type='text' class='form-control' id='location' name='location' placeholder='Location' value='<?=$sched_data['location']?>'>
              </div>
    

               <div class='box-footer'>
                   <button type='submit' class='btn btn-primary'>Update Bus Schedule</button>
                   <a href="<?=$base?>index.php/main/sched_delete/<?=$sched_id?>" class='btn btn-danger'>Delete Bus Schedule</a>
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


