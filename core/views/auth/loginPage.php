<?php $this->layout('layout', ['title' => 'Login']) ?>

<?php $this->start('body') ?>

<section class="gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5">

            <form method="post" id="loginForm">
              <h2 class="fw-bold mb-2 text-uppercase text-center">Đăng nhập</h2>
              <p class="text-white-50 mb-5 text-center">Vui lòng nhập tài khoản và mật khẩu admin!</p>

              <div class="form-floating mb-4">
                <input type="text" name="userLogin" id="floatingInput" class="form-control form-control-lg" placeholder="Username" />
                <label class="text-dark" for="floatingInput">Username</label>
              </div>

              <div class="form-floating mb-4">
                <input type="password" name="passLogin" id="floatingPassword" class="form-control form-control-lg" placeholder="Password" />
                <label class="text-dark" for="floatingPassword">Password</label>
              </div>

              <div class="text-center">
                <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#">Quên mật khẩu?</a></p>
                <button class="btn btn-outline-light btn-lg px-5" type="submit">Đăng nhập</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="/script/auth/Login.js"></script>

<?php $this->stop() ?>