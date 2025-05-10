<?php
session_start();
echo "Session ID: " . session_id() . "<br>";
echo "idsi: " . (isset($_SESSION['idsi']) ? $_SESSION['idsi'] : 'unset') . "<br>";
echo "namasi: " . (isset($_SESSION['namasi']) ? $_SESSION['namasi'] : 'unset') . "<br>";
echo "csrf_token: " . (isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : 'unset') . "<br>";
?>