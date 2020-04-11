<h3>
  <?php
  if (isset($_SESSION['id'])) {
    echo '<p>You can\'t login, you are connected as n' . $_SESSION['id'] . ', '. $_SESSION['email'] . '</p>';
    echo "<p>You need to logout first</p>
    <button><a href='/PiePHP/show'>Show</a></button>
    <button><a href='/PiePHP/logout'>Logout</a></button>";
  } else {

  ?>
    <h3>Please enter your email and password to login :)</h3>
    <h4>Login Here</h4>
    <form action="/PiePHP/login/" method="post">
      <label for="fname">Email</label><br>
      <input type="text" id="email" name="email" value="victor.reyes@"><br>
      <label for="lname">Password</label><br>
      <input type='password' id="pwd" name="password" value="root"><br><br>
      <input type="submit" value="Submit">
    </form>
  <?php
  }
  ?>
</h3>