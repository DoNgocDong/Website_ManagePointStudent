<?php $this->layout('layout', ['title' => 'Class Manager']) ?>

<?php $this->start('body') ?>

<?php
  use App\Core\Controllers\Manage\ClassController;
  use App\Core\Controllers\Manage\MajorController;

  $classController = new ClassController();
  $majorController = new MajorController();
?>

<div class="manager-page-title">
  <h1>QUẢN LÝ LỚP HỌC</h1>
</div>
<div class="action-method">
  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addClassModal">
    <i class="fa fa-plus-circle"></i> Thêm lớp học
  </button>
</div>
<div class="display-table">
  <table id="table" class="table table-striped align-middle mb-0 bg-white table-sm">
    <thead class="table-info">
      <tr>
        <th class="col-2">Mã lớp</th>
        <th>Tên lớp</th>
        <th>Tên ngành</th>
        <th>Khóa</th>
        <th class="col-2 text-center">Hành động</th>
      </tr>
    </thead>
    <tbody>

      <?php
      $data = $classController->findAll();

      foreach ($data as $row) {
      ?>

        <tr>
          <td class="col-2">
            <div class="d-flex align-items-center">
              <div class="ms-1">
                <p class="fw-bold mb-1"> <?php echo $row["maLop"] ?> </p>
              </div>
            </div>
          </td>
          <td>
            <p class="fw-bold mb-1"> <?php echo $row["tenLop"] ?> </p>
          </td>
          <td>
            <p class="fw-bold mb-1"> <?php echo $row["tenNganh"] ?> </p>
          </td>
          <td>
            <span class="badge text-bg-info"> <?php echo $row["khoa"] ?> </span>
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-link btn-rounded" title="Edit"
              onclick="getDataById('<?php echo $row['maLop'] ?>')">
              <i class="fa fa-pencil"></i>
            </button>      
            <button type="button" class="btn btn-link btn-rounded" title="Remove"
              onclick="deleteClass('<?php echo $row['maLop'] ?>')">
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
<form method="post" id="addClassForm">
  <div class="modal fade" id="addClassModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">THÊM LỚP HỌC</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <!-- Form input -->
        <div class="modal-body row g-3 needs-validation">
          <div class="col-md-6 position-relative">
            <label for="validationTooltip01" class="form-label">Mã lớp</label>
            <input type="text" class="form-control" id="validationTooltip01" name="maLop" required>
          </div>
          <div class="col-md-6 position-relative">
            <label for="validationTooltip02" class="form-label">Tên lớp</label>
            <input type="text" class="form-control" id="validationTooltip02" name="tenLop" required>
          </div>
          <div class="col-md-9 position-relative">
            <label for="validationTooltip03" class="form-label">Tên ngành</label>
            <select class="form-select" id="validationTooltip03" name="tenNganh">

              <?php
                $data = $majorController->findColumns(["tenNganh"]);
                foreach($data as $option) {
              ?>
                <option value="<?php echo $option["tenNganh"] ?>">
                  <?php echo $option["tenNganh"] ?>
                </option>
              <?php } ?>

            </select>
          </div>
          <div class="col-md-3 position-relative">
            <label for="validationTooltip04" class="form-label">Khóa</label>
            <input type="number" class="form-control" id="validationTooltip04" min="1" name="khoa" required>
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
<form method="post" id="updateClassForm">
  <div class="modal fade" id="updateClassModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">SỬA THÔNG TIN LỚP</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <!-- Form input -->
        <div class="modal-body row g-3 needs-validation">
          <div class="col-md-6 position-relative">
            <label for="validationTooltip01" class="form-label">Mã lớp</label>
            <input type="text" class="form-control maLop-input" id="validationTooltip01" name="maLop" required>
          </div>
          <div class="col-md-6 position-relative">
            <label for="validationTooltip02" class="form-label">Tên lớp</label>
            <input type="text" class="form-control tenLop-input" id="validationTooltip02" name="tenLop" required>
          </div>
          <div class="col-md-9 position-relative">
            <label for="validationTooltip03" class="form-label">Tên ngành</label>
            <select class="form-select" id="validationTooltip03" name="tenNganh">

              <?php
                $data = $majorController->findColumns(["tenNganh"]);
                foreach($data as $option) {
              ?>
                <option value="<?php echo $option["tenNganh"] ?>">
                  <?php echo $option["tenNganh"] ?>
                </option>
              <?php } ?>

            </select>
          </div>
          <div class="col-md-3 position-relative">
            <label for="validationTooltip04" class="form-label">Khóa</label>
            <input type="number" class="form-control khoa-input" id="validationTooltip04" min="1" name="khoa" required>
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

<script src="/script/manage/Class.js"></script>

<?php $this->stop() ?>