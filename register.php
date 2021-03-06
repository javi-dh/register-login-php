<?php
	// llamamos a las funciones controladoras
	require_once 'register-controller.php';

	if ( isLogged() ) {
		header('location: profile.php');
		exit;
	}

	$pageTitle = 'Register';
	require_once 'includes/head.php';
	$countries = [
		'ar' => 'Argentina',
		'bo' => 'Bolivia',
		'br' => 'Brasil',
		'co' => 'Colombia',
		'cl' => 'Chile',
		'ec' => 'Ecuador',
		'pa' => 'Paraguay',
		'pe' => 'Perú',
		'uy' => 'Uruguay',
		've' => 'Venezuela',
	];

	// Persistencia de datos
	// $userFullName = $_POST['userFullName'] ?? '';
	$userFullName = isset($_POST['userFullName']) ? trim($_POST['userFullName']) : '';
	$userEmail = isset($_POST['userEmail']) ? trim($_POST['userEmail']) : '';
	$userCountry = isset($_POST['userCountry']) ? trim($_POST['userCountry']) : '';

	$errors = [];

	if ($_POST) {
		$errors = registerValidate($_POST, $_FILES);

		if ( count($errors) == 0 ) {

			$imageName = saveImage($_FILES['userAvatar']);

			$_POST['avatar'] = $imageName;

			$user = saveUser($_POST);

			logIn($user);
		}
	}
?>
	<?php require_once 'includes/navbar.php'; ?>

	<!-- Register-Form -->
	<div class="container" style="margin-top:30px; margin-bottom: 30px;">
		<div class="row justify-content-center">
			<div class="col-md-10">
				<?php if ( $errors ): ?>
					<div class="alert alert-danger">
						<ul>
						<?php foreach ($errors as $error): ?>
							<li> <?= $error ?> </li>
						<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
				<h2>Formulario de registro</h2>

				<form method="post" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label><b>Nombre completo:</b></label>
								<input
									type="text"
									name="userFullName"
									class="form-control <?= isset($errors['fullName']) ? 'is-invalid' : ''; ?>"
									value="<?= $userFullName; ?>"
								>
								<?php if (isset($errors['fullName'])): ?>
									<div class="invalid-feedback">
										<?= $errors['fullName'] ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><b>Correo electrónico:</b></label>
								<input
									type="text"
									name="userEmail"
									class="form-control <?= isset($errors['email']) ? 'is-invalid' : ''; ?>"
									value="<?= $userEmail; ?>"
								>
								<?php if (isset($errors['email'])): ?>
									<div class="invalid-feedback">
										<?= $errors['email'] ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><b>Password:</b></label>
								<input
									type="password"
									name="userPassword"
									class="form-control <?= isset($errors['password']) ? 'is-invalid' : ''; ?>"
								>
								<?php if (isset($errors['password'])): ?>
									<div class="invalid-feedback">
										<?= $errors['password'] ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><b>Repetir Password:</b></label>
								<input
									type="password"
									name="userRePassword"
									class="form-control <?= isset($errors['password']) ? 'is-invalid' : ''; ?>"
								>
								<?php if (isset($errors['password'])): ?>
									<div class="invalid-feedback">
										<?= $errors['password'] ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><b>País de nacimiento:</b></label>
								<select
									name="userCountry"
									class="form-control <?= isset($errors['country']) ? 'is-invalid' : ''; ?>"
								>
									<option value="">Elegí un país</option>
									<?php foreach ($countries as $code => $country): ?>
										<option
											<?= $code == $userCountry ? 'selected' : '' ?>
											value="<?= $code ?>"><?= $country ?></option>
									<?php endforeach; ?>
								</select>
								<?php if (isset($errors['country'])): ?>
									<div class="invalid-feedback">
										<?= $errors['country'] ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><b>Imagen de perfil:</b></label>
								<div class="custom-file">
									<input
										type="file"
										class="custom-file-input <?= isset($errors['image']) ? 'is-invalid' : ''; ?>"
									 	name="userAvatar"
									>
									<label class="custom-file-label">Choose file...</label>
									<?php if (isset($errors['image'])): ?>
										<div class="invalid-feedback">
											<?= $errors['image'] ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<div class="col-12">
							<button type="submit" class="btn btn-primary">Registrarse</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- //Register-Form -->

<?php require_once 'includes/footer.php'; ?>
