<?php
if (isset($_SESSION['id'])) {
  echo '<h1>The parameters can be change inside UserController</h1>';

  // if ( isset($info) && isset($info[0]) && isset($info['0']['content']) ) {
  //   foreach ($info as $key => $value) {
  //     echo $value['id'] . " - " . $value['email'] . " - " .  $value['content'] . "<br>";
  //   }
  // }


  if ( isset($info['id']) ) {
    echo "<p>User n <b>{$info['id']}</b>, email: {$info['email']}</p>";
  }
  else if (isset($info) && count($info) > 0 && isset($info[0]) && count($info[0]) > 0) {
    if (isset($info[0]) && is_array($info[0]) ) {
      for ($i = 0; $i < count($info); $i++) {
        if (isset($info[$i]['content'])) {
          echo "<p>Comment by user n<b>{$info[$i]['id']}</b>: {$info[$i]['content']}</p>";
        } else if ( isset($info[0]['id']) ) {
          echo "<p>User n <b>{$info[$i]['id']}</b>, email: {$info[$i]['email']}</p>";
        } else if ( isset($info['id']) ){
          echo "<p>User n <b>{$info['id']}</b>, email: {$info['email']}</p>";
        }
      }
    }
  } else {
    echo '<p>There are no users results</p>';
  }
} else {
  echo '<p>You need to be logged in to see the users list.</p>';
}
