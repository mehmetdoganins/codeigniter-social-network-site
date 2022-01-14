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
               <a href="<?php echo base_url('Anasayfa/useredit/'.$user['id'].'');?>" class="btn btn-outline-dark btn-block"><b>Settings</b></a>
             <?php }else{
              $limit=''; $kosul = array('teden'=>$teden, 'tedilen'=>$tedilen); $ifFollow=$this->dtbs->listen('friends',$limit,$kosul); foreach ($ifFollow as $value) {

              } 
              if ($ifFollow) {?>
               <a href="<?php echo base_url('Anasayfa/unfollow/'.$value['id'].'/'.$tedilen.''); ?>" class="btn btn-xs btn-outline-secondary btn-block"><b>Unfollow</b></a>
             <?php  }else{?>
               <a href="<?php echo base_url('Anasayfa/follow/'.$teden.'/'.$tedilen.''); ?>" class="btn btn-xs btn-outline-dark btn-block"><b>Follow</b></a>
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
        <?php if ($info) { ?>
          <div class="card">
            <?php if ($user['rank']==1) { $display=""; }else{ $display="d-none";} ?>
            <?php if ($user['id']==$info->id) { $display_form=""; }else{ $display_form="d-none";} ?>
            <?php if ($info) { $displey_sessions_form=""; }else{ $displey_sessions_form="d-none";} ?>

            <div class="card-body">
              <div class="tab-content <?php echo $displey_sessions_form; ?>">
                <div class="active tab-pane <?php echo $display_form; ?>" id="activity"  >

                 <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-xl">
                 <i class="far fa-newspaper"></i>
                </button>
                <div class="modal fade" id="modal-xl">
                  <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Extra Large Modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form class="form-group" action="<?php echo base_url('Anasayfa/postinsert'); ?>" method="post" enctype="multipart/form-data">
                          <div class="col-md-12 pb-2">
                            <input class="form-control mb-1" type="text" name="title" placeholder="Title">
                            <textarea name="post" id="summernote" rows="6" class="col-12 form-control"></textarea>
                            <input type="hidden" name="postTranslate">
                            <input id="file-upload-demo" type="file"  name="img" multiple>
                          </div>


                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-dark img-circle" data-dismiss="modal"><i class="fa fa-times"></i></button>
                            <button type="submit" class="btn btn-outline-dark img-circle"><i class="fa fa-check"></i></button>
                          </div>
                          <!-- /.modal -->
                        </form>
                      </div>

                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <?php echo $this->session->flashdata('durum'); ?>
                <!-- /.post -->
                <script>

                  $(document).ready(function () {

                    $("#file-upload-demo").fileinput({
                      'theme': 'explorer',
                      'uploadUrl': '<?php echo site_url('Anasayfa/postinsert');?>',
                      overwriteInitial: false,
                      name:'file',
                      initialPreviewAsData: true,
                      initialPreview: [

                      ],
                      initialPreviewConfig: [

                      ]
                    });
                  });

                </script>
              </div>
              <!-- /.tab-pane -->

              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      <?php } ?>

      <div class="card">
       <div class="col-md-12">
        <br />
        <div id="load_datap"></div>
        <br />
      </div>
    </div>
  </div>
  <!-- /.col -->


</div>
<!-- /.row -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php $this->load->view('front/include/footer'); ?>

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
