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
                <?php $info=$this->session->userdata('info');  ?>
                <?php if ($info) { ?>
                  <?php $limit=""; $kosul = array('teden' =>$info->id); $counttedilen=$this->dtbs->listen('friends',$limit,$kosul); 
                  if (count($counttedilen)==0) {?>
                    <div class="callout callout-danger">
                      <h5>Welcome <?php echo $info->isim; ?>. You are not following anyone!</h5>
                      <p>When you follow someone, you will see the posts of those you follow here</p>
                    </div>
                  <?php }else{ ?>
                    <br />
                    <div id="load_data"></div>
                    <br />
                  <?php  } }else{?>
                   <div class="callout callout-info">
                    <h5>Please login to view the posts</h5>

                    <p></p>


                  </div>
                <?php } ?>



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
