<?php
$alpha_variable = "hello";
$the_hello = "oh hi";

echo $the_hello;
echo "<br>";
${"the_{$alpha_variable}"} = "hello world";
echo $the_hello;
echo "<br>";
?>