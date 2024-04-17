<?php $this->layout("layout", ["title" => "Student Manager"]) ?>

<?php $this->start('body') ?>

<?php
  use App\Core\Controllers\Manage\StudentController;
  use App\Core\Controllers\Manage\ClassController;

  $studentController = new StudentController();
  $classController = new ClassController();
?>

<div class="manager-page-title">
  <h1>QUẢN LÝ SINH VIÊN</h1>
</div>
<div class="action-method">
  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStudentModal">
    <i class="fa fa-plus-circle"></i> Thêm sinh viên
  </button>
</div>
<div class="display-table">
  <table id="table" class="table table-hover align-middle mb-0 bg-white table-sm">
    <thead class="table-info">
      <tr>
        <th>Mã sinh viên</th>
        <th class="col-2">Họ tên</th>
        <th>Lớp</th>
        <th>Ngày sinh</th>
        <th class="col-1">Giới tính</th>
        <th>Số ĐT</th>
        <th class="text-center">Hành động</th>
      </tr>
    </thead>
    <tbody>

      <?php
        $data = $studentController->findAll();
        foreach ($data as $row) {
      ?>

        <tr>
          <td>
            <div class="d-flex align-items-center">
              <img src="/images/avatar/<?php echo $row["avatar"] ?>" alt="avatar" style="width: 45px; height: 45px" class="rounded-circle" />
              <div class="ms-1">
                <p class="fw-bold mb-1"> <?php echo $row["maSinhVien"] ?> </p>
              </div>
            </div>
          </td>
          <td>
            <p class="fw-bold mb-1"> <?php echo $row["hoTen"] ?> </p>
          </td>
          <td>
            <p class="fw-bold mb-1"> <?php echo $row["tenLop"] ?> </p>
          </td>
          <td>
            <p class="fw-bold mb-1"> <?php echo $row["ngaySinh"] ?> </p>
          </td>
          <td>
            <span class="fw-bold mb-1"> <?php echo $row["gioiTinh"] ?> </span>
          </td>
          <td>
            <span class="badge text-bg-info"> <?php echo $row["sdt"] ?> </span>
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-link btn-rounded" title="Edit"
              onclick="getDataById('<?php echo $row['maSinhVien'] ?>')">
              <i class="fa fa-pencil"></i>
            </button>
            <button type="button" class="btn btn-link btn-rounded" title="Remove"
              onclick="deleteStudent('<?php echo $row['maSinhVien'] ?>')">
              <i class="fa fa-trash"></i>
            </button>
          </td>
        </tr>

      <?php } ?>

    </tbody>
  </table>
</div>

<!-- ===================Modal==================== -->

<!-- Add student modal -->
<form method="post" id="addStudentForm" enctype="multipart/form-data">
  <div class="modal fade" id="addStudentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">THÊM SINH VIÊN</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row g-3 needs-validation">
          <div class="col-md-6 position-relative">
            <label for="validationTooltip01" class="form-label">Mã sinh viên</label>
            <input type="text" class="form-control" id="validationTooltip01" name="maSinhVien" required>
          </div>
          <div class="col-md-6 position-relative">
            <label for="validationTooltip02" class="form-label">Họ tên</label>
            <input type="text" class="form-control" id="validationTooltip02" name="hoTen" required>
          </div>
          <div class="col-md-6 position-relative">
            <label for="cmbGender" class="form-label"> Lớp </label>
            <select class="form-select" id="cmbGender" name="tenLop">

              <?php
                $data = $classController->findColumns(["tenLop"]);
                foreach($data as $options) {
              ?>
                <option value="<?php echo $options["tenLop"] ?>"> 
                  <?php echo $options["tenLop"] ?> 
                </option>
              <?php } ?>

            </select>
          </div>
          <div class="col-md-6 position-relative">
            <label for="validationTooltip05" class="form-label">Ngày sinh</label>
            <input type="date" class="form-control" id="validationTooltip05" name="ngaySinh" required>
          </div>
          <div class="col-md-6 position-relative">
            <label for="cmbGender" class="form-label"> Giới tính </label>
            <select class="form-select" id="cmbGender" aria-label="Default select example" name="gioiTinh">
              <option value="Nam">Nam</option>
              <option value="Nữ">Nữ</option>
            </select>
          </div>
          <div class="col-md-6 position-relative">
            <label for="validationTooltip04" class="form-label">SĐT</label>
            <input type="text" class="form-control" id="validationTooltip04" name="sdt" />
          </div>
          <div class="mb-3">
            <label for="formFile" class="form-label">Ảnh</label>
            <input class="form-control" type="file" id="formFile" name="avatar" accept="image/*">
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
<form method="post" id="updateStudentForm" enctype="multipart/form-data">
  <div class="modal fade" id="updateStudentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">SỬA SINH VIÊN</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row g-3 needs-validation">
          <div class="col-md-6 position-relative">
            <label for="validationTooltip01" class="form-label">Mã sinh viên</label>
            <input type="text" class="form-control msv-input" id="validationTooltip01" name="maSinhVien" required>
          </div>
          <div class="col-md-6 position-relative">
            <label for="validationTooltip02" class="form-label">Họ tên</label>
            <input type="text" class="form-control name-input" id="validationTooltip02" name="hoTen" required>
          </div>
          <div class="col-md-6 position-relative">
            <label for="cmbGender" class="form-label"> Lớp </label>
            <select class="form-select tenLop-select" id="cmbGender" name="tenLop">

              <?php
                $data = $classController->findColumns(["tenLop"]);
                foreach($data as $options) {
              ?>
                <option value=<?php echo $options["tenLop"] ?>> 
                  <?php echo $options["tenLop"] ?> 
                </option>
              <?php } ?>

            </select>
          </div>
          <div class="col-md-6 position-relative">
            <label for="validationTooltip03" class="form-label">Ngày sinh</label>
            <input type="date" class="form-control date-input" id="validationTooltip03" name="ngaySinh" required>
          </div>
          <div class="col-md-6 position-relative">
            <label for="cmbGender" class="form-label"> Giới tính </label>
            <select class="form-select gender-select" id="cmbGender" name="gioiTinh">
              <option value="Nam">Nam</option>
              <option value="Nữ">Nữ</option>
            </select>
          </div>
          <div class="col-md-6 position-relative">
            <label for="validationTooltip04" class="form-label">SĐT</label>
            <input type="text" class="form-control sdt-input" id="validationTooltip04" name="sdt" data-bind="value:validationTooltip04" />
          </div>
          <div class="mb-3">
            <label for="formFile" class="form-label">Ảnh</label>
            <input class="form-control avt-input" type="file" id="formFile" name="avatar" accept="image/*">
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

<script src="/script/manage/Student.js"></script>

<?php $this->stop() ?>