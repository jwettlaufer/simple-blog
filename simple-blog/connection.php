<?php
//Connect to DB
$connection = new mysqli(
  'localhost',
  'root',
  'root',
  'simple_blog'
);

//Handle error
if ($connection->error) {
  echo 'CONNECTION ERROR:' .$connection->error;
  die;
}
