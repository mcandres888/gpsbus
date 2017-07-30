<?php
include "template/body_header_login.php"
?>


<div class="login-box">
  <div class="login-logo">
    <a href=""><?=$config['title1']?><b><?=$config['title2']?></b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><?=$error?></p>

    <form action="<?=base_url()?>index.php/main/verify" method="post">
      <div class="form-group has-feedback">
        <input name="username" type="text" class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input name="password" type="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

   <div class="social-auth-links text-center">

 <!--   <a href="register.html" class="text-center">Register a new membership</a>
-->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->


<?php
include "template/body_footer.php"
?>

