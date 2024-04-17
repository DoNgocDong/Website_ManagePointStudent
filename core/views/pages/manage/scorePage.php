<?php $this->layout("layout", ["title" => "Score Manager"]) ?>

<?php $this->start('body') ?>

<?php
  use App\Core\Controllers\Manage\StudentController;
  use App\Core\Controllers\Manage\CourseController;
  use App\Core\Controllers\Manage\ScoreController;

  $studentController = new StudentController();
  $courseController = new CourseController();
  $scoreController = new ScoreController();
?>

<div class="manager-page-title">
  <h1>QUẢN LÝ ĐIỂM</h1>
</div>
<div class="action-method">
  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addScoreModal">
    <i class="fa fa-plus-circle"></i> Thêm điểm
  </button>
</div>
<div class="display-table">
  <table id="table" class="table table-bordered align-middle mb-0 bg-white table-sm">
    <thead class="table-info align-middle">
      <tr>
        <th rowspan="2">Mã sinh viên</th>
        <th rowspan="2" class="col-2">Họ tên</th>
        <th rowspan="2" class="col-2">Tên môn</th>
        <th colspan="4" class="col-4 text-center">Điểm</th>
        <th rowspan="2">Học kỳ</th>
        <th rowspan="2" class="col-2 text-center">Hành động</th>
      </tr>
      <tr>
        <th class="text-center">Điểm CC</th>
        <th class="text-center">Điểm TH</th>
        <th class="text-center">Điểm GK</th>
        <th class="text-center">Điểm CK</th>
      </tr>
    </thead>
    <tbody>

      <?php
      $data = $scoreController->findAll();
      foreach ($data as $row) {
      ?>

        <tr>
          <td>
            <p class="fw-bold mb-1"> <?php echo $row["maSinhVien"] ?> </p>
          </td>
          <td>
            <p class="fw-bold mb-1"> <?php echo $row["hoTen"] ?> </p>
          </td>
          <td>
            <p class="fw-bold mb-1"> <?php echo $row["tenMon"] ?> </p>
          </td>
          <td class="text-center">
            <span class="badge text-bg-info"> <?php echo $row["diemCC"] ?> </span>
          </td>
          <td class="text-center">
            <span class="badge text-bg-info"> <?php echo $row["diemTH"] ?> </span>
          </td>
          <td class="text-center">
            <span class="badge text-bg-info"> <?php echo $row["diemGK"] ?> </span>
          </td>
          <td class="text-center">
            <span class="badge text-bg-info"> <?php echo $row["diemCK"] ?> </span>
          </td>
          <td class="text-center">
            <p class="fw-bold mb-1"> <?php echo $row["hocKy"] ?> </p>
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-link btn-rounded" title="Edit" 
              onclick="getDataById(<?php echo $row['id'] ?>)">
              <i class="fa fa-pencil"></i>
            </button>

            <button type="button" class="btn btn-link btn-rounded" title="Remove" 
              onclick="deleteScore(<?php echo $row['id'] ?>)">
              <i class="fa fa-trash"></i>
            </button>
          </td>
        </tr>

      <?php } ?>

    </tbody>
  </table>
</div>

<!-- ===================Modal==================== -->

<!-- Add class modal -->
<form method="post" id="addScoreForm">
  <div class="modal fade" id="addScoreModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">THÊM ĐIỂM</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row g-3 needs-validation">

          <div class="col-md-4 position-relative">
            <label for="cmbMsv" class="form-label">Mã sinh viên</label>
            <select class="form-select" id="cmbMsv" name="maSinhVien" required>
              <option value="">---Chọn---</option>

              <?php
              $data = $studentController->findColumns(["maSinhVien"]);
              foreach ($data as $options) {
              ?>
                <option value="<?php echo $options["maSinhVien"] ?>">
                  <?php echo $options["maSinhVien"] ?>
                </option>
              <?php } ?>

            </select>
          </div>
          <div class="col-md-5 position-relative">
            <label for="validateName" class="form-label">Họ tên</label>
            <input type="text" class="form-control" id="validateName" name="hoTen" readonly>
          </div>
          <div class="col-md-3 position-relative">
            <label for="validateClass" class="form-label">Lớp</label>
            <input type="text" class="form-control" id="validateClass" name="lop" readonly>
          </div>

          <div class="col-md-4 position-relative">
            <label for="cmbMaMon" class="form-label"> Mã môn </label>
            <select class="form-select" id="cmbMaMon" name="maMon" required>
              <option value="">---Chọn---</option>

              <?php
                $data = $courseController->findColumns(["maMon"]);
                foreach ($data as $options) {
              ?>
                <option value="<?php echo $options["maMon"] ?>">
                  <?php echo $options["maMon"] ?>
                </option>
              <?php } ?>

            </select>
          </div>
          <div class="col-md-6 position-relative">
            <label for="validateTenMon" class="form-label"> Tên môn </label>
            <input type="text" class="form-control" id="validateTenMon" name="tenMon" readonly>
          </div>
          <div class="col-md-2 position-relative">
            <label for="validateHocKy" class="form-label"> Học kỳ </label>
            <input type="number" class="form-control" id="validateHocKy" name="hocKy" readonly>
          </div>

          <hr>
          <h2 class="fs-5 text-center">Nhập điểm</h2>

          <div class="col-md-6 position-relative">
            <label for="diemCC" class="form-label">Điểm Chuyên cần</label>
            <input type="number" class="form-control" id="diemCC" min="0" max="10" name="diemCC" step=".1" required>
          </div>
          <div class="col-md-6 position-relative">
            <label for="diemTH" class="form-label">Điểm Thực hành</label>
            <input type="number" class="form-control" id="diemTH" min="0" max="10" name="diemTH" step=".1" required>
          </div>
          <div class="col-md-6 position-relative">
            <label for="diemGK" class="form-label">Điểm Giữa kỳ</label>
            <input type="number" class="form-control" id="diemGK" min="0" max="10" name="diemGK" step=".1" required>
          </div>
          <div class="col-md-6 position-relative">
            <label for="diemCK" class="form-label">Điểm Cuối kỳ</label>
            <input type="number" class="form-control" id="diemCK" min="0" max="10" name="diemCK" step=".1" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
          <button type="submit" class="btn btn-primary">ADD</button>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- Update class modal -->
<form method="post" id="updateScoreForm">
  <div class="modal fade" id="updateScoreModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">SỬA ĐIỂM</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row g-3 needs-validation">

          <div class="col-md-4 position-relative">
            <label for="cmbMsv" class="form-label">Mã sinh viên</label>
            <select class="form-select" id="cmbMsv" name="maSinhVien" required>
              <option value="">---Chọn---</option>

              <?php
              $data = $studentController->findColumns(["maSinhVien"]);
              foreach ($data as $options) {
              ?>
                <option value="<?php echo $options["maSinhVien"] ?>">
                  <?php echo $options["maSinhVien"] ?>
                </option>
              <?php } ?>

            </select>
          </div>
          <div class="col-md-5 position-relative">
            <label for="validateName" class="form-label">Họ tên</label>
            <input type="text" class="form-control" id="validateName" name="hoTen" readonly>
          </div>
          <div class="col-md-3 position-relative">
            <label for="validateClass" class="form-label">Lớp</label>
            <input type="text" class="form-control" id="validateClass" name="lop" readonly>
          </div>

          <div class="col-md-4 position-relative">
            <label for="cmbMaMon" class="form-label"> Mã môn </label>
            <select class="form-select" id="cmbMaMon" name="maMon" required>
              <option value="">---Chọn---</option>

              <?php
                $data = $courseController->findColumns(["maMon"]);
                foreach ($data as $options) {
              ?>
                <option value="<?php echo $options["maMon"] ?>">
                  <?php echo $options["maMon"] ?>
                </option>
              <?php } ?>

            </select>
          </div>
          <div class="col-md-6 position-relative">
            <label for="validateTenMon" class="form-label"> Tên môn </label>
            <input type="text" class="form-control" id="validateTenMon" name="tenMon" readonly>
          </div>
          <div class="col-md-2 position-relative">
            <label for="validateHocKy" class="form-label"> Học kỳ </label>
            <input type="number" class="form-control" id="validateHocKy" name="hocKy" readonly>
          </div>

          <hr>
          <h2 class="fs-5 text-center">Nhập điểm</h2>

          <div class="col-md-6 position-relative">
            <label for="diemCC" class="form-label">Điểm Chuyên cần</label>
            <input type="number" class="form-control" id="diemCC" min="0" max="10" name="diemCC" step=".1" required>
          </div>
          <div class="col-md-6 position-relative">
            <label for="diemTH" class="form-label">Điểm Thực hành</label>
            <input type="number" class="form-control" id="diemTH" min="0" max="10" name="diemTH" step=".1" required>
          </div>
          <div class="col-md-6 position-relative">
            <label for="diemGK" class="form-label">Điểm Giữa kỳ</label>
            <input type="number" class="form-control" id="diemGK" min="0" max="10" name="diemGK" step=".1" required>
          </div>
          <div class="col-md-6 position-relative">
            <label for="diemCK" class="form-label">Điểm Cuối kỳ</label>
            <input type="number" class="form-control" id="diemCK" min="0" max="10" name="diemCK" step=".1" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
          <button type="submit" class="btn btn-primary">APPLY</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script src="/script/manage/Score.js"></script>

<?php $this->stop() ?>