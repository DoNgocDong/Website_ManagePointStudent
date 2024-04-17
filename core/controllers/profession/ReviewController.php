<?php

namespace App\Core\Controllers\Profession;

use App\Core\Models\Profession\ReviewModel;
use App\Libs\Controller\Controller;

class ReviewController extends Controller {
  private ReviewModel $reviewModel;

  public function __construct() {
    $this->reviewModel = new ReviewModel();
  }

  public function findAll() {
    return $this->reviewModel->selectJoin([
      "[><]sinhvien" => ["maSinhVien" => "maSinhVien"],
      "[><]monhoc" => ["maMon" => "maMon"]
    ], "*");
  }

  public function display() {
    $this->renderView("pages/tools/finalScorePage", []);
  }
}