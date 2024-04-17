<?php

namespace App\Core\Controllers\Manage;

use App\Core\Models\Manage\MajorModel;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Response\JsonResponse;
use App\Libs\Controller\Controller;
use App\Libs\Utils\Utility;
use Exception;

class MajorController extends Controller {
  private MajorModel $majorModel;
  private Utility $utils;

  public function __construct() {
    $this->majorModel = new MajorModel();
  }

  public function findAll() {
    return $this->majorModel->select("*");
  }

  public function findColumns(array $columns, array $conditions = []) {
    return $this->majorModel->select($columns, $conditions);
  }

  public function findById(ServerRequest $request, $id) {
    $condition = ["maNganh" => $id];

    $data = $this->majorModel->select("*", $condition);

    if(!$data) {
      return new JsonResponse([
        "message" => "Get major " . $id . " FAILED!"
      ], 400);
    }

    return new JsonResponse([
      "data" => $data,
      "message" => "Get major " . $id . " SUCCESS!"
    ]);
  }

  public function insert() {
    $this->utils = new Utility();
    $data = array();
    
    $data["maNganh"] = $this->utils->get_POST("maNganh");
    $data["tenNganh"] = $this->utils->get_POST("tenNganh");

    if($this->DuplicatedKeyWithInsert($data["maNganh"], $data["tenNganh"])) {
      return new JsonResponse([
        "message" => "Mã ngành hoặc tên ngành đã tồn tại!"
      ], 400);
    }
    
    try {
      $this->majorModel->insert($data);

      return new JsonResponse([
        "message" => "Thêm 1 ngành thành công!"
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
     
    $condition = ["maNganh" => $id];
    $data = array();
 
    $data["maNganh"] = $this->utils->get_POST("maNganh");
    $data["tenNganh"] = $this->utils->get_POST("tenNganh");

    if($this->DuplicatedKeyWithUpdate($id, $data["maNganh"], $data["tenNganh"])) {
      return new JsonResponse([
        "message" => "Mã ngành hoặc tên ngành đã tồn tại!"
      ], 400);
    }

    try {
      $this->majorModel->update($data, $condition);

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
    $condition = ["maNganh" => $id];

    try {
      $this->majorModel->delete($condition);

      return new JsonResponse([
        "success" => true,
        "message" => "Delete major success!"
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
    $this->renderView("pages/manage/majorPage", []);
  }


// ==================Private Function==================
  private function DuplicatedKeyWithInsert($maNganh, $tenNganh) : bool {
    $condition1 = ["maNganh" => $maNganh];
    $condition2 = ["tenNganh" => $tenNganh];

    if($this->majorModel->has($condition1) || $this->majorModel->has($condition2))
      return true;

    return false;
  }

  private function DuplicatedKeyWithUpdate($old_maNganh, $new_maNganh, $new_tenNganh) : bool {
    $condition1 = ["maNganh" => $new_maNganh];
    $condition2 = ["tenNganh" => $new_tenNganh];

    $old_data = $this->majorModel->selectOne([
      "maNganh" => $old_maNganh
    ]);

    $case1 = ($old_data["maNganh"] !== $new_maNganh) && ($this->majorModel->has($condition1));
    $case2 = ($old_data["tenNganh"] !== $new_tenNganh) && ($this->majorModel->has($condition2));

    if($case1 || $case2)
      return true;

    return false;
  }
}