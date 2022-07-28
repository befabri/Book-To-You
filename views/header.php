<!DOCTYPE HTML>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<link rel="icon" href="favicon.png" sizes="16x16" type="image/png"> 
		<link rel="stylesheet" type="text/css" href="<?php echo VIEWS_PATH ?>css/main.css">
		<title>BookToYou</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	</head>
	<body>
		<header>
			<div class="navbar">
				<a class="logo" href="index.php">BookToYou</a>
				<nav>
					<?php echo ($isAuthenticated)?"<a href='index.php?action=profil'>Profil</a>":"<a href='index.php?action=signin'>S'enregistrer</a>";?>
					<?php if($isAdmin) {
						echo "
						<div class='dropdown'>
							<a>Admin</a>
							<div class='dropdown-content'>
								<a href='index.php?action=admin-user'>Utilisateurs</a>
								<a href='index.php?action=admin-idea'>Ideés</a>
							</div>
						</div>";
					} else {
						echo "";
					};?>
		
					<?php echo ($isAuthenticated)?"<a href='index.php?action=logout'>Déconnexion</a>":"<a href='index.php?action=login'>Se connecter</a>";?>
				</nav>
			</div>
		</header>
		<main>