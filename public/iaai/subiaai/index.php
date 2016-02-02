<?php
echo "
	hello world, ini sub
";

$con=mysqli_connect("localhost","root","Sangkuriang@Sampurna9","retane");
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
	echo "berhasil konek";
}