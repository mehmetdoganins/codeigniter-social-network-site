<!DOCTYPE html>
<html lang="en">
<head>
  <?php $this->load->view('front/include/head'); ?>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="../../index2.html"><b>Ark</b>FM</a>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Sign in to start your session</p>
          <?php echo $this->session->flashdata('durum'); ?>

          <form action="<?php echo base_url('Anasayfa/loginn'); ?>" method="post">
            <div class="input-group mb-3">
              <input type="email" name="email" class="form-control" placeholder="Email">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" name="sifre" class="form-control" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">

              <!-- /.col -->
              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
              </div>

              <!-- /.col -->
              <div class="col-12">
                <p class="mb-0">
                  <a href="<?php echo base_url('Anasayfa/register'); ?>" class="text-center">Register a new membership</a>
                </p>
              </div>
              
            </div>
          </form>


        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->

    <?php $this->load->view('front/include/script'); ?>
  </body>
  </html>
