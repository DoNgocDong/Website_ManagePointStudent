<?php

namespace App\Core\Controllers\Manage;

use App\Core\Models\Manage\StudentModel;
use App\Libs\Utils\Utility;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Response\JsonResponse;
use App\Libs\Controller\Controller;
use Exception;

class StudentController extends Controller {
  private StudentModel $studentModel;
  private Utility $utils;

  public function __construct() {
    $this->studentModel = new StudentModel();
  }

  public function findAll() {
    return $this->studentModel->select("*");
  }

  public function findColumns(array $columns, array $conditions = []) {
    return $this->studentModel->select($columns, $conditions);
  }

  public function findById($id) {
    $condition = ["maSinhVien" => $id];

    $data = $this->studentModel->selectOne($condition);

    if(!$data) {
      return new JsonResponse([
        "message" => "Get student " . $id . " FAILED!"
      ], 400);
    }

    return new JsonResponse([
      "data" => $data,
      "message" => "Get student " . $id . " success!"
    ]);
  }

  public function insert() {
    $this->utils = new Utility();
    $data = array();
    
    $data["maSinhVien"] = $this->utils->get_POST("maSinhVien");
    $data["hoTen"] = $this->utils->get_POST("hoTen");
    $data["tenLop"] = $this->utils->get_POST("tenLop");
    $data["ngaySinh"] = $this->utils->get_POST("ngaySinh");
    $data["gioiTinh"] = $this->utils->get_POST("gioiTinh");
    $data["sdt"] = $this->utils->get_POST("sdt");

    $fileName = $this->utils->validateFile("avatar");
    if($fileName){
      $data["avatar"] = $fileName;
    }

    $validate = $this->validateData($data["maSinhVien"], $data["hoTen"], $data["tenLop"], $data["ngaySinh"]);
    if(!$validate["valid"]) {
      return new JsonResponse([
        "message" => $validate["message"]
      ], 400);
    }

    if($this->DuplicatedKeyWithInsert($data["maSinhVien"])) {
      return new JsonResponse([
        "message" => "mã sinh viên đã tồn tại!"
      ], 400);
    }
    
    try {
      $this->studentModel->insert($data);

      return new JsonResponse([
        "message" => "Thêm 1 sinh viên thành công!"
      ], 201);
    }
    catch(Exception $e) {
      return new JsonResponse([
        "message" => $e->getMessage()
      ], 400);
    }
  }

  public function updateById($id) {  
    $this->utils = new Utility();
     
    $condition = ["maSinhVien" => $id];
    
    $data = array();

    $data["maSinhVien"] = $this->utils->get_POST("maSinhVien");
    $data["hoTen"] = $this->utils->get_POST("hoTen");
    $data["tenLop"] = $this->utils->get_POST("tenLop");
    $data["ngaySinh"] = $this->utils->get_POST("ngaySinh");
    $data["gioiTinh"] = $this->utils->get_POST("gioiTinh");
    $data["sdt"] = $this->utils->get_POST("sdt");

    $validate = $this->validateData($data["maSinhVien"], $data["hoTen"], $data["tenLop"], $data["ngaySinh"]);
    if(!$validate["valid"]) {
      return new JsonResponse([
        "message" => $validate["message"]
      ], 400);
    }

    if($this->DuplicatedKeyWithUpdate($id, $data["maSinhVien"])) {
      return new JsonResponse([
        "message" => "mã sinh viên đã tồn tại!"
      ], 400);
    }

    $fileName = $this->utils->validateFile("avatar");
    if($fileName){
      $data["avatar"] = $fileName;
      $this->unLinkAvatar($id);
    }

    try {
      $this->studentModel->update($data, $condition);

      return new JsonResponse([
        "message" => "Cập nhật thông tin thành công!"
      ]);
    }
    catch(Exception $e) {
      return new JsonResponse([
        "message" => $e->getMessage()
      ], 400);
    }
  }

  public function deleteById(ServerRequest $request, $id) {
    $condition = ["maSinhVien" => $id];

    try {
      $row = $this->studentModel->selectOne($condition);
      if($row["avatar"] != null) {
        $this->unLinkAvatar($id);
      }
      $this->studentModel->delete($condition);
      
      return new JsonResponse([
        "message" => "Xóa sinh viên thành công!"
      ]);
    }
    catch (Exception $e) {
      return new JsonResponse([
        "message" => "ERROR: " . $e->getMessage()
      ], 400);
    }
  }

  public function display() {
    $this->renderView("pages/manage/studentPage", []);
  }


// ==================Private Function==================
  private function DuplicatedKeyWithInsert($maSinhVien) : bool {
    $condition = ["maSinhVien" => $maSinhVien];

    if($this->studentModel->has($condition))
      return true;

    return false;
  }

  private function DuplicatedKeyWithUpdate($old_maSinhVien, $new_maSinhVien) : bool {
    $condition1 = ["maSinhVien" => $new_maSinhVien];

    $old_data = $this->studentModel->selectOne([
      "maSinhVien" => $old_maSinhVien
    ]);

    $case = ($old_data["maSinhVien"] !== $new_maSinhVien) && ($this->studentModel->has($condition1));

    if($case)
      return true;

    return false;
  }

  private function validateData($maSinhVien, $hoTen, $tenLop, $ngaySinh) {
    if(!$maSinhVien) {
      return array(
        "message" => "Mã sinh viên không được để trống",
        "valid" => false
      );
    }
    if(!$hoTen) {
      return array(
        "message" => "Họ tên không được để trống",
        "valid" => false
      );
    }
    if(!$tenLop) {
      return array(
        "message" => "Tên lớp không được để trống",
        "valid" => false
      );
    }
    if(!$ngaySinh) {
      return array(
        "message" => "Ngày sinh không được để trống",
        "valid" => false
      );
    }

    return array(
      "message" => "",
      "valid" => true
    );
  }

  private function unLinkAvatar($maSinhVien) {
    $condition = ["maSinhVien" => $maSinhVien];

    $data = $this->studentModel->selectOne($condition);
    if($data["avatar"]) {
      unlink(ROOT_FOLDER . "/public/images/avatar/" . $data["avatar"]);
    }
  }
}