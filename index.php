<?php 

require __DIR__ . '/vendor/autoload.php';

$app = new ShadowFiend\Framework\Application\Application(__DIR__.'/App');

$app->setRouter(new ShadowFiend\Framework\Router\Router);


// GET requests
$app->get('/', 'MainController_Index');

$app->get('/login', 'AuthController_Index');

$app->get('/admin-dashboard', 'AdminController_Index');

$app->get('/register', 'AuthController_Form');
$app->get('/logout', 'AuthController_Logout');


// POST requests
$app->post('/auth', 'AuthController_Auth');
$app->post('/register', 'AuthController_Register');
$app->post('/', 'MainController_Form');
$app->post('/reviews/update/{id}/{type}', 'ReviewsUpdateController_Update');


$app->run();

