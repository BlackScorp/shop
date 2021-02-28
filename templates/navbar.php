<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container">
		<a class="navbar-brand" href="#">My shop</a>
		<ul class="navbar-nav">
			<li class="nav-item">
                <?php
                if (isLoggedIn()): ?>
					<a class="nav-link" href="index.php/logout">Logout</a>
                <?php
                endif; ?>
                <?php
                if (!isLoggedIn()): ?>
					<a class="nav-link" href="index.php/login">Login</a>
                <?php
                endif; ?>
			</li>
			<?php
                if (isAdmin()): ?>
				<li class="nav-item">
					<a class="nav-link" href="index.php/dashboard">Dashboard</a>
				</li>
                <?php
                endif; ?>
            <?php
            if (!isLoggedIn()): ?>
				<li class="nav-item">
					<a class="nav-link" href="index.php/register">Registrieren</a>
				</li>
            <?php
            endif; ?>
		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a href="index.php/cart">Warenkorb (<?= $countCartItems ?>)</a>
			</li>
		</ul>
	</div>
</nav>
