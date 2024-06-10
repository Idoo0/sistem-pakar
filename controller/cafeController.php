<?php
	// read
	function read_data($query){

		$transaksi = [];
		global $conn;
		$result = mysqli_query($conn, $query);
		while ($data = mysqli_fetch_assoc($result)){
			$transaksi[] = $data;
		}
		return $transaksi;
	}

	function read(){

		$kafe = read_data(
			"SELECT * FROM kafe"
        );

		return $kafe;
	}

    function create($data){
        global $conn;

        $namaKafe = $_POST['nama'];
        $jarak = $_POST['jarak'];
        $harga = $_POST['harga'];
        $fasilitas = $_POST['fasilitas'];
        $keindahan  = $_POST['keindahan'];
        $segiRasa  = $_POST['segiRasa'];
        $hasBuku = isset($_POST['hasBuku']) ? 1 : 0;
        $hasWifi = isset($_POST['hasWifi']) ? 1 : 0;
        $hasPermainan = isset($_POST['hasPermainan']) ? 1 : 0;
        
        $query = "INSERT INTO kafe VALUES (
            null,
            '$namaKafe', 
            '$jarak', 
            '$harga', 
            '$fasilitas', 
            '$keindahan', 
            '$segiRasa', 
            '$hasWifi', 
            '$hasPermainan',
            '$hasBuku'
        )";
        mysqli_query($conn, $query);
		return mysqli_affected_rows($conn);
    }

    function delete_kafe($id){
        global $conn;
		$query = "DELETE FROM kafe WHERE id='$id'";
		mysqli_query($conn, $query);
		return mysqli_affected_rows($conn);
    }

?>