<?php
require './connection.php';

$message = FALSE;

if ( isset( $_GET['id'] ) ) {
    // Typecast ID as integer to avoid security risk.
    $id = (integer) $_GET['id'];
    // Prepare SQL string.
    $sql = 'SELECT * FROM posts WHERE id='.$id.';';
    // Execute SQL statement.
    if ( $result = $connection->query( $sql ) ) {
        $message = 'Post found!';
        $post;
        // Retrieve the post data (we're only getting 1 this time anyway!)
        while ( $row = $result->fetch_assoc() ) $post = $row;
    } else {
        $message = 'An error was encountered while trying to retrieve this post.';
        $message .= '<br><pre>'.print_r( $connection->error_list, TRUE ).'</pre>';
    }
} else {
    // Redirect the user to the index to try again.
    header( 'Location: index.php' );
    die; // Terminate script.
}
?><!DOCTYPE html>
<html>
    <head>
        <title><?php echo $post['title']; ?></title>
    </head>
    <body>
      <header>
        <?php include( './nav.php' ); // nav ?>
      </header>
        <h1><?php echo $post['title']; ?></h1>
        <?php if ( $message ) echo "<p>{$message}</p>"; // Show a message! ?>
        <p>
            <time><?php echo date( 'Y.m.d', $post['date'] ); ?></time>
            <?php echo $post['content']; ?>
        </p>
    </body>
</html>
