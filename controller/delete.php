<?php 
require "../config.php";
require "cafeController.php";
$id = $_GET["id"];

if(delete_kafe($id) > 0){
	echo "
		<script>
			alert('kafe berhasil dihapus');
			document.location.href='../src/pages/admin-dashboard.php';
		</script>
	";
}else{
	echo "
		<script>
			alert('kafe gagal dihapus, karena sedang dalam perjalan, mohon menunggu!');
			document.location.href='../src/pages/admin-dashboard.ph';
		</script>
	";
}

?>