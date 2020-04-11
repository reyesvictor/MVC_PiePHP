  <?php
  if (isset($_SESSION['id'])) {
    echo '<p>You are trying register, but you are connected as :' . $_SESSION['email'] . '</p>';
  ?>

    </br>
    <p>You need to logout first</p>
    <button><a href='/PiePHP/show'>Show</a></button>
    <button><a href='/PiePHP/logout'>Logout</a></button>
    </br>

  <?php
  } else {
  ?>

    <h3>Register Here</h3>
    <form action="/PiePHP/register" method="post">
      <label for="fname">Email</label><br>
      <input type="text" id="email" name="email" value="victor.reyes@"><br>
      <label for="lname">Password</label><br>
      <input type="password" id="pwd" name="password" value="root"><br><br>
      <input type="submit" value="Submit">
    </form>
  <?php
  }
  ?>