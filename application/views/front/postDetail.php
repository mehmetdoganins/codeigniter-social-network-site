<!DOCTYPE html>
<html lang="ku">
<?php $this->load->view('front/include/head'); ?>
<body class="hold-transition sidebar-mini sidebar-collapse">
  <!-- Site wrapper -->
  <?php $this->load->view('front/include/header'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <?php $info=$this->session->userdata('info'); ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid ">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card mt-3">

              <div class="card-body">
               <?php if ($row['resim']=="") {
                $img='assets/front/image/unisexavatar.jpg';
              }else{
                $img=$row['resim'];
              } 
              if (substr(strrchr($row['file'],'.'),1)=="mp4") {
                $file='<video class="videoo" controls>
                <source src="'.base_url().$row['file'].'" type="video/mp4">
                <source src="'.base_url().$row['file'].'" type="video/ogg">
                Your browser does not support the video tag.
                </video><br>';
              }elseif($row['file']==null){
                $file="";
              }elseif(substr(strrchr($row['file'],'.'),1)=="pdf"){
                $file='<embed class="pdff" src="'.base_url().$row['file'].'" type="application/pdf"">';

              }elseif(substr(strrchr($row['file'],'.'),1)=="wav" or substr(strrchr($row['file'],'.'),1)=="amr" or substr(strrchr($row['file'],'.'),1)=="mp3" ){ 
                $file='<audio controls>
                <source src="'.base_url().$row['file'].'" type="audio/ogg">
                <source src="'.base_url().$row['file'].'" type="audio/mpeg">
                Tarayıcınız audio elementini desteklemiyor.
                </audio><br>';
              }else{
                $file='<a href="'.base_url().$row['file'].'?text=1" data-toggle="lightbox" data-gallery="gallery'.$row['idi'].'">
                <img src="'.base_url().$row['file'].'" class="img-fluid videoo mb-2" alt="white sample"/>
                </a><br>';
              }
              $sart = array('post_id' =>$row['idi']);
              $comment_count=$this->dtbs->listele_sart('comments',$sart);
              $countt=count($comment_count); ?>
              <div class="post">
               <div class="user-block">
                 <a href="<?php echo base_url('Anasayfa/profile/'.$row['kullanici_id'].'') ?>"> <img class="img-circle img-bordered-sm" src="<?php echo base_url().$img ?>">
                   <span class="username">
                     <?php echo $row['isim']; ?>
                   </span></a>
                   <span class="description">Shared publicly - <?php echo $row['tarih']; ?></span>
                   <?php if (!$info=="" and $row['kullanici_id']==$info->id) { ?>
                     <div class="btn-group dropleft float-right">
                       <button type="button" class="btn btn-ligt dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       </button>
                       <div class="dropdown-menu">
                         <ul>
                           <li class="nav-link"><a href="<?php echo base_url('Anasayfa/postsil/'.$row['idi'].''); ?>" class="nav-item text-danger"> <i class="far fa-trash-alt"></i> Delete</a></li>
                         </ul>
                       </div>
                     </div>
                   <?php } ?>
                 </div>

                 <!-- /.user-block -->
                 <p>
                   <?php echo $row['content']; ?>
                 </p>
                 <?php echo $file; ?>
                 <a href="#" class="link-black text-sm mr-2 d-none"><i class="fas fa-share mr-1"></i> Share</a>
                 <a onclick="javascript:savelike(<?php echo $row['idi']; ?>);">
                   <i class="fa fa-thumbs-up"></i> 
                   <span id="like_<?php echo $row['idi']; ?>">
                     <?php echo $row['likes']; ?>
                   </span></a>
                   <a href="<?php echo base_url('Anasayfa/postDetail/'.$row['idi'].''); ?>" class="link-black text-sm float-right mb-2">
                     <i class="far fa-comments mr-1"></i> Comments (<?php echo $countt; ?>)
                   </a>
                   <?php if ($info) {?>
                    <form class="form-horizontal" action="<?php echo base_url('Anasayfa/commentsinsert'); ?>" method="post">
                     <div class="input-group input-group-sm mb-0">
                       <input class="form-control form-control-sm" name="comment" placeholder="Response">
                       <input type="hidden" value="<?php echo $info->id; ?>" name="user_id">
                       <input type="hidden" value="<?php echo $row['idi']; ?>" name="post_id">
                       <input type="hidden" name="uri" value="<?php echo $this->uri->segment(1) ?>">
                       <input type="hidden" name="uri1" value="<?php echo $this->uri->segment(2) ?>">
                       <input type="hidden" name="uri2" value="<?php echo $this->uri->segment(3) ?>">
                       <input type="hidden" value="post" name="type">

                       <input type="hidden" value="<?php echo $row['kullanici_id']; ?>" name="receiver_id">
                       <div class="input-group-append">
                         <button type="submit" class="btn btn-danger">Send</button>
                       </div>
                     </div>
                   </form>
                 <?php } ?>

               </div> 
               


               <?php foreach ($comment as  $commentsList) { 
                $sart = array('post_id' =>$commentsList['idi']);
                $comment_count=$this->dtbs->listele_sart('comments',$sart);
                $countt=count($comment_count);
                if ($commentsList['resim']=="") {
                  $img='assets/front/image/unisexavatar.jpg';
                }else{
                  $img=$commentsList['resim'];
                }
                ?>
                <div class="post">
                  <div class="user-block">
                    <a href="<?php echo base_url('Anasayfa/profile/'.$commentsList['user_id'].'') ?>"> <img class="img-circle img-bordered-sm" src="<?php echo base_url().$commentsList['resim']; ?>">
                      <span class="username">
                        <?php echo $commentsList['isim']; ?>
                      </span></a>
                      <span class="description">Shared publicly - <?php echo $commentsList['date']; ?></span>
                    </div>
                    <!-- /.user-block -->
                    <p>
                      <?php echo $commentsList['comment']; ?>
                    </p>
                    <a href="#" class="link-black text-sm mr-2 d-none"><i class="fas fa-share mr-1"></i> Share</a>
                    <a onclick="javascript:saveCommetlike(<?php echo $commentsList['idi']; ?>);">
                      <i class="fa fa-thumbs-up"></i> 
                      <span id="like_<?php echo $commentsList['idi']; ?>">
                        <?php echo $commentsList['likes']; ?>
                      </span></a>
                      <a href="<?php echo base_url('Anasayfa/commentDetail/'.$commentsList['idi'].''); ?>" class="link-black text-sm float-right mb-2">
                        <i class="far fa-comments mr-1"></i> Comments (<?php echo $countt; ?>)
                      </a>
                    </div> 
                  <?php  } ?>

                </div>
                <!-- /.card-body -->

              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.1.0
      </div>
      <strong>Copyright &copy; 2014-2021 <a href="">Asayîşa Rêzimana Kurdî</a>.</strong> All rights reserved.
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
