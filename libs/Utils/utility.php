<?php
namespace App\Libs\Utils;

class Utility {

  public function get_GET($param) {
    $value = "";

    if(isset($_GET[$param])) {
      $value = $_GET[$param];
      $value = $this->fixSqlInjection($value);
    }

    return $value;
  }

  public function get_POST($param) {
    $value = "";

    if(isset($_POST[$param])) {
      $value = $_POST[$param];
      $value = $this->fixSqlInjection($value);
    }

    return $value;
  }

  public function get_COOKIE($param) {
    $value = "";

    if(isset($_COOKIE[$param])) {
      $value = $_COOKIE[$param];
      $value = $this->fixSqlInjection($value);
    }

    return $value;
  }

  public function validateFile($fieldName) {
    $file_tmp = isset($_FILES[$fieldName]["tmp_name"]) ? $_FILES[$fieldName]["tmp_name"] : "";
    $file_name = isset($_FILES[$fieldName]['name']) ? $_FILES[$fieldName]['name'] : "";
    $file_size = isset($_FILES[$fieldName]['size']) ? $_FILES[$fieldName]['size'] : "";

    if($file_name === "")
      return false;

    $uploadDir = ROOT_FOLDER . "/public/images/avatar/";  // Thư mục lưu trữ ảnh
    $uploadFile = $uploadDir . basename($file_name);
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
    $maxFileSize = 5 * 1024 * 1024;  // 5MB

    // Kiểm tra xem tệp được tải lên có phải là ảnh và có kích thước hợp lệ
    if (getimagesize($file_tmp) === false) {
      return false;
    } elseif ($file_size > $maxFileSize) {
      return false;
    } elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
      return false;
    } else {
        if (move_uploaded_file($file_tmp, $uploadFile)) {
          $file_name;
          return $file_name;
        } else {
          return false;
        }
    }
  }

  private function fixSqlInjection($sql) {
    $sql = str_replace('\\', '\\\\', $sql);
    $sql = str_replace('\'', '\\\'', $sql);
    return $sql;
  }
}