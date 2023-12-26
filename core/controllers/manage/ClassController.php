<?php

namespace App\Core\Controllers\Manage;

use App\Core\Models\Manage\ClassModel;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Response\JsonResponse;
use App\Libs\Controller\Controller;
use App\Libs\Utils\Utility;
use Exception;

class ClassController extends Controller {
  private ClassModel $classModel;
  private Utility $utils;

  public function __construct() {
    $this->classModel = new ClassModel();
  }

  public function findAll() {
    return $this->classModel->select("*");
  }

  public function findColumns(array $columns, array $conditions = []) {
    return $this->classModel->select($columns, $conditions);
  }

  public function findById(ServerRequest $request, $id) {
    $condition = ["maLop" => $id];

    $data = $this->classModel->select("*", $condition);

    if(!$data) {
      return new JsonResponse([
        "message" => "Get class " . $id . " FAILED!"
      ], 400);
    }

    return new JsonResponse([
      "data" => $data,
      "message" => "Get class " . $id . " success!"
    ]);
  }

  public function insert() {
    $this->utils = new Utility();
    $data = array();
    
    $data["khoa"] = (int) $this->utils->get_POST("khoa");
    $data["maLop"] = $this->utils->get_POST("maLop");
    $data["tenLop"] = $this->utils->get_POST("tenLop");
    $data["tenNganh"] = $this->utils->get_POST("tenNganh");

    $validate = $this->validateData($data["maLop"], $data["tenLop"], $data["tenNganh"], $data["khoa"]);
    if(!$validate["valid"]) {
      return new JsonResponse([
        "message" => $validate["message"]
      ], 400);
    }

    if($this->DuplicatedKeyWithInsert($data["maLop"], $data["tenLop"])) {
      return new JsonResponse([
        "message" => "Mã lớp hoặc tên lớp đã tồn tại!"
      ], 400);
    }
    
    try {
      $this->classModel->insert($data);

      return new JsonResponse([
        "message" => "Thêm 1 lớp thành công!"
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
     
    $condition = ["maLop" => $id];
    $data = array();
 
    $data["khoa"] = (int) $this->utils->get_POST("khoa");
    $data["maLop"] = $this->utils->get_POST("maLop");
    $data["tenLop"] = $this->utils->get_POST("tenLop");
    $data["tenNganh"] = $this->utils->get_POST("tenNganh");

    $validate = $this->validateData($data["maLop"], $data["tenLop"], $data["tenNganh"], $data["khoa"]);
    if(!$validate["valid"]) {
      return new JsonResponse([
        "message" => $validate["message"]
      ], 400);
    }

    if($this->DuplicatedKeyWithUpdate($id, $data["maLop"], $data["tenLop"])) {
      return new JsonResponse([
        "message" => "Mã lớp hoặc tên lớp đã tồn tại!"
      ], 400);
    }

    try {
      $this->classModel->update($data, $condition);

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
    $condition = ["maLop" => $id];

    try {
      $this->classModel->delete($condition);

      return new JsonResponse([
        "success" => true,
        "message" => "Delete class success!"
      ]);
    }
    catch (Exception $e) {
      return new JsonResponse([
        "success" => false,
        "message" => $e->getMessage()
      ]);
    }
  }

  public function display() {
    $this->renderView("pages/manage/classPage", []);
  }


// ==================Private Function==================
  private function DuplicatedKeyWithInsert($maLop, $tenLop) : bool {
    $condition1 = ["maLop" => $maLop];
    $condition2 = ["tenLop" => $tenLop];

    if($this->classModel->has($condition1) || $this->classModel->has($condition2))
      return true;

    return false;
  }

  private function DuplicatedKeyWithUpdate($old_maLop, $new_maLop, $new_tenLop) : bool {
    $condition1 = ["maLop" => $new_maLop];
    $condition2 = ["tenLop" => $new_tenLop];

    $old_data = $this->classModel->selectOne([
      "maLop" => $old_maLop
    ]);

    $case1 = ($old_data["maLop"] !== $new_maLop) && ($this->classModel->has($condition1));
    $case2 = ($old_data["tenLop"] !== $new_tenLop) && ($this->classModel->has($condition2));

    if($case1 || $case2)
      return true;

    return false;
  }

  private function validateData($maLop, $tenLop, $tenNganh, $khoa) {
    if(!$maLop) {
      return array(
        "message" => "Mã lớp không được để trống",
        "valid" => false
      );
    }
    if(!$tenLop) {
      return array(
        "message" => "Tên lớp không được để trống",
        "valid" => false
      );
    }
    if(!$tenNganh) {
      return array(
        "message" => "Tên ngành không được để trống",
        "valid" => false
      );
    }
    if(!$khoa) {
      return array(
        "message" => "Khóa không được để trống",
        "valid" => false
      );
    }

    return array(
      "message" => "",
      "valid" => true
    );
  }
}