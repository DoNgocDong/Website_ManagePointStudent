<?php

namespace App\Core\Controllers\Manage;

use App\Core\Models\Manage\CourseModel;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Response\JsonResponse;
use App\Libs\Controller\Controller;
use App\Libs\Utils\Utility;
use Exception;

class CourseController extends Controller {
  private CourseModel $courseModel;
  private Utility $utils;

  // hàm khởi tạo contrusctor
  public function __construct() {
    $this->courseModel = new CourseModel();
  }

  // Hàm select 
  public function findAllCourse() {
    return $this->courseModel->select("*");
  }

  public function findColumns(array $columns, array $conditions = []) {
    return $this->courseModel->select($columns, $conditions);
  }

  // hàm tìm kiếm data theo mã môn
  public function findById($id) {
    $condition = ["maMon" => $id];

    $data = $this->courseModel->selectOne($condition);

    if(!$data) {
      return new JsonResponse([
        "message" => "Get course " . $id . " FAILED!"
      ], 400);
    }

    return new JsonResponse([
      "data" => $data,
      "message" => "Get course " . $id . " success!"
    ]);
  }

  //hàm insert
  public function insert() {
    $this->utils = new Utility();
    $data = array();

    $data["maMon"] = $this->utils->get_POST("maMon");
    $data["tenMon"] = $this->utils->get_POST("tenMon");
    $data["tinChi"] = (int)$this->utils->get_POST("tinChi");
    $data["hocKy"] = (int)$this->utils->get_POST("hocKy");

    $validate = $this->validateData($data["maMon"], $data["tenMon"], $data["tinChi"], $data["hocKy"]);
    if(!$validate["valid"]) {
      return new JsonResponse([
        "message" => $validate["message"]
      ], 400);
    }
    
    if($this->DuplicatedKeyWithInsert($data["maMon"], $data["tenMon"])) {
      return new JsonResponse([
        "message" => "mã môn hoặc tên môn đã tồn tại!"
      ], 400);
    }

    try {
      $this->courseModel->insert($data);

      return new JsonResponse([
        "success" => true,
        "message" => "Add course success!"
      ]);
    }
    catch(Exception $e) {
      return new JsonResponse([
        "success" => false,
        "message" => $e->getMessage()
      ]);
    }
  }

//Hàm update data 
public function updateById($id) {  
  $this->utils = new Utility();
   
  $condition = ["maMon" => $id];
  $data = array();

  $data["maMon"] = $this->utils->get_POST("maMon");
  $data["tenMon"] = $this->utils->get_POST("tenMon");
  $data["tinChi"] =(int) $this->utils->get_POST("tinChi");
  $data["hocKy"] = (int) $this->utils->get_POST("hocKy");

  $validate = $this->validateData($data["maMon"], $data["tenMon"], $data["tinChi"], $data["hocKy"]);
  if(!$validate["valid"]) {
    return new JsonResponse([
      "message" => $validate["message"]
    ], 400);
  }

  if($this->DuplicatedKeyWithUpdate($id, $data["maMon"], $data["tenMon"])) {
    return new JsonResponse([
      "message" => "mã môn hoặc tên môn đã tồn tại!"
    ], 400);
  }

  try {
    $this->courseModel->update($data, $condition);

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

//Hàm Deleted 
public function deleteById($id) {
  $condition = ["maMon" => $id];

  try {
    $this->courseModel->delete($condition);

    return new JsonResponse([
      "success" => true,
      "message" => "Delete course success!"
    ]);
  }
  catch (Exception $e) {
    return new JsonResponse([
      "success" => false,
      "message" => $e->getMessage()
    ]);
  }
}

// hàm renderview
  public function display() {
    $this->renderView("pages/manage/coursePage", []);
  }



// ==========================Private Function=========================
  private function DuplicatedKeyWithInsert($maMon, $tenMon) : bool {
    $condition1 = ["maMon" => $maMon];
    $condition2 = ["tenMon" => $tenMon];

    if($this->courseModel->has($condition1) || $this->courseModel->has($condition2))
      return true;

    return false;
  }

  private function DuplicatedKeyWithUpdate($old_maMon, $new_maMon, $new_tenMon) : bool {
    $condition1 = ["maMon" => $new_maMon];
    $condition2 = ["tenMon" => $new_tenMon];

    $old_data = $this->courseModel->selectOne([
      "maMon" => $old_maMon
    ]);

    $case1 = ($old_data["maMon"] !== $new_maMon) && ($this->courseModel->has($condition1));
    $case2 = ($old_data["tenMon"] !== $new_tenMon) && ($this->courseModel->has($condition2));

    if($case1 || $case2)
      return true;

    return false;
  }

  private function validateData($maMon, $tenMon, $tinChi, $hocKy) {
    if(!$maMon) {
      return array(
        "message" => "Mã môn không được để trống",
        "valid" => false
      );
    }
    if(!$tenMon) {
      return array(
        "message" => "Tên môn không được để trống",
        "valid" => false
      );
    }
    if(!$tinChi) {
      return array(
        "message" => "Tín chỉ không được để trống",
        "valid" => false
      );
    }
    if(!$hocKy) {
      return array(
        "message" => "Học kỳ không được để trống",
        "valid" => false
      );
    }

    return array(
      "message" => "",
      "valid" => true
    );
  }
}