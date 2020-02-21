<?php
require '../connection.php';

session_start();

if (!isset($_SESSION['user']) || empty($_SESSION)) {
    header('Location: /simple-blog/login.php');
}

// Default message value.
$message = '';

if ( isset( $_GET['id'] ) && isset( $_POST ) && !empty( $_POST ) ) {
    $id = (integer) $_GET['id'];
    $sql = 'UPDATE posts
        SET title="'.$_POST['title'].'", content="'.$_POST['content'].'", description="'.$_POST['description'].'"
        WHERE id='.$id.';';
    if ( $connection->query( $sql ) ) {
        $message .= 'Successfully updated post: "'.$_POST['title'].'"';
    } else {
        $message .= 'Failed post update. Please try again.';
    }
}

if ( isset( $_GET['id'] ) ) {
    // Typecast ID as integer to avoid security risk.
    $id = (integer) $_GET['id'];
    // Prepare SQL string.
    $sql = 'SELECT * FROM posts WHERE id='.$id.';';
    // Execute SQL statement.
    if ( $result = $connection->query( $sql ) ) {
        $message .= 'Post found!';
        $post;
        // Retrieve the post data (we're only getting 1 this time anyway!)
        while ( $row = $result->fetch_assoc() ) $post = $row;

        // Decide values.
        $title = $_POST['title'] ?? $post['title'];
        $description = $_POST['description'] ?? $post['description'];
        $content = $_POST['content'] ?? $post['content'];
    } else {
        $message .= 'An error was encountered while trying to retrieve this post.';
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
        <title>Edit <?php echo $post['title']; ?></title>
    </head>
    <body>
    <header>
      <?php include( '../nav.php' ); // nav ?>
    </header>
        <h1>Edit <?php echo $post['title']; ?></h1>
        <?php if ( $message ) echo "<p>{$message}</p>"; // Show a message! ?>
        <form action="#" method="POST">
            <label for="title">
                Title:
                <input type="text" name="title" placeholder="Enter a title..."<?php if ( isset( $title ) ) echo ' value="'.$title.'"'; ?>>
            </label>
            <label for="content">
                Content:
                <textarea name="content" cols="30" rows="10" placeholder="Enter the blog post content..."><?php if ( isset( $content ) ) echo $content; ?></textarea>
            </label>
            <label for="description">
                Description:
                <input type="text" name="description" placeholder="Enter a description..."<?php if ( isset( $description ) ) echo ' value="'.$description.'"'; ?>>
            </label>
            <input type="submit" value="Update Post">
        </form>
    </body>
</html>
