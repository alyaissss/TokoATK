<?php
session_start();
include 'koneksi.php';

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$password'");
$data = mysqli_fetch_assoc($query);

if($data){
    $_SESSION['user_id'] = $data['id_user']; 
    $_SESSION['nama_user'] = $data['nama_user'];
    header("Location: barang.php");
    exit();
} else {
    echo "<script>alert('Login gagal! Email atau password salah'); window.location='signin.php';</script>";
}
?>