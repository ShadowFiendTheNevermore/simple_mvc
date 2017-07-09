<?php 

namespace App\Controllers;

use App\Models\UserModel;
use ShadowFiend\Framework\Config\Config;
use ShadowFiend\Framework\Controller\Controller;
use ShadowFiend\Framework\Validator\Validator;
use ShadowFiend\Framework\View\View;


class AuthController extends Controller
{


	public function index()
	{
		return View::make('auth/auth_form');
	}


	public function auth()
	{
		$request = $this->getRequestData('POST');

		$user = UserModel::auth($request['login'], $request['password']);

		if (UserModel::isAdmin($user)) {
			return $this->redirect('/admin-dashboard');
		}

		return $this->redirect('/');
	}

	public function register()
	{
	
		$reqData = $this->getRequestData('POST');

		$validator = Validator::make($reqData, [
			'login' => 'string|required|unique:users',
			'password' => 'string|required'
		]);
		
		if (!$validator->hasErrors()) {
			
			UserModel::insert([
				'login' => $reqData['login'],
				'password' => password_hash($reqData['password'], PASSWORD_DEFAULT)
			]);

			UserModel::auth($reqData['login'], $reqData['password']);
			$this->redirect('/');

		} else {
			return View::make('auth/reg_form', ['errors' => Validator::getErrors()]);
		}

	}

	public function form()
	{
		return View::make('auth/reg_form');
	}

	public function logout()
	{
		session_start();
		unset($_SESSION['user']);
		session_destroy();

		$this->redirect('/');
	}


}