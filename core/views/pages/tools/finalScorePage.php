<?php $this->layout("layout", ["title" => "Final Score"]) ?>

<?php $this->start('body') ?>

<?php
  use App\Core\Controllers\Profession\ReviewController;

  $reviewController = new ReviewController();
?>

<div class="manager-page-title">
  <h1>BẢNG ĐIỂM TỔNG KẾT CÁC MÔN</h1>
</div>
<div class="action-method">
  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addScoreModal">
    <i class="fa fa-cloud-download"></i> Xuất danh sách
  </button>
</div>
<div class="display-table">
  <table id="table" class="table table-bordered align-middle mb-0 bg-white table-sm">
    <thead class="table-info align-middle">
      <tr>
        <th rowspan="2" class="col-2">Mã sinh viên</th>
        <th rowspan="2" class="col-2">Họ tên</th>
        <th rowspan="2" class="col-2">Tên môn</th>
        <th colspan="3" class="col-3 text-center">Đánh giá</th>
        <th rowspan="2">Học kỳ</th>
        <th rowspan="2" class="col-2 text-center">Hành động</th>
      </tr>
      <tr>
        <th class="text-center">Tổng kết</th>
        <th class="text-center">Điểm chữ</th>
        <th class="text-center">Đánh giá</th>
      </tr>
    </thead>
    <tbody>

      <?php
        $data = $reviewController->findAll();
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
            <p class="fw-bold mb-1"> <?php echo $row["tenMon"] ?> </p>
          </td>
          <td class="text-center">
            <span class="badge text-bg-info"> <?php echo $row["diemTK"] ?> </span>
          </td>
          <td class="text-center">
            <span class="badge text-bg-info"> <?php echo $row["diemChu"] ?> </span>
          </td>
          <td class="text-center">
            <span class="badge text-bg-info"> <?php echo $row["danhGia"] ?> </span>
          </td>
          <td class="text-center">
            <p class="fw-bold mb-1"> <?php echo $row["hocKy"] ?> </p>
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-link btn-rounded" title="Export record"
              onclick="">
              <i class="fa fa-cloud-download"></i>
            </button>
            <button type="button" class="btn btn-link btn-rounded" title="Detail"
              onclick="">
              <i class="bi bi-three-dots-vertical"></i>
            </button>
          </td>
        </tr>

      <?php } ?>

    </tbody>
  </table>
</div>


<!-- <script src="/script/manage/Student.js"></script> -->

<?php $this->stop() ?>