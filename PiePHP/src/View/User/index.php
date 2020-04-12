<h1>Ceci est le index de View/User/index</h1>

<h3>
<?php
  if (isset($_SESSION['id'])) {
    echo '<p>You are connected as :' . $_SESSION['email'] . '</p>';
  ?>

    </br>
    <button><a href='/PiePHP/show'>Show</a></button>
    <button><a href='/PiePHP/logout'>Logout</a></button>
    </br>

  <?php
  } else {

  ?>
    <button><a href='/PiePHP/register/'>Register</a></button>
    <button><a href='/PiePHP/login/'>Login</a></button>
  <?php
  }
  ?>
</h3>