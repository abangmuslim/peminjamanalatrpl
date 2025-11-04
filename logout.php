<?php
session_start();
session_destroy();
header("Location: views/peminjam/loginpeminjam.php");
exit();
?>
