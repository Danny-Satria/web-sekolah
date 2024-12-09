<?php
// include "../include/config.php";
// @session_start();


// if(isset($_POST['submit'])){
//     $user = mysqli_real_escape_string($koneksi,$_POST['user']);
//     $pass = mysqli_real_escape_string($koneksi,md5($_POST['pass']));

//     $sql = "SELECT * FROM tb_admin WHERE nama_admin = '$user' AND password = '$pass' ";
//     $query = mysqli_query($koneksi,$sql);

//     if(mysqli_num_rows($query) > 0){
//         session_start();
//         $data = mysqli_fetch_array($query);
//         $_SESSION['username'] = $data['nama_admin'];
//         $_SESSION['data'] = $data;

//         header('location : admin.php');
//     }else{
//         echo "<script>alert('Username atau Password Salah')</script>";
//     }

// }

 

include "../include/config.php";
session_start();

if(isset($_POST['submit'])) {
    $user = mysqli_real_escape_string($koneksi, $_POST['user']);
    $pass = mysqli_real_escape_string($koneksi, md5($_POST['pass']));
    
    $sql = "SELECT * FROM tb_admin WHERE nama_admin = '$user' AND password = '$pass'";
    $query = mysqli_query($koneksi, $sql);
    
    if(mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query);
        $_SESSION['username'] = $data['nama_admin'];
        $_SESSION['data'] = $data;
        header('Location: admin.php');
        exit();
    } else {
        echo "<script>alert('Username atau Password Salah') 
        window.location.href= 'index.php'</script>";
    }
}
?>

