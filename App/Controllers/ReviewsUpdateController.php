<?php 

namespace App\Controllers;

use App\Models\ReviewModel;
use ShadowFiend\Framework\Controller\Controller;



class ReviewsUpdateController extends Controller
{


	public function update($id, $type)
	{
		session_start();

		$user = $_SESSION['user'];

		if ($user['type'] !== 'admin') {
			header('HTTP/1.0 403');
			echo json_encode('Only admin is allowed');
			return;
		}

		ReviewModel::updateWhere(['status' => $type], "id = $id");

		
	}


}