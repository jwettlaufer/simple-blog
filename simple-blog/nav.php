<?php
session_start();
?>
  <nav>
    <ul>
      <li>
        <a href="/simple-blog/index.php">Home</a>
      </li>
      <?php if (!isset($_SESSION['user'])) : ?>
      <li>
        <a href="/simple-blog/login.php">Login</a>
      </li>
    <?php endif; ?>
    </ul>
  </nav>
