<?php
  namespace App\Domain\Services;

use App\Core\Models\Accounts\AdminModel;

  class AccountService {
    private AdminModel $adminModel;

    public function __construct() {
      $this->adminModel = new AdminModel();
    }

    public function authenticate($username, $password) {
      $conditions["username"] = $username;
      $conditions["password"] = $password;

      $account = $this->adminModel->has($conditions);

      if(!$account) {
        return false;
      }

      $token = base64_encode($username);

      return $token;
    }
  }
?>