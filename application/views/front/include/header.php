        <?php $info= $this->session->userdata('info'); ?>
        <div class="wrapper">
          <!-- Navbar -->
          <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
              </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
              <!-- Navbar Search -->

              <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                  <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                  <form class="form-inline">
                    <div class="input-group input-group-sm">
                      <div id="prefetch" id="widts">
                       <input type="Search" name="search_box" id="search_box" class="form-control input-lg typeahead form-control-navbar" placeholder="Search Here" />
                     </div>
                     <div class="input-group-append">
                      <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>
            <?php if ($info) {
              $display='';
            }else{
              $display='d-none';
            } ?>

            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown <?php echo $display; ?>">
              <a href="#" class="dropdown-togglef nav-link" data-toggle="dropdown">
                <span class="badge badge-warning navbar-badge countf"></span>
                <i class="fas fa-user-plus"></i>
              </a>
              <div class="dropdown-menu dropdown-menuf dropdown-menu-lg dropdown-menu-right">

              </div>
            </li>

            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown <?php echo $display; ?>">
              <a href="#" class="dropdown-togglelike nav-link" data-toggle="dropdown">
                <span class="badge badge-warning navbar-badge count"></span>
                <i class="far fa-bell"></i>
              </a>
              <div class="dropdown-menu dropdown-menulike dropdown-menu-lg dropdown-menu-right">


              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
              </a>
            </li>
            <?php if ($info) { ?>
             <?php 
             $id=$info->id; $user=$this->dtbs->cek($id,'yonetici'); ?>
             <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
               <?php if ($user['resim']=="") { ?>
                <img class="user-image img-circle elevation-2" src="<?php echo base_url('assets/front/image/unisexavatar.jpg'); ?>">
              <?php }else{ ?>
                <img src="<?php echo base_url(); echo $user['resim']; ?>" class="user-image img-circle elevation-2" alt="User Image">
              <?php } ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <!-- User image -->
              <li class="user-header bg-primary">
                <?php if ($user['resim']=="") { ?>
                  <img class="user-image img-circle elevation-2" src="<?php echo base_url('assets/front/image/unisexavatar.jpg'); ?>">
                <?php }else{ ?>
                  <img src="<?php echo base_url(); echo $user['resim']; ?>" class="img-circle elevation-2" alt="User Image">
                <?php } ?>
                <p>
                  <?php echo $user['isim']; ?>
                  <small>Member since Nov. 2021</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <a href="<?php echo base_url('Anasayfa/profile/'.$info->id.''); ?>" class="btn btn-default btn-flat">Profile</a>
                <a href="<?php echo base_url('Anasayfa/userexit'); ?>" class="btn btn-default btn-flat float-right">Sign out</a>
              </li>
            </ul>
          </li>

        <?php  }else{ ?>
          <li class="nav-item"> 
           <a class="nav-link"  href="<?php echo base_url('Anasayfa/login'); ?>">
            <i class="fas fa-sign-in-alt"></i>
          </a>
        </li>
      <?php } ?>

    </ul>
  </nav>
  <!-- /.navbar -->

  <?php $this->load->view('front/include/sidebar'); ?>