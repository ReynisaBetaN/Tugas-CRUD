<?php 
class Data {

	private $mysqli;

	function __construct($conn) {
		$this->mysqli = $conn;
	}

	public function tampil($id = null){
		$db = $this->mysqli->conn;
		$sql = "SELECT * FROM tbl_mhs";
		if($id != null) {
			$sql .= " WHERE id = $id";
		}
		$query = $db->query($sql) or die ($db->error);
		return $query;
	}

	public function tambah($nim, $namamhs, $jk, $alamat, $kota, $email, $foto) {
		$db = $this->mysqli->conn;
		$db->query("INSERT INTO tbl_mhs VALUES('', '$nim', '$namamhs', '$jk', '$alamat', '$kota', '$email', '$foto')") or die($db->error);
	}

}
?>