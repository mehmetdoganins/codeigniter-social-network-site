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
    $info=$this->session->userdata('info'); $id=$this->uri->segment(3); $user=$this->dtbs->cek($id,'yonetici'); ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
         <div class="col-md-12 mt-3">
           <?php echo validation_errors(); ?>
           <div class="card col-md-12">
            <div class="card-body">
             <div class="col-12" id="accordion">

              <div class="card card-primary card-outline">
                <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                  <div class="card-header">
                    <h4 class="card-title w-100">
                     Profile Picture
                   </h4>
                 </div>
               </a>
               <div id="collapseOne" class="collapse show" data-parent="#accordion">
                <div class="card-body">
                  <form action="<?php echo base_url('Anasayfa/ppupdate'); ?>" method="post" enctype="multipart/form-data">
                   <input type="hidden" name="id" value="<?php echo $bilgi['id']; ?>">
                   <img id="blah" src="<?php echo base_url(); echo $bilgi['resim']; ?>" alt="your image" />
                   <input type='file' name="resim" onchange="readURL(this);" placeholder="dosya seçç" />
                   <input type="submit" value="Upluad" name="Upluad">
                 </form>
                 
               </div>
             </div>
           </div>
           <div class="card card-primary card-outline">
            <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
              <div class="card-header">
                <h4 class="card-title w-100">
                 Full Name
               </h4>
             </div>
           </a>
           <div id="collapseOne" class="collapse show" data-parent="#accordion">
            <div class="card-body">
             <form class="form-horizontal" action="<?php echo base_url('Anasayfa/nameupdate'); ?>" method="post">
               <div class="input-group input-group-sm mb-0">
                <input type="hidden" name="id" value="<?php echo $bilgi['id']; ?>">
                <input class="form-control form-control-sm" name="name" value="<?php echo $bilgi['isim']; ?>" placeholder="Full Name">
                <div class="input-group-append">
                 <button type="submit" class="btn btn-danger">Submit</button>
               </div>
             </div>
           </form>
         </div>
       </div>
     </div>
     <div class="card card-primary card-outline">
      <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
        <div class="card-header">
          <h4 class="card-title w-100">
            User Name
          </h4>
        </div>
      </a>
      <div id="collapseOne" class="collapse show" data-parent="#accordion">
        <div class="card-body">
         <form class="form-horizontal" action="<?php echo base_url('Anasayfa/usernameupdate'); ?>" method="post">
           <div class="input-group input-group-sm mb-0">
            <input type="hidden" name="id" value="<?php echo $bilgi['id']; ?>">
            <input class="form-control form-control-sm" name="username" value="<?php echo $bilgi['username']; ?>" placeholder="User Name">
            <div class="input-group-append">
             <button type="submit" class="btn btn-danger">Submit</button>
           </div>
         </div>
       </form>
     </div>
   </div>
 </div>
 <div class="card card-primary card-outline">
  <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
    <div class="card-header">
      <h4 class="card-title w-100">
       E-Mail
     </h4>
   </div>
 </a>
 <div id="collapseOne" class="collapse show" data-parent="#accordion">
  <div class="card-body">
   <form class="form-horizontal" action="<?php echo base_url('Anasayfa/emailupdate'); ?>" method="post">
     <div class="input-group input-group-sm mb-0">
      <input type="hidden" name="id" value="<?php echo $bilgi['id']; ?>">
      <input class="form-control form-control-sm" name="email" value="<?php echo $bilgi['email']; ?>" placeholder="E-Mail">
      <div class="input-group-append">
       <button type="submit" class="btn btn-danger">Submit</button>
     </div>
   </div>
 </form>
</div>
</div>
</div>
<div class="card card-primary card-outline">
  <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
    <div class="card-header">
      <h4 class="card-title w-100">
       Paswword
     </h4>
   </div>
 </a>
 <div id="collapseOne" class="collapse show" data-parent="#accordion">
  <div class="card-body">
   <form id="quickForm" action="<?php echo base_url('Anasayfa/passwordupdate'); ?>" method="post">
    <div class="card-body">
      <input type="hidden" name="id" value="<?php echo $bilgi['id']; ?>">
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="password" value="<?php echo $bilgi['sifre']; ?>" class="form-control" id="exampleInputPassword1" placeholder="Password">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="re_password" value="<?php echo $bilgi['sifre']; ?>" class="form-control" id="exampleInputPassword1" placeholder="Password">
      </div>
      
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
</div>
</div>
</div>
<div class="card card-primary card-outline">
  <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
    <div class="card-header">
      <h4 class="card-title w-100">
       Personel Information
     </h4>
   </div>
 </a>
 <div id="collapseOne" class="collapse show" data-parent="#accordion">
  <div class="card-body">
   <form class="form-horizontal" action="<?php echo base_url('Anasayfa/infoupdate'); ?>" method="post">
     <div class="input-group input-group-sm mb-0">
      <input type="hidden" name="id" value="<?php echo $bilgi['id']; ?>">
      <input class="form-control form-control-sm" name="info" value="<?php echo $bilgi['infos']; ?>" placeholder="Personel Information">
      <div class="input-group-append">
       <button type="submit" class="btn btn-danger">Submit</button>
     </div>
   </div>
 </form>
</div>
</div>
</div>
</div>


</div>
<!-- /.tab-pane -->
</div>
<!-- /.tab-content -->
</div><!-- /.card-body -->
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
