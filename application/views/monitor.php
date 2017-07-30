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
        Monitor
        <small>Track Buses </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-map-marker"></i> Monitor</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->

 <div id="map" style="height:80% ; width: 85%; position: absolute"></div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->




<?php
include "template/body_settings.php";
include "template/body_footer.php";
?>


