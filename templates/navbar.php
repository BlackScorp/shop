<nav class="navbar navbar-expand-lg navbar-light bg-light">
<div class="container">
  <a class="navbar-brand" href="#">My shop</a>
    <ul class="navbar-nav">
      <li class="nav-item">
        <?php if(isLoggedIn()):?>
          <a href="index.php/logout">Logout</a>
        <?php endif;?>
        <?php if(!isLoggedIn()):?>
          <a href="index.php/login">Login</a>
        <?php endif;?>
      </li>
    </ul>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a href="index.php/cart">Warenkorb (<?= $countCartItems ?>)</a>
    </li>
  </ul>
</div>
</nav>
