<?php $this->layout("layout", ["title" => "Course Managar"]) ?>

<?php $this->start('body') ?>

<?php
  use App\Core\Controllers\Manage\CourseController;
  $courseController = new CourseController();
?>

<div class="manager-page-title">
  <h1>QUẢN LÝ MÔN HỌC</h1>
</div>
<div class="action-method">
  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCourseModal">
    <i class="fa fa-plus-circle"></i> Thêm môn học
  </button>
</div>
<div class="display-table">
  <table id="table" class="table table-striped align-middle mb-0 bg-white table-sm">
    <thead class="table-info">
      <tr>
        <th>Mã môn</th>
        <th class="col-4">Tên môn</th>
        <th>Tín chỉ</th>
        <th>Học kỳ</th>
        <th class="col-2 text-center">Hành động</th>
      </tr>
    </thead>

    <?php
    $data = $courseController->findAllCourse();

    foreach ($data as $row) {
    ?>

      <tbody>
        <tr>
          <td class="col-2">
            <div class="d-flex align-items-center">
              <div class="ms-1">
                <p class="fw-bold mb-1"> <?php echo $row["maMon"] ?></p>
              </div>
            </div>
          </td>
          <td>
            <p class="fw-bold mb-1"><?php echo $row["tenMon"] ?></p>
          </td>
          <td>
            <p class="fw-bold mb-1"><?php echo $row["tinChi"] ?></p>
          </td>
          <td>
            <span class="badge text-bg-info"><?php echo $row["hocKy"] ?></span>
          </td>
          <td class="col-2 text-center">
            <button type="button" class="btn btn-link btn-rounded" title="Edit"
              onclick="getDataById('<?php echo $row['maMon'] ?>')">
              <i class="fa fa-pencil"></i>
            </button>
            <button type="button" class="btn btn-link btn-rounded" title="Remove"
              onclick="deleteCourse('<?php echo $row['maMon'] ?>')">
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
<form action="" method="post" id="addCourseform">
  <div class="modal fade" id="addCourseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">THÊM MÔN HỌC</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row g-2 needs-validation">
          <div class="col-md-6 position-relative">
            <label for="validationTooltip01" class="form-label">Mã môn</label>
            <input type="text" class="form-control" id="validationTooltip01" name="maMon" required>
          </div>
          <div class="col-md-6 position-relative">
            <label for="validationTooltip02" class="form-label">Tên môn</label>
            <input type="text" class="form-control" id="validationTooltip02" name="tenMon" required>
          </div>
          <div class="col-md-6 position-relative">
            <label for="validationTooltip03" class="form-label">Tín chỉ</label>
            <input type="number" class="form-control tinChi-input" id="validationTooltip03" min="1" name="tinChi" required>
          </div>
          <div class="col-md-6 position-relative">
            <label for="validationTooltip04" class="form-label">Học kỳ</label>
            <input type="number" class="form-control hocKy-input" id="validationTooltip04" min="1" name="hocKy" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
          <button type="submit" class="btn btn-primary">ADD</button>
        </div>
      </div>
    </div>
  </div>
</Form>

<!-- Update course modal -->
<form method="post" id="updateCourseForm">
  <div class="modal fade" id="updateCourseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">SỬA MÔN HỌC</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="modal-body row g-2 needs-validation">
            <div class="col-md-6 position-relative">
              <label for="validationTooltip01" class="form-label">Mã môn</label>
              <input type="text" class="form-control maMon-input" id="validationTooltip05" name="maMon" required>
            </div>
            <div class="col-md-6 position-relative">
              <label for="validationTooltip01" class="form-label">Tên môn</label>
              <input type="text" class="form-control tenMon-input" id="validationTooltip06" name="tenMon" required>
            </div>
            <div class="col-md-6 position-relative">
              <label for="validationTooltip01" class="form-label">Tín chỉ</label>
              <input type="number" class="form-control tinChi-input" id="validationTooltip07" min="1" name="tinChi" required>
            </div>
            <div class="col-md-6 position-relative">
              <label for="validationTooltip01" class="form-label">Học kỳ</label>
              <input type="number" class="form-control hocKy-input" id="validationTooltip07" min="1" name="hocKy" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
          <button type="submit" class="btn btn-primary">APPLY</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script src="/script/manage/Course.js"></script>

<?php $this->stop() ?>