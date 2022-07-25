<?php
	session_start();

	define('VIEWS_PATH','views/');
	define('MODELS_PATH','models/');
	define('CONTROLLERS_PATH','controllers/');
	define('STATUS',array('SUBMITTED'=>'Envoyé','ACCEPTED'=>'Accepté','REFUSED'=>'Refusé','CLOSED'=>'Fermé'));
	define('MEMBER_RANK',array('admin'=>'Administrateur','member'=>'Simple utilisateur'));
	function loadClass($className) {
		require_once('models/' . $className . '.class.php');
	}
	spl_autoload_register('loadClass');

	(new DotEnv(__DIR__ . '/.env'))->load();
	
	$db=Db::getInstance();
	if (empty($_GET['action'])) {
		$_GET['action'] = 'accueil';
	}

	# Log in for the demo
	if (getenv('DEMO') == 1 && empty($_SESSION['demo_site'])) {
		$_SESSION['demo_site'] = 1;
		$_SESSION['user_id'] = "admin@gmail.com";
	}

	require_once(CONTROLLERS_PATH.'HeaderController.php');
	$headerController = new HeaderController($db);
	$headerController->run();
	
	switch ($_GET['action']) {
		case 'profil':
			require_once(CONTROLLERS_PATH.'ProfilController.php');
			$controller = new ProfilController($db);
			break;  
		case 'idea':
			require_once(CONTROLLERS_PATH.'IdeaController.php');
			$controller = new IdeaController($db);
			break;
		case 'vote':
			require_once(CONTROLLERS_PATH.'VoteController.php');
			$controller = new VoteController($db);
			break;
		case 'login':
			require_once(CONTROLLERS_PATH.'LoginController.php');
			$controller = new LoginController($db);
			break;
		case 'logout':
			require_once(CONTROLLERS_PATH.'LogoutController.php');
			$controller = new LogoutController();
			break;
		case 'signin':
			require_once(CONTROLLERS_PATH.'SigninController.php');
			$controller = new SigninController($db);
			break;
		case 'admin-user':
			require_once(CONTROLLERS_PATH.'AdminUserController.php');
			$controller = new AdminUserController($db);
			break;
		case 'admin-idea':
			require_once(CONTROLLERS_PATH.'AdminIdeaController.php');
			$controller = new AdminIdeaController($db);
			break;
		default:
			require_once(CONTROLLERS_PATH.'HomeController.php');
			$controller = new HomeController($db);
			break;
	}
	$controller->run();
	include(VIEWS_PATH.'footer.php');
?>