 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <?php $info= $this->session->userdata('info'); ?>
  <a href="<?php echo base_url(); ?>" class="brand-link">
    <img src="<?php echo base_url('assets/front/'); ?>image/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-bold"><span class="font-weight-bolder">Ark</span>Fm</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
   <?php if ($info) { $id=$info->id; $user=$this->dtbs->cek($id,'yonetici'); ?>
   <div class="user-panel mt-3 pb-3 mb-3 d-flex ">
    <div class="image">
      <?php if ($user['resim']=="") { ?>
        <img class="img-circle elevation-2" alt="User Image" src="<?php echo base_url('assets/front/image/unisexavatar.jpg'); ?>">
      <?php }else{ ?>
        <img src="<?php echo base_url(); echo $user['resim'];?>" class="img-circle elevation-2" alt="User Image">
      <?php } ?>
    </div>
    <div class="info">
      <a href="<?php echo base_url('Anasayfa/profile/'); echo $user['id'];?>" class="d-block"><?php echo $user['isim']; ?></a>
    </div>
  </div> 
<?php  }else{?>


  <div class="user-panel mt-3 pb-3 mb-3 d-flex">

    <a href="<?php echo base_url('Anasayfa/login'); ?>" class="info float-left">
      Login
    </a>

    <a href="<?php echo base_url('Anasayfa/register'); ?>" class="info float-right">
      Register
    </a>
  </div>
<?php } ?>
<!-- Sidebar user (optional) -->



<!-- Sidebar Menu -->
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
           <li class="nav-item">
            <a href="<?php echo base_url(); ?>" class="nav-link">
              <i class="fas fa-angle-left right"></i>
              <p class="link-size">Hello Meymûns</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-angle-left right"></i>
              <p class="link-size">Hûn Xulamên ARK Bibin Meymûn</p>
              <br><p class="badgei position-relative badge-danger text-left " style="width: 100%">Werger</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-angle-left right"></i>
              <p class="link-size">Birêz Arek</p>
              <br><p class="badgei position-relative badge-danger text-left " style="width: 100%">Min Pirsîyarek Heye</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-angle-left right"></i>
              <p class="link-size">Birêz Arek Kurdî Fêrî Min Bike</p>
              <br><p class="badgei position-relative badge-danger text-left " style="width: 100%">Dersên Kurdî</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-angle-left right"></i>
              <p class="link-size">Sîveeeeer</p>
              <br><p class="badgei position-relative badge-danger text-left " style="width: 100%">Wergerên Soranî - Kurmancî</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-angle-left right"></i>
              <p class="link-size">Kerem Bike Strana Xwe Bibêje</p>
              <br><p class="badgei position-relative badge-danger text-left " style="width: 100%">Deng û Stranên Xwe Bar Bikin</p>
            </a>
          </li>
          <li class="nav-item">
           <a href="#" class="nav-link"><i class="fas fa-angle-left right"></i>
            <p class="link-size">Mehsîn Giyan Dengit Zor Xoş e </p>
            <br><p class="badgei position-relative badge-danger " style="width: 100%">Bablîsoook An Jî Aqdenîz Aqşemlerîî</p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Dersên Gitarê</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Akorên Stranên Kurdî</p>
              </a>
            </li>
          </ul>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>