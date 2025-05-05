<?php
include_once "common.php";

if (is_session_started() === FALSE) {
	session_start();
}
?>

<!DOCTYPE HTML>

<html lang=pt-br>

<head>
	<meta charset="UTF-8">
	<title><?php echo $page_title; ?></title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
	<header class="bg-white shadow p-4 flex items-center justify-between">
		<!-- Logo Area -->
		<div class="flex items-center space-x-4">
			<div class="w-10 h-10 bg-blue-600 text-white flex items-center justify-center rounded-full text-xl font-bold">
				<a href="<?php echo (isset($_SESSION["admin"]) && $_SESSION["admin"] == TRUE) ? 'index_admin.php' : './login.php'; ?>" class="w-full h-full text-white hover:text-gray-200 relative"> </a>
				<i class="fas fa-home"></i>
			</div>
			<h1 class="text-xl font-semibold text-gray-800"><?= $page_title ?></h1>
		</div>

		<!-- Login Info -->
		<div class="text-sm text-gray-700 space-x-4">
			<?php
			if (isset($_SESSION["username"])) {
				echo "<span>Você está logado como <strong>" . htmlspecialchars($_SESSION["username"]) . "</strong></span>";
				echo "<a href='./actions/login/execute_logout.php' class='text-red-600 hover:underline'>Logout</a>";
			} else {
				echo "<a href='login.php' class='text-blue-600 hover:underline'>Efetuar Login</a>";
			}
			?>
		</div>
	</header>