<!DOCTYPE html>
<html lang="ku">
<?php $this->load->view('front/include/head'); ?>
<body class="hold-transition sidebar-mini sidebar-collapse">
  <!-- Site wrapper -->
  <?php $this->load->view('front/include/header'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
       <?php 
    if ($this->uri->segment(3)=="") {
     redirect('Anasayfa');
   }
   $info=$this->session->userdata('info'); $id=$this->uri->segment(3); $user=$this->dtbs->cek($id,'yonetici');
   if ($user=="") {
     redirect('Anasayfa');
   }
   ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3 mt-3">

            <!-- Profile Image -->
              <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <?php if ($user['resim']=="") { ?>
                  <img src="<?php echo base_url('assets/front/image/unisexavatar.jpg'); ?>">
                <?php }else{ ?>
                 <img class="profile-user-img img-fluid img-circle"
                 src="<?php echo base_url(); echo $user['resim'];?>"
                 alt="User profile picture">
               <?php } ?>
             </div>
             <h3 class="profile-username text-center"><?php echo $user['isim'] ?></h3>
             <p class="text-muted text-center"><?php echo $user['infos'] ?> </p>
             <ul class="list-group list-group-unbordered mb-3">
              <?php $limit=''; $kosul = array('tedilen' =>$id ); $countteden=$this->dtbs->listen('friends',$limit,$kosul); ?>
              <li class="list-group-item">
                <b>Followers</b> <a href="<?php echo base_url('Anasayfa/followersList/'.$id.''); ?>" class="float-right"><?php echo count($countteden); ?></a>
              </li>
              <?php $kosul = array('teden' =>$id ); $counttedilen=$this->dtbs->listen('friends',$limit,$kosul); ?>
              <li class="list-group-item">
                <b>Following</b> <a href="<?php echo base_url('Anasayfa/followingsList/'.$id.''); ?>"  class="float-right"><?php echo count($counttedilen); ?></a>
              </li>
              <?php $kosul = array('kullanici_id' =>$id ); $countpost=$this->dtbs->listen('posts',$limit,$kosul); ?>
              <li class="list-group-item">
                <b>Posts</b> <a href="<?php echo base_url('Anasayfa/profile/'.$id.'') ?>" class="float-right"><?php echo count($countpost); ?></a>
              </li>
            </ul>
            <?php if ($info) {
             $teden=$info->id; $tedilen=$this->uri->segment(3); ?>
             <?php if ($teden==$tedilen) {?>
               <a href="<?php echo base_url('Anasayfa/useredit/'.$user['id'].'');?>" class="btn btn-success btn-block"><b>Settings</b></a>
             <?php }else{
              $limit=''; $kosul = array('teden'=>$teden, 'tedilen'=>$tedilen); $ifFollow=$this->dtbs->listen('friends',$limit,$kosul); foreach ($ifFollow as $value) {

              } 
              if ($ifFollow) {?>
               <a href="<?php echo base_url('Anasayfa/unfollow/'.$value['id'].'/'.$tedilen.''); ?>" class="btn btn-xs btn-outline-secondary btn-block"><b>Unfollow</b></a>
             <?php  }else{?>
               <a href="<?php echo base_url('Anasayfa/follow/'.$teden.'/'.$tedilen.''); ?>" class="btn btn-xs btn-outline-primary btn-block"><b>Follow</b></a>
             <?php  }}} ?>


           </div>
           <!-- /.card-body -->
         </div>
           <!-- /.card -->

           <!-- About Me Box -->
           <div class="card card-primary d-none">
            <div class="card-header">
              <h3 class="card-title">Tiştên Din</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <strong><i class="fas fa-language mr-1"></i> Werger</strong>

              <p class="text-muted">
                <button type="button" class="btn btn-primary form-control" >
                  ji bo wergerandinê li vir bikirtînin
                </button>
              </p>

              <hr>

              <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

              <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9 mt-3">

          <div class="card">
            <div class="col-md-12">
              <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                  <br />
                <div id="load_data_following"></div>
                <br />
                  <!-- /.item -->
                </ul>
              </div>
             

            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->


      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<footer class="main-footer">
  <div class="float-right d-none d-sm-block">
    <b>Version</b> 3.1.0
  </div>
  <strong>Copyright &copy; 2014-2021 <a href="">NesneTeknoloji</a>.</strong> All rights reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php $this->load->view('front/include/script'); ?>
</body>
</html>
