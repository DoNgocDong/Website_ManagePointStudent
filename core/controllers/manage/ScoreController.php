<?php

namespace App\Core\Controllers\Manage;

use App\Core\Models\Manage\ScoreModel;
use App\Core\Models\Profession\ReviewModel;
use App\Core\Controllers\Manage\StudentController;
use App\Core\Controllers\Manage\CourseController;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Response\JsonResponse;
use App\Libs\Controller\Controller;
use App\Libs\Utils\Utility;
use App\Libs\Utils\Profession;
use Exception;

class ScoreController extends Controller
{
  private ScoreModel $scoreModel;
  private ReviewModel $reviewModel;
  private StudentController $studentController;
  private CourseController $courseController;
  private Utility $utils;
  private Profession $professUtils;

  public function __construct()
  {
    $this->scoreModel = new ScoreModel();
    $this->reviewModel = new ReviewModel();
  }

  public function findAll()
  {
    return $this->scoreModel->select("*");
  }

  public function findColumns(array $columns, array $conditions = [])
  {
    return $this->scoreModel->select($columns, $conditions);
  }

  public function findById($id)
  {
    $condition = ["id" => $id];

    $data = $this->scoreModel->select("*", $condition);

    if (!$data) {
      return new JsonResponse([
        "message" => "Get score FAILED!"
      ], 400);
    }

    return new JsonResponse([
      "data" => $data,
      "message" => "Get score SUCCESS!"
    ]);
  }

  public function insert()
  {
    $this->utils = new Utility();
    $data = array();

    $data["maSinhVien"] = $this->utils->get_POST("maSinhVien");
    $data["maMon"] = $this->utils->get_POST("maMon");
    $data["diemCC"] = (float)$this->utils->get_POST("diemCC");
    $data["diemTH"] = (float)$this->utils->get_POST("diemTH");
    $data["diemGK"] = (float)$this->utils->get_POST("diemGK");
    $data["diemCK"] = (float)$this->utils->get_POST("diemCK");

    $validate = $this->validateData($data["maSinhVien"], $data["maMon"], $data["diemCC"], $data["diemTH"], $data["diemGK"], $data["diemCK"]);
    if(!$validate["valid"]) {
      return new JsonResponse([
        "message" => $validate["message"]
      ], 400);
    }

    if ($this->DuplicatedKeyWithInsert($data["maSinhVien"], $data["maMon"])) {
      return new JsonResponse([
        "message" => "Thông tin điểm này đã tồn tại!"
      ], 400);
    }

    $detailData = $this->getDetailData($data["maSinhVien"], $data["maMon"]);
    $data["hoTen"] = $detailData["hoTen"];
    $data["tenMon"] = $detailData["tenMon"];
    $data["hocKy"] = $detailData["hocKy"];

    try {
      $reviewData = $this->finalReview($data);
      $reviewData["maSinhVien"] = $data["maSinhVien"];
      $reviewData["maMon"] = $data["maMon"];
      $reviewData["hocKy"] = $data["hocKy"];

      $this->scoreModel->insert($data);
      $this->reviewModel->insert($reviewData);

      return new JsonResponse([
        "message" => "Thêm điểm thành công!"
      ], 201);
    } 
    catch (Exception $e) {
      return new JsonResponse([
        "message" => $e->getMessage()
      ], 400);
    }
  }

  public function updateById($id)
  {
    $this->utils = new Utility();

    $condition = ["id" => $id];
    $old_data = $this->scoreModel->selectOne($condition);

    $data = array();

    $data["maSinhVien"] = $this->utils->get_POST("maSinhVien");
    $data["maMon"] = $this->utils->get_POST("maMon");
    $data["diemCC"] = (float)$this->utils->get_POST("diemCC");
    $data["diemTH"] = (float)$this->utils->get_POST("diemTH");
    $data["diemGK"] = (float)$this->utils->get_POST("diemGK");
    $data["diemCK"] = (float)$this->utils->get_POST("diemCK");

    $validate = $this->validateData($data["maSinhVien"], $data["maMon"], $data["diemCC"], $data["diemTH"], $data["diemGK"], $data["diemCK"]);
    if(!$validate["valid"]) {
      return new JsonResponse([
        "message" => $validate["message"]
      ], 400);
    }

    if ($this->DuplicatedKeyWithUpdate($id, $data["maSinhVien"], $data["maMon"])) {
      return new JsonResponse([
        "message" => "Thông tin điểm này đã tồn tại!"
      ], 400);
    }

    $detailData = $this->getDetailData($data["maSinhVien"], $data["maMon"]);
    $data["hoTen"] = $detailData["hoTen"];
    $data["tenMon"] = $detailData["tenMon"];
    $data["hocKy"] = $detailData["hocKy"];

    try {
      $reviewData = $this->finalReview($data);
      $reviewData["maSinhVien"] = $data["maSinhVien"];
      $reviewData["maMon"] = $data["maMon"];
      $reviewData["hocKy"] = $data["hocKy"];

      $this->scoreModel->update($data, $condition);
      $this->reviewModel->update($reviewData, [
        "maSinhVien" => $old_data["maSinhVien"],
        "maMon" => $old_data["maMon"]
      ]);

      return new JsonResponse([
        "message" => "Cập nhật điểm thành công!"
      ]);
    } catch (Exception $e) {
      return new JsonResponse([
        "message" => $e->getMessage()
      ], 400);
    }
  }

  public function deleteById(ServerRequest $request, $id)
  {
    $condition = ["id" => $id];
    $reviewCondition = $this->scoreModel->selectOne($condition);

    try {
      $this->scoreModel->delete($condition);
      $this->reviewModel->delete([
        "maSinhVien" => $reviewCondition["maSinhVien"],
        "maMon" => $reviewCondition["maMon"]
      ]);

      return new JsonResponse([
        "message" => "Delete score success!"
      ]);
    } catch (Exception $e) {
      return new JsonResponse([
        "message" => "ERROR: " . $e->getMessage()
      ], 400);
    }
  }

  public function display()
  {
    $this->renderView("pages/manage/scorePage", []);
  }


  // ==================Private Function==================
  private function DuplicatedKeyWithInsert($maSinhVien, $maMon): bool
  {
    $condition = array("maSinhVien" => $maSinhVien, "maMon" => $maMon);

    if ($this->scoreModel->has($condition))
      return true;

    return false;
  }

  private function DuplicatedKeyWithUpdate($old_recordId, $new_maSinhVien, $new_maMon): bool
  {
    $condition1 = ["maSinhVien" => $new_maSinhVien];
    $condition2 = ["maMon" => $new_maMon];

    $old_data = $this->scoreModel->selectOne([
      "id" => $old_recordId
    ]);

    $case1 = ($old_data["maSinhVien"] !== $new_maSinhVien) && ($this->scoreModel->has($condition1));
    $case2 = ($old_data["maMon"] !== $new_maMon) && ($this->scoreModel->has($condition2));
    $case3 = ($this->DuplicatedKeyWithInsert($new_maSinhVien, $new_maMon));

    if (($case1 || $case2) && $case3)
      return true;

    return false;
  }

  private function getDetailData($maSinhVien, $maMon) {
    $this->studentController = new StudentController();
    $this->courseController = new CourseController();
    $detailData = array();

    $studentData = json_decode($this->studentController->findById($maSinhVien)->getBody(), true);
    $courseData = json_decode($this->courseController->findById($maMon)->getBody(), true);

    $detailData["hoTen"] = $studentData["data"]["hoTen"];
    $detailData["tenMon"] = $courseData["data"]["tenMon"];
    $detailData["hocKy"] = $courseData["data"]["hocKy"];

    return $detailData;
  }

  private function validateData($maSinhVien, $maMon, $diemCC, $diemTH, $diemGK, $diemCK) {
    if(!$maSinhVien) {
      return array(
        "message" => "Mã sinh viên không được để trống",
        "valid" => false
      );
    }
    if(!$maMon) {
      return array(
        "message" => "Mã môn học không được để trống",
        "valid" => false
      );
    }
    if(!$diemCC || !$diemTH || !$diemGK || !$diemCK) {
      return array(
        "message" => "Điểm không được trống",
        "valid" => false
      );
    }

    return array(
      "message" => "",
      "valid" => true
    );
  }

  private function finalReview(array $listScore) {
    $this->professUtils = new Profession();
    $data = array();

    $data["diemTK"] = $this->professUtils->CalScore($listScore);
    $data["diemChu"] = $this->professUtils->wordScore($data["diemTK"]);
    $data["danhGia"] = $this->professUtils->review($data["diemChu"]);

    return $data;
  }
}
