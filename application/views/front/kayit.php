<!DOCTYPE html>
<html lang="en" data-brk-skin="brk-green-1.css">

<?php $this->load->view('front/include/head'); ?>

<body>
  <div class="brk-loader">
    <div class="brk-loader__loader"></div>
  </div>
  <style> #rev_slider_18_1_wrapper .tp-loader.spinner2{ background-color: #0071fc !important; } </style>
  <style>.brk-castom-btn.rev-btn.rev-withicon i{margin-left:0 !important; margin-right:10px !important; vertical-align:0; top:-1px}.brk-castom-btn-1.rev-btn.rev-withicon i{vertical-align:2px}</style>
  <style>.custom.tparrows{cursor:pointer;background:#000;background:rgba(0,0,0,0.5);width:40px;height:40px;position:absolute;display:block;z-index:100}.custom.tparrows:hover{background:#000}.custom.tparrows:before{font-family:"revicons";font-size:15px;color:#fff;display:block;line-height:40px;text-align:center}.custom.tparrows.tp-leftarrow:before{content:"\e824"}.custom.tparrows.tp-rightarrow:before{content:"\e825"}</style>
  <div class="main-page">
    <?php $this->load->view('front/include/header'); ?>
 
    
    <section class="mt-100 pt-100">
      <div class="">
      <div class="container border border-primary d-flex justify-content-center mt-5">
        <div class="col-md-4 mt-5 mb-5  ">
          <form class="" method="post" action="<?php echo base_url('anasayfa/kayitekle '); ?>">
              <div class="form-group">
                <label for="">İsim</label>
                <input type="text" class="form-control" name="isim">
              </div>
              <div class="form-group">
                <label for="">Soyisim</label>
                <input type="text" class="form-control" name="soyisim">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Lütfen mail adresinizi girin">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Parola</label>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Lütfen parolanızı girin.">
              </div>
              <button type="submit" class="btn btn-primary">Kayit OL</button>
          </form>
        </div>
      </div>
    </div>
    </section>
 
  </div>
  <a href="#top" id="toTop"></a>
 <?php $this->load->view('front/include/script'); ?>
</body>

</html>