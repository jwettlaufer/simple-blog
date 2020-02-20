<?php
require './connection.php';

  session_start();

  if (isset($_GET) && !empty($_GET['logout'])) {
    session_destroy();
    session_unset();
    $_SESSION = [];
  }

  if (!isset($_SESSION) || empty($_SESSION)) {
      header('Location: login.php');
  }
$message = FALSE;

// SQL query string.
$sql = 'SELECT * FROM posts;';

// Execute query.
if ( $result = $connection->query( $sql ) ) {
    $message = 'Blog posts queried successfully!';
} else {
    $message = 'An error was encountered while trying to retrieve blog posts.';
    $message .= '<br><pre>'.print_r( $connection->error_list, TRUE ).'</pre>';
}
?><!DOCTYPE html>
<html>
    <head>
        <title>Blog Index</title>
    </head>
    <body>
    <header>
      <?php include( './nav.php' ); // nav ?>
    </header>
        <h1>Blog Index</h1>
        <?php if ( $message ) echo "<p>{$message}</p>"; // Show a message! ?>
        <ul>
            <?php while( $row = $result->fetch_assoc() ) : ?>
                <li>
                    <article>
                        <h2><?php echo $row['title']; ?></h2>
                        <p>
                            <time><?php echo date( 'Y.m.d', $row['date'] ); ?></time><br>
                            <?php echo $row['description']; ?>
                            <form action="./post.php" method="GET">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="submit" value="Read More">
                            </form>
                            <form action="./admin/edit.php" method="GET">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="submit" value="Edit Post">
                            </form>
                            <form action="./admin/delete.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="submit" value="Delete Post">
                            </form>
                        </p>
                    </article>
                </li>
            <?php endwhile; ?>
        </ul>
        <p><form action="#" method="GET">
          <input type="submit" name="logout" value="Logout!">
          </form>
        </p>
    </body>
</html>
