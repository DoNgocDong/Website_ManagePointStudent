<?php

/**
 * @see https://github.com/miladrahimi/phprouter
 */

use MiladRahimi\PhpRouter\Router;
use MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException;
use Laminas\Diactoros\Response\HtmlResponse;

use App\Libs\Response\TemplateResponse;
use App\Core\Controllers\UserController;
use App\Core\Middlewares\AuthMiddleware;

use App\Core\Controllers\Auth\AuthController;
use App\Core\Controllers\Manage\CourseController;
use App\Core\Controllers\Manage\ScoreController;
use App\Core\Controllers\Manage\StudentController;
use App\Core\Controllers\Manage\ClassController;
use App\Core\Controllers\Manage\MajorController;
use App\Core\Controllers\Profession\ReviewController;

/**
 * ======================================START==================================================
 */

$router = Router::create();

// ===================BaseRoute===================
$majorRouter = [
  "prefix" => "/manage/major",
  "middleware" => [AuthMiddleware::class],
];
$classRouter = [
  "prefix" => "/manage/class",
  "middleware" => [AuthMiddleware::class],
];
$courseRouter = [
  "prefix" => "/manage/course",
  "middleware" => [AuthMiddleware::class],
];
$studentRouter = [
  "prefix" => "/manage/student",
  "middleware" => [AuthMiddleware::class],
];
$scoreRouter = [
  "prefix" => "/manage/score",
  "middleware" => [AuthMiddleware::class],
];

$toolRouter = [
  "prefix" => "/tools"
];

$authRouter = [
  "prefix" => "/auth",
];



// ===================HomePage===================
$router->get('/', function () {
    return new TemplateResponse('pages/homePage', []);
});

// ===================ManagerPage===================
$router->get("/manage/major", [MajorController::class, "display"]);
$router->group($majorRouter, function (Router $router) {
  //Các chức năng yêu cầu xác thực quyền truy cập
  $router->get("/{id}", [MajorController::class, "findById"]);
  $router->post("/", [MajorController::class, "insert"]);
  $router->post("/update/{id}", [MajorController::class, "updateById"]);
  $router->delete("/{id}", [MajorController::class, "deleteById"]);
});

$router->get("/manage/class", [ClassController::class, "display"]);
$router->group($classRouter, function (Router $router) {
  //Các chức năng yêu cầu xác thực quyền truy cập
  $router->get("/{id}", [ClassController::class, "findById"]);
  $router->post("/", [ClassController::class, "insert"]);
  $router->post("/update/{id}", [ClassController::class, "updateById"]);
  $router->delete("/{id}", [ClassController::class, "deleteById"]);
});

$router->get("/manage/course", [CourseController::class, "display"]);
$router->group($courseRouter, function (Router $router) {
  //Các chức năng yêu cầu xác thực quyền truy cập
  $router->get("/{id}", [CourseController::class, "findById"]);
  $router->post("/", [CourseController::class, "insert"]);
  $router->post("/update/{id}", [CourseController::class, "updateById"]);
  $router->delete("/{id}", [CourseController::class, "deleteById"]);
});

$router->get("/manage/student", [StudentController::class, "display"]);
$router->group($studentRouter, function (Router $router) {
  //Các chức năng yêu cầu xác thực quyền truy cập
  $router->get("/{id}", [StudentController::class, "findById"]);
  $router->post("/", [StudentController::class, "insert"]);
  $router->post("/update/{id}", [StudentController::class, "updateById"]);
  $router->delete("/{id}", [StudentController::class, "deleteById"]);
});

$router->get("/manage/score", [ScoreController::class, "display"]);
$router->group($scoreRouter, function (Router $router) {
  //Các chức năng yêu cầu xác thực quyền truy cập
  $router->get("/{id}", [ScoreController::class, "findById"]);
  $router->post("/", [ScoreController::class, "insert"]);
  $router->post("/update/{id}", [ScoreController::class, "updateById"]);
  $router->delete("/{id}", [ScoreController::class, "deleteById"]);
});


// ===================Tools===================
$router->group($toolRouter, function (Router $router) {
  $router->get("/final-score", [ReviewController::class, "display"]);
});



// ===================Authenticate===================
$router->group($authRouter, function (Router $router) {
  $router->get("/login", [AuthController::class, "displayLoginPage"]);
  $router->get("/change-password", [AuthController::class, "displayChangePassPage"]);
  $router->post("/login", [AuthController::class, "login"]);
});
$router->group(['middleware' => [AuthMiddleware::class]], function(Router $router) {
  $router->post("/auth/{username}/change-password", [AuthController::class, "changePass"]);
});


// ===================EXAMPLE ROUTER===================
$router->get("/user/{id}", 'UserController@getUser');

$router->get("/user/image", [UserController::class, "display"]);

$router->post("/user/pay", AuthMiddleware::class);

$router->delete("/user/create/{username}", 'UserController@getCreate');

$router->get("/view", 'UserController@getView');

/**
 * ======================================END====================================================
 */

try 
{
    $router->dispatch();
} 
catch (RouteNotFoundException $err) 
{
    $router->getPublisher()->publish(new HtmlResponse('Not found.', 404));
} 
catch (Throwable $err)
{
	if (DEBUG) error_log($err);
	else
    	$router->getPublisher()->publish(new HtmlResponse('Internal error.', 500));
}
