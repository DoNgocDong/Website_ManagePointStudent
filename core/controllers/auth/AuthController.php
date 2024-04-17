<?php

namespace App\Core\Controllers\Auth;

use App\Core\Models\Accounts\AdminModel;
use App\Domain\Services\AccountService;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Response\JsonResponse;
use App\Libs\Controller\Controller;
use App\Libs\Utils\Utility;
use Exception;

class AuthController extends Controller {
  private AdminModel $adminModel;
  private AccountService $accountService;
  private Utility $utils;

  public function __construct() {
    $this->adminModel = new AdminModel();
    $this->accountService = new AccountService();
  }
  
  public function login() {
    $this->utils = new Utility();

    $username = $this->utils->get_POST("userLogin");
    $password = $this->utils->get_POST("passLogin");

    if(!$username) {
      return new JsonResponse([
        "message" => "Username không được trống!"
      ], 401);
    }

    if(!$password) {
      return new JsonResponse([
        "message" => "Password không được trống!"
      ], 401);
    }

    $token = $this->accountService->authenticate($username, $password);

    if(!$token) {
      return new JsonResponse([
        "message" => "Tài khoản hoặc mật khẩu không chính xác!"
      ], 401);
    }

    return new JsonResponse([
      "token" => $token,
      "message" => "Đăng nhập thành công!"
    ]);
  }

  public function changePass(ServerRequest $request, $username) {
    $this->utils = new Utility();

    $oldData = $this->adminModel->selectOne(["username" => $username]);
    $oldPass = $this->utils->get_POST("oldPass");
    $newPass = $this->utils->get_POST("newPass");
    $verifyPass = $this->utils->get_POST("verifyPass");


    if($oldPass !== $oldData["password"]) {
      return new JsonResponse([
        "message" => "Mật khẩu cũ không đúng!"
      ], 400);
    }   
    elseif($newPass !== $verifyPass) {
      return new JsonResponse([
        "message" => "Mật khẩu mới và xác nhận mật khẩu phải giống nhau!"
      ], 400);
    }

    $this->adminModel->update(
      ["password" => $newPass], 
      ["username" => $username]
    );

    return new JsonResponse([
      "message" => "Đổi mật khẩu thành công!"
    ]);
  }

  public function displayLoginPage() {
    $this->renderView("auth/loginPage", []);
  }

  public function displayChangePassPage() {
    $this->renderView("auth/changePassPage", []);
  }

}