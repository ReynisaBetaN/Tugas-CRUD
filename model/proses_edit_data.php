<?php
ob_start();
require_once('../config/+koneksi.php');
require_once('../model/database.php');
include "../model/m_data.php";
$connection = new Database($host, $user, $pass, $database);
$dt = new Data($connection);

$id = $_POST['id'];
$id = $connection->conn->real_escape_string($_POST['id']);
$nim = $connection->conn->real_escape_string($_POST['nim']);
$namamhs = $connection->conn->real_escape_string($_POST['namamhs']);
$jk = $connection->conn->real_escape_string($_POST['jk']);
$alamat = $connection->conn->real_escape_string($_POST['alamat']);
$kota = $connection->conn->real_escape_string($_POST['kota']);
$email = $connection->conn->real_escape_string($_POST['email']);

$pict = $_FILES['foto']['name'];        
$extensi = explode(".", $_FILES['foto']['name']);
$foto = "fotomhs-".round(microtime(true)).".".end($extensi);
$sumber = $_FILES['foto']['tmp_name'];

if($pict == '') {
	$dt->edit("UPDATE tbl_mhs SET nim = '$nim', namamhs = '$namamhs', jk = '$jk', alamat = '$alamat', kota = '$kota', email = '$email' WHERE id ='$id' ");
}  else {

}             
?>