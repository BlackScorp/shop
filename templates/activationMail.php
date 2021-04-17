<?php
require_once __DIR__ . '/htmlHead.php' ?>
	<section id="activationMail" class="container">

		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="offset-6 col-6 text-right">
						<div id="users">Benutzername: <?= $username ?></div>
						<div id="registerDate">Registriert: <span class="time"><?= $registrationDate ?></span></div>
					</div>
				</div>
			</div>
			<div class="card-body" id="content">
				<p>Hallo <?= $username ?>,</p>
				<p>vielen Dank für Ihre Registrierung.<br/>
					Um Ihren Account zu Aktivieren klicken Sie auf den Button:</p>
				<p><a href="<?= $activationLink ?>" class="btn btn-success" role="button">Jetzt Aktivieren</a></p>
				<p>Oder verwenden Sie den Direkten Link per Hand: <?= $activationLink ?></p>
				<p>Für eine manuelle Aktivierung verwenden Sie bitte den folgenden Code:</p>
				<p><b>Ihr Link:</b> <?= $projectUrl ?>index.php/account/activate/<?= $username ?>/<?= $activationKey ?></p>
				<p><b>Ihr Benutzername:</b> <?= $username ?><br/>
					<b>Ihr Aktivierungscode:</b> <?= $activationKey ?></p>
				<p>
				<hr/>
				</p>
				<p>
				<div class="alert alert-warning" role="alert"><b>Hinweis:</b> Wir fragen Sie nie nach Ihrem Passwort!</div>
				</p>
				<p>
				<hr/>
				</p>
				<p>Mit freundlichen Grüßen</p>
				<p>XXX - Team</p>
			</div>
			<div class="card-footer" id="footer">
				<p>Copyright &copy;<?= $currentYear ?> by <a href="<?= $projectUrl ?>"><?= COMPANY_NAME ?></a> &middot; All Rights reserved.</p>
			</div>
		</div>


	</section>
<?php
require_once __DIR__ . '/footer.php' ?>