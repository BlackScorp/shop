<?php
if ($hasFlashMessages): ?>
	<div class="alert alert-success" role="alert">
        <?php
        foreach ($flashMessages as $message): ?>
			<p><?= $message ?></p>
        <?php
        endforeach ?>
	</div>
<?php
endif; ?>