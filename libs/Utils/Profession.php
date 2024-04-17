<?php

namespace App\Libs\Utils;

class Profession
{
  public function CalScore(array $listScore) {
    $diemCC = $listScore["diemCC"];
    $diemTH = $listScore["diemTH"];
    $diemGK = $listScore["diemGK"];
    $diemCK = $listScore["diemCK"];

    $diemTP = ($diemCC + $diemTH) * 0.1;

    return ($diemTP + $diemGK*0.2 + $diemCK*0.7);
  }

  public function wordScore(float $diemTK) {
    if ($diemTK >= 8.5)
      return "A";
    else if ($diemTK >= 8.0)
      return "B+";
    else if ($diemTK >= 7.0)
      return "B";
    else if ($diemTK >= 6.5)
      return "C+";
    else if ($diemTK >= 5.5)
      return "C";
    else if ($diemTK >= 5.0)
      return "D+";
    else if ($diemTK >= 4.0)
      return "D";
    else
      return "F";
  }

  public function review($wordScore) {
    if ($wordScore === "F")
      return "KHONG DAT";
    else
      return "DAT";
  }
}
