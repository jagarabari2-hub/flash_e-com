<?php
require_once 'config.php';

$message = getMessage();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login_btn'])) {
	$email = sanitize($_POST['email'] ?? '');
	$password = sanitize($_POST['password'] ?? '');

	if (empty($email) || empty($password)) {
		$_SESSION['message'] = 'Please fill in all fields';
		$_SESSION['message_type'] = 'danger';
	} elseif (userLogin($email, $password)) {
		redirectWithMessage('index.php', 'Login successful! Welcome back.', 'success');
	} else {
		$_SESSION['message'] = 'Invalid email or password';
		$_SESSION['message_type'] = 'danger';
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login - FLASH E-Commerce</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="mcss/modern-style.css">
</head>

<body style="background: linear-gradient(135deg, var(--dark-bg) 0%, var(--accent-color) 100%);">
	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark">
		<div class="container-fluid">
			<a class="navbar-brand" href="index.php">
				<i class="fas fa-bolt"></i> FLASH
			</a>
			<a href="register.php" class="btn btn-secondary-custom ms-auto">
				Create Account
			</a>
		</div>
	</nav>

	<!-- Message Alert -->
	<?php if ($message): ?>
		<div class="alert alert-<?php echo $message['type']; ?> alert-dismissible fade show m-3" role="alert">
			<?php echo $message['message']; ?>
			<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
		</div>
	<?php endif; ?>

	<!-- Login Form -->
	<div class="auth-container">
		<div class="auth-title">
			<i class="fas fa-sign-in-alt"></i> Login
		</div>

		<form method="POST">
			<div class="form-group">
				<label for="email">Email Address</label>
				<input type="email" id="email" name="email" class="form-control"
					placeholder="Enter your email" required>
			</div>

			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" id="password" name="password" class="form-control"
					placeholder="Enter your password" required>
			</div>

			<div class="form-group">
				<a href="#">Forgot Password?</a>
			</div>

			<button type="submit" name="login_btn" class="btn btn-primary-custom w-100 py-2">
				<i class="fas fa-sign-in-alt"></i> Login
			</button>
		</form>

		<div class="auth-link">
			Don't have an account?
			<a href="register.php">Register here</a>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>