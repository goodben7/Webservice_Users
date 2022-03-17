<?php

namespace App\Models;
namespace App\Models\Repository;
namespace App\Models\UserManager;

use App\Models\Repository\getUserByid;
use App\Models\Repository\getUserByuserId;
use App\Models\Repository\checkPassword;
use App\Models\UserManager\creatUser;
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->addBodyParsingMiddleware(); 
$app->addRoutingMiddleware();
$app->add(new BasePathMiddleware($app));
$app->addErrorMiddleware(true, true, true); 

$app->get('/users/{id :[0-9]+}', getUserByid::class . ':Action');

$app->get('/users/user/{id :[0-9]+}', getUserByuserId::class . ':Action');

$app->post('/users/auth', checkPassword::class . ':Action');

$app->post('/users', creatUser::class . ':Action');



$app->run();