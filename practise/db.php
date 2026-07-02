<?php

$link = mysqli_connect("localhost", "practise", "ijB]SYs6HOLa9WAN", "practise")
	or die("DB conn err:" . mysqli_connect_error());

mysqli_set_charset($link, "utf8mb4");
