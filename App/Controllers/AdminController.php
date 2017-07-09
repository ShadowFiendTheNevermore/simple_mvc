<?php 

namespace App\Controllers;

use App\Models\ReviewModel;
use ShadowFiend\Framework\Controller\Controller;
use ShadowFiend\Framework\View\View;

/**
* 
*/
class AdminController extends Controller
{


	public function index()
	{
		session_start();

		if ($_SESSION['user']['type'] !== 'admin') {
			return $this->redirect('/login');
		}

		$reviews = ReviewModel::all();

		return View::make('dashboard/index', ['reviews' => $reviews]);
		
	}


}