<?php 

namespace App\Controllers;

use App\Models\ReviewModel;
use App\Models\UserModel;
use ShadowFiend\Framework\Config\Config;
use ShadowFiend\Framework\Controller\Controller;
use ShadowFiend\Framework\Validator\Validator;
use ShadowFiend\Framework\View\View;


class MainController extends Controller
{
	


	public function index()
	{
		session_start();
		
		$reviews = ReviewModel::where(['status', '=', 'accepted']);

		sd($reviews);
		
		return View::make('main/main', [
			'reviews_allowed' => $reviews
		]);

	}

	public function form()
	{
		
		$reqData = $this->getAllRequestData();

		$validator = Validator::make($reqData, [
			'name'    => 'string|required',
			'message' => 'string|required',
			'email' => 'string|email|required',
			'review-file' => 'file:jpeg:png:gif'
		]);

		if ($validator->hasErrors()) {
			header('HTTP/1.0 422 Unprocessable Entity (Bad Validation Request)');
			echo json_encode($validator->getErrors());
			return;
		}

		$review = new ReviewModel;

		$review->name  = $reqData['name'];

		$review->email = $reqData['email'];

		$review->body  = $reqData['message'];

		$review->save();

	}


}

