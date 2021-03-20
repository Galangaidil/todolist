<?php

session_start();
session_unset("user");
$_SESSION["user"] = [];
header("Location: index.php");
