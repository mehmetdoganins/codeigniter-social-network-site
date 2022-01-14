<!DOCTYPE html>
<html lang="en" data-brk-skin="brk-green-1.css">

<?php $this->load->view('front/include/head'); ?>

<body>
  <div class="brk-loader">
    <div class="brk-loader__loader"></div>
  </div>

  <?php $this->load->view('front/include/header'); ?>
  <section>
    <div class="container mb-90 mt-200">
      <div class="text-center mb-70">
        <h3 class="title-lines-dotted font-color">
          <span class="line"></span>
          <span class="text">Sosyal Medya Paylaşımlarımız.</span>
          <span class="line"></span>
        </h3>
      </div>
    </div>
    <div class="main-wrapper">
    <main class="main-container">
      <div class="container-fluid mt-50">
        <div class="brk-gallery">
          <div class="row">
            <?php foreach ($info as $info) { ?>
              
          
            <div class="col-md-3">
              <div class="brk-gallery-card" data-brk-library="component__gallery">
                <img  src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo base_url(); echo $info['file']; ?>" alt="alt" class="brk-gallery-card__img lazyload">
                <a href="<?php echo base_url(); echo $info['file']; ?>" data-fancybox="gallery" class="icon__btn icon__btn-white icon__btn-lg icon__btn-circled brk-gallery-card__central-btn">
                  <i class="fas fa-search icon-inside" aria-hidden="true"></i>
                  <span class="before"></span>
                  <span class="after"></span>
                </a>
              </div>
            </div>
          <?php } ?>
           
            <div class="col-12 text-center mt-80 mb-80">
              <a href="#" class="icon__btn icon__btn-anim icon__btn-md icon__btn-invert" data-brk-library="component__button">
                <span class="before"></span>
                <i class="fal fa-sync" aria-hidden="true"></i>
                <span class="after"></span>
                <span class="bg"></span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
  </section>


  <?php $this->load->view('front/include/footer'); ?>

  <a href="#top" id="toTop"></a>
  <?php $this->load->view('front/include/script'); ?>
</body>

</html>