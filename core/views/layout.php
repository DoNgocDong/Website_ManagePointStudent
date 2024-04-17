<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="/images/logo.png">
  <title> <?= $this->e($title) ?> </title>

  <!-- bootstrap CDNs -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css'>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  <link rel="stylesheet" type="text/css" href="/css/login.css">
  <link rel="stylesheet" type="text/css" href="/css/frame.css">
  <link rel="stylesheet" type="text/css" href="/css/homePage.css">
  <link rel="stylesheet" type="text/css" href="/css/managerPage.css">
</head>

<body>
  <div class="grid-container">
    <header id="web-menu" class="web-menu">
      <nav class="navbar navbar-expand-sm navbar-dark bg-dark" data-bs-theme="dark">
        <img class="logo" src="/images/logo.png" alt="logo">
        <div class="collapse navbar-collapse" id="collapsibleNavId">
          <ul class="navbar-nav me-auto mt-2 mt-lg-0">
            <li class="nav-item">
              <a class="nav-link active" href="/" aria-current="page"> Trang chủ <span class="visually-hidden">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Quản lý </a>
              <div class="dropdown-menu" aria-labelledby="dropdownId">
                <a class="dropdown-item" href="/manage/class"> Quản lý lớp học </a>
                <a class="dropdown-item" href="/manage/course"> Quản lý môn học </a>
                <a class="dropdown-item" href="/manage/student"> Quản lý sinh viên </a>
                <a class="dropdown-item" href="/manage/score"> Quản lý điểm </a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Công cụ </a>
              <div class="dropdown-menu" aria-labelledby="dropdownId">
                <a class="dropdown-item" href="/tools/final-score"> Bảng điểm tổng kết </a>
              </div>
            </li>
          </ul>
        </div>
        <div class="dropdown">
          <button id="user-dropdown" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            User
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownId">
            <button id="login" class="dropdown-item" onclick="login()">
              <i class="bi bi-box-arrow-in-right"></i> Đăng nhập</button>
            <button id="changePass" class="dropdown-item" onclick="changePass()">
              <i class="bi bi-pencil-square"></i> Đổi mật khẩu</button>
            <button id="logout" class="dropdown-item" onclick="logout()">
              <i class="bi bi-box-arrow-right"></i> Đăng xuất</button>
          </div>
        </div>

        <!-- collapse button -->
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </nav>
    </header>

    <main id="web-content" class="web-content">
      <?= $this->section('body') ?>
    </main>

    <footer id="web-footer" class="web-footer">
      <div class="copyright">
        Student Score Management Website ©2023 Create by
        <a class="link-info link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="https://www.facebook.com/ngocdong2110.2003" target="_blank" rel="noopener noreferrer">
          Do Ngoc Dong
        </a>
      </div>
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src='https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js'></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script src="/script/dataTable.js"></script>
  <script src="/script/base.js"></script>
</body>

</html>