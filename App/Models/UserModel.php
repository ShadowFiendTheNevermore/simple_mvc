<?php 
namespace App\Models;

use ShadowFiend\Framework\Application\DB;
use ShadowFiend\Framework\Config\Config;
use ShadowFiend\Framework\Model\Model;

/**
*
*
* 
*/
class UserModel extends Model
{
	
	protected $table_name = 'users';

	// protected static function checkUserData($login)
	// {
	// }

	public static function getUser($login)
	{
		$db = DB::getConnection();

		$table = Config::getValue('db.users_table');

		$sth = $db->prepare("SELECT * FROM $table WHERE `login` = :login");

		$sth->execute([':login' => $login]);

		$user = $sth->fetch();

		return $user;
	}


	public static function isAdmin($user)
	{
		if ($user['type'] == 'admin') {
			return true;
		} else {
			return false;
		}
	}
	
	public static function auth($login, $password)
	{
		
		$user = self::getUser($login);


		if ($user['login'] == $login && password_verify($password, $user['password'])) {
			session_start();
			$_SESSION['user']['id']    = $user['id'];
			$_SESSION['user']['login'] = $user['login'];
			$_SESSION['user']['type']  = $user['type'];
			return $user;
		} else {
			// TODO: make response for bad login data
			return header('Location: /login');
		}

	}


	/**
	 * Returns true if user authenticated
	 * 
	 * @return boolean
	 */
	public static function authCheck()
	{
		$authenticated = empty($_SESSION['user']) ? true : false;
		return $authenticated;
	}




}