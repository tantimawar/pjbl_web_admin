<?php

require 'function.php';

$username = $_GET["username"];

if (hapususer($username) > 0) {
    echo "<script>alert('Berhasil Menghapus User'); document.location.href = 'manageuser.php'; </script>";
} else {
}
