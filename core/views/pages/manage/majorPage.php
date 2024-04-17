<?php $this->layout('layout', ['title' => 'Major Manager']) ?>

<?php $this->start('body') ?>

<?php
  use App\Core\Controllers\Manage\MajorController;
  $majorController = new MajorController();
?>

<div class="manager-page-title">
  <h1>QUẢN LÝ CHUYÊN NGÀNH</h1>
</div>
<div class="action-method">
  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMajorModal">
    <i class="fa fa-plus-circle"></i> Thêm chuyên ngành
  </button>
</div>
<div class="display-table">
  <table id="table" class="table table-striped align-middle mb-0 bg-white table-sm">
    <thead class="table-info">
      <tr>
        <th class="col-3">Mã ngành</th>
        <th>Tên ngành</th>
        <th class="col-2 text-center">Hành động</th>
      </tr>
    </thead>
    <tbody>

      <?php
      $data = $majorController->findAll();

      foreach ($data as $row) {
      ?>

        <tr>
          <td class="col-2">
            <div class="d-flex align-items-center">
              <div class="ms-1">
                <p class="fw-bold mb-1"> <?php echo $row["maNganh"] ?> </p>
              </div>
            </div>
          </td>
          <td>
            <p class="fw-bold mb-1"> <?php echo $row["tenNganh"] ?> </p>
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-link btn-rounded" title="Edit"
              onclick="getDataById('<?php echo $row['maNganh'] ?>')">
              <i class="fa fa-pencil"></i>
            </button>      
            <button type="button" class="btn btn-link btn-rounded" title="Remove"
              onclick="deleteMajor('<?php echo $row['maNganh'] ?>')">
              <i class="fa fa-trash"></i>
            </button>
          </td>
        </tr>

      <?php } ?>

    </tbody>
  </table>
</div>

<!-- ===================Modal==================== -->

<!-- Add major modal -->
<form method="post" id="addMajorForm">
  <div class="modal fade" id="addMajorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">THÊM CHUYÊN NGÀNH</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <!-- Form input -->
        <div class="modal-body row g-3 needs-validation">
          <div class="col-md-6 position-relative">
            <label for="validationTooltip01" class="form-label">Mã ngành</label>
            <input type="text" class="form-control" id="validationTooltip01" name="maNganh" required>
          </div>
          <div class="col-md-6 position-relative">
            <label for="validationTooltip03" class="form-label">Tên ngành</label>
            <input type="text" class="form-control" id="validationTooltip03" name="tenNganh" required>
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



<!-- Update major modal -->
<form method="post" id="updateMajorForm">
  <div class="modal fade" id="updateMajorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">SỬA CHUYÊN NGÀNH</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <!-- Form input -->
        <div class="modal-body row g-3 needs-validation">
          <div class="col-md-6 position-relative">
            <label for="validationTooltip01" class="form-label">Mã ngành</label>
            <input type="text" class="form-control maNganh-input" id="validationTooltip01" name="maNganh" required>
          </div>
          <div class="col-md-6 position-relative">
            <label for="validationTooltip03" class="form-label">Tên ngành</label>
            <input type="text" class="form-control tenNganh-input" id="validationTooltip03" name="tenNganh" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
          <button type="submit" class="btn btn-primary">UPDATE</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script src="/script/manage/Major.js"></script>

<?php $this->stop() ?>