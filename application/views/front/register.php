<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('front/include/head'); ?>
<body class="hold-transition register-page">
  <div class="register-box">
    <div class="register-logo">
      <a href="<?php echo base_url('assets/front/template/'); ?>index2.html"><b>Ark</b>FM</a>
    </div>

    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">Register a new membership</p>
        <?php echo validation_errors(); ?>
        <form action="<?php echo base_url('Anasayfa/registeri'); ?>" method="post">
          <div class="input-group mb-3">
            <input type="text" name="name" class="form-control" placeholder="Full name">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="userName">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="re_password" class="form-control" placeholder="Retype password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
             <button type="submit" class="btn btn-primary btn-block">Register</button>
           </div>
           <!-- /.col -->
         </div>
       </form>



       <a href="<?php echo base_url('Anasayfa/login'); ?>" class="text-center">I already have a membership</a>
     </div>
     <!-- /.form-box -->
   </div><!-- /.card -->
 </div>
 <!-- /.register-box -->

 <?php $this->load->view('front/include/script'); ?>
</body>
</html>
