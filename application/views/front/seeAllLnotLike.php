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
        <div class="items">
          <div class="col-12">
            <!-- Default box -->
            <div class="card mt-3">

              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Full Name</th>
                      <th>Post</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($followlist as $items) {
                      if (substr(strrchr($items['img'],'.'),1)=="mp4" or substr(strrchr($items['img'],'.'),1)=="mp4") {
                        $file='<video class="" controls>
                        <source src="'.base_url().$items['img'].'" type="video/'.substr(strrchr($items['img'],'.'),1).'">
                        <source src="'.base_url().$items['img'].'" type="video/ogg">
                        Your bitemsser does not support the video tag.
                        </video><br>';
                      }elseif($items['img']==null){
                        $file="";
                      }elseif(substr(strrchr($items['img'],'.'),1)=="pdf"){
                        $file='<embed class="pdff" src="'.base_url().$items['img'].'" type="application/pdf"">';

                      }elseif(substr(strrchr($items['img'],'.'),1)=="wav" or substr(strrchr($items['img'],'.'),1)=="amr" or substr(strrchr($items['img'],'.'),1)=="mp3" ){ 
                        $file='<audio controls>
                        <source src="'.base_url().$items['img'].'" type="audio/ogg">
                        <source src="'.base_url().$items['img'].'" type="audio/'.substr(strrchr($items['img'],'.'),1).'">
                        Tarayıcınız audio elementini desteklemiyor.
                        </audio><br>';
                      }else{
                        $file='<a href="'.base_url().$items['img'].'?text=1" data-toggle="lightbox" data-gallery="gallery'.$items['idi'].'">
                        <img src="'.base_url().$items['img'].'" class="img-fluid videoo mb-2" alt="white sample"/>
                        </a><br>';
                      }


                      if ($items['type']=='post') { ?>
                       <tr> 
                         <td><img src="<?php echo base_url(); echo $items['resim']; ?>" class="img-circle" style="height: 60px;"></td> 
                         <td><a href="<?php echo base_url('Anasayfa/profile/'.$items['id'].''); ?>"> <?php echo $items['isim']; ?></a><br> Gönderine yorum yaptı <br><?php echo $items['notificationDate'] ;?></td>
                         <td><?php echo kisalt($items['content'],400);?><br><?php echo $file; ?></td>

                       </tr>
                     <?php }elseif($items['type']=='comment'){?>
                       <td><img src="<?php echo base_url(); echo $items['resim']; ?>" class="img-circle" style="height: 60px;"></td> 
                       <td><a href="<?php echo base_url('Anasayfa/profile/'.$items['id'].''); ?>"> <?php echo $items['isim']; ?></a><br>Yorumuna yorum yaptı <br><?php echo $items['notificationDate'] ;?></td>
                       <td><?php echo kisalt($items['comment'],400);?><br><?php echo $file; ?></td>

                     </tr>
                   <?php  }elseif($items['type']=='postLike'){?>
                     <td><img src="<?php echo base_url(); echo $items['resim']; ?>" class="img-circle" style="height: 60px;"></td> 
                     <td><a href="<?php echo base_url('Anasayfa/profile/'.$items['id'].''); ?>"> <?php echo $items['isim']; ?></a><br>Gönderini beğendi<br><?php echo $items['notificationDate'] ;?></td>
                     <td><?php echo kisalt($items['content'],400);?><br><?php echo $file; ?></td>

                   </tr>
                 <?php  }else{ ?>
                  <tr> 
                    <td><img src="<?php echo base_url(); echo $items['resim']; ?>" class="img-circle" style="height: 60px;"></td> 
                    <td><a href="<?php echo base_url('Anasayfa/profile/'.$items['id'].''); ?>"> <?php echo $items['isim']; ?></a><br> Yorumunu Beğendi <br><?php echo $items['notificationDate'] ;?></td>
                    <td><?php echo kisalt($items['comment'],400);?><br><?php echo $file; ?></td>

                  </tr>
                <?php } ?>






              <?php } ?>

            </table>
          </div>

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
<script src="<?php echo base_url('assets/front/template/'); ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/front/template/'); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url('assets/front/template/'); ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
