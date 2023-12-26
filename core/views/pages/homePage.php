<?php $this->layout('layout', ['title' => 'Home']) ?>

<?php $this->start('body') ?>

<div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-interval="3000">
      <img src="/images/homePage/slide1.png" class="d-block w-100" alt="Slide 1">
    </div>
    <div class="carousel-item" data-bs-interval="3000">
      <img src="/images/homePage/slide2.png" class="d-block w-100" alt="Slide 2">
    </div>
    <div class="carousel-item" data-bs-interval="3000">
      <img src="/images/homePage/slide3.png" class="d-block w-100" alt="Slide 3">
    </div>
    <div class="carousel-item" data-bs-interval="3000">
      <img src="/images/homePage/slide4.png" class="d-block w-100" alt="Slide 3">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<div class="content-container">
  <div class="row gy-3">
    <div class="col-sm-8">
      <!-- card -->
      <div class="card">
        <h5 class="card-header">THÔNG TIN - SỰ KIỆN</h5>
        <div class="card-body">
          <h5 class="card-title">Chào tân sinh viên K75</h5>
          <p class="card-text">No Content</p>
          <a href="#" class="btn btn-primary">Xem chi tiết</a>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <!-- card -->
      <div class="card">
        <h5 class="card-header">THÔNG BÁO</h5>
        <div class="card-body">
          <h5 class="card-title">Thông báo lịch thi K72</h5>
          <p class="card-text">No Content</p>
          <a href="#" class="btn btn-primary">Xem chi tiết</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $this->stop() ?>