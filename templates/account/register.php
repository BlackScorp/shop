<?php
require_once TEMPLATES_DIR . '/header.php' ?>
<section id="register" class="container">
	<form action="index.php/account/register" method="POST">
		<div class="card">
			<div class="card-header">
				Registrierung
			</div>
			<div class="card-body">
                <?php
                require_once TEMPLATES_DIR . '/errorMessages.php' ?>
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" value="<?= $username ?>" name="username" id="username" class="form-control">
				</div>
				<div class="form-group">
					<label for="email">E-mail</label>
					<input type="email" value="<?= $email ?>" name="email" id="email" class="form-control">
				</div>
				<div class="form-group">
					<label for="emailRepeat">E-mail wiederholen</label>
					<input type="email" value="<?= $emailRepeat ?>" name="emailRepeat" id="emailRepeat" class="form-control">
				</div>
				<div class="form-group">
					<label for="password">Passwort</label>
					<input type="password" value="<?= $password ?>" name="password" id="password" class="form-control">
				</div>
				<div class="form-group">
					<label for="passwordRepeat">Passwort wiederholen</label>
					<input type="password" value="<?= $passwordRepeat ?>" name="passwordRepeat" id="passwordRepeat" class="form-control">
				</div>

			</div>
			<div class="card-footer">
				<button class="btn btn-success" type="submit">Account anlegen</button>
			</div>
		</div>
	</form>
</section>
<?php
require_once TEMPLATES_DIR . '/footer.php' ?>
