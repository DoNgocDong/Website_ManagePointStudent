<?php

namespace App\Core\Controllers;

use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Response\JsonResponse;
use App\Libs\Response\FileResponse;
use App\Core\Models\UserModel;
use App\Libs\Controller\Controller;

class UserController extends Controller
{

	public function getUser (ServerRequest $request, $id)
	{
		return new JsonResponse([
			'id' => $id
		]);
	}

	public function getImage(ServerRequest $request)
	{
		return new FileResponse("images/logo.png");
	}

	public function postPay (ServerRequest $request)
	{
		return new JsonResponse([
			'result' => 'success'
		]);
	}

	public function getCreate($username)
	{
		$userModel = new UserModel();
		$userModel->insert([
			'username' => $username
		]);
		return new JsonResponse([
			'result' => 'success',
			'username' => $username
		]);
	}

	public function display()
	{
		return $this->renderView('pages/homePage',[
			'greet' => 'Hello World'
		],200);
	}

}