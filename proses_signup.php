<?php
include 'koneksi.php';

$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

if(mysqli_num_rows($cek) > 0){
    echo "<script>alert('Email sudah terdaftar! Silakan gunakan email lain.'); window.location='signup.php';</script>";
} else {
    mysqli_query($conn, "INSERT INTO users (nama_user, email, password) VALUES ('$nama','$email','$password')");
    echo "<script>alert('Pendaftaran Pegawai Berhasil! Silakan masuk.'); window.location='signin.php';</script>";
}
?>