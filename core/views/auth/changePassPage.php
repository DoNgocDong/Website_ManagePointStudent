<?php $this->layout('layout', ['title' => 'Change Password']) ?>

<?php $this->start('body') ?>

<section class="gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5">

            <form method="post" id="changePassForm">
              <h2 class="fw-bold mb-2 text-uppercase text-center">Đổi mật khẩu</h2>
              <p class="text-white-50 mb-5 text-center">Xác nhận mật khẩu cũ và mật khẩu mới!</p>

              <div class="form-floating mb-4">
                <input type="password" name="oldPass" id="floatingOldPassword" class="form-control form-control-lg" placeholder="Pass cũ" required/>
                <label class="text-dark" for="floatingOldPassword">old Password</label>
              </div>
              <div class="form-floating mb-4">
                <input type="password" name="newPass" id="floatingNewPassword" class="form-control form-control-lg" placeholder="Pass mới" required/>
                <label class="text-dark" for="floatingNewPassword">new Password</label>
              </div>
              <div class="form-floating mb-4">
                <input type="password" name="verifyPass" id="floatingVerifyPassword" class="form-control form-control-lg" placeholder="Xác nhận Pass mới" required/>
                <label class="text-dark" for="floatingVerifyPassword">verify Password</label>
              </div>

              <div class="text-center">
                <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#">Forgot password?</a></p>
                <button class="btn btn-outline-light btn-lg px-5" type="submit">Xác nhận</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="/script/auth/ChangePass.js"></script>

<?php $this->stop() ?>