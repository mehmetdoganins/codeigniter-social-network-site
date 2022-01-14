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
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Full Name</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($followlist as $items) { ?>

                      <tr> 

                       <td><img src="<?php echo base_url(); echo $items['resim']; ?>" class="img-circle" style="height: 60px;"></td> 
                       <td><a href="<?php echo base_url('Anasayfa/profile/'.$items['id'].''); ?>"> <?php echo $items['isim']; ?><br>@<?php echo $items['username'] ?></a><br><?php echo $items['date'] ?></td>
                       

                     </tr>

                     

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
