<?php
require './connection.php';

  session_start();

  if (isset($_GET) && !empty($_GET['logout'])) {
    session_destroy();
    session_unset();
    $_SESSION = [];
    header('Location: login.php');
  }

$message = FALSE;

// define results per page
$results_per_page = 2;

// find the number of results in database
$sql='SELECT * FROM posts';
$result = $connection->query( $sql );
$number_of_results = mysqli_num_rows($result);

// determine number of total pages available
$number_of_pages = ceil($number_of_results/$results_per_page);

// determine current page number
if (!isset($_GET['page'])) {
  $page = 1;
} else {
  $page = $_GET['page'];
}

// determine the sql LIMIT starting number for the results on the displaying page
$this_page_first_result = ($page-1)*$results_per_page;

// SQL query string.
$sql='SELECT * FROM posts LIMIT ' . $this_page_first_result . ',' .  $results_per_page;
$result = $connection->query( $sql );

// Execute query.
if ( $result = $connection->query( $sql ) ) {
    $message = 'See current blog posts below.';
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
        <?php if ($_SESSION['logged_in']) {
          echo 'Welcome: ' . $_SESSION['user'] . ', you are logged in.';} ?>
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
                          <?php if ($_SESSION['logged_in']) : ?>
                            <form action="./admin/edit.php" method="GET">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="submit" value="Edit Post">
                            </form>
                            <form action="./admin/delete.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="submit" value="Delete Post">
                            </form>
                          <?php endif; ?>
                        </p>
                    </article>
                </li>
            <?php endwhile; ?>
        </ul>
        <?php // display the links to the pages
        for ($page=1;$page<=$number_of_pages;$page++) {
          echo '<a href="index.php?page=' . $page . '">' . $page . '</a> ';
        } ?>
        <?php if ($_SESSION['logged_in']) : ?>
        <p>
          <form action="./admin/new.php" method="GET">
            <input type="hidden" name="id">
            <input type="submit" value="New Post">
          </form>
          <form action="#" method="GET">
            <input type="submit" name="logout" value="Logout!">
          </form>
        </p>
        <?php endif; ?>
    </body>
</html>
