
<!DOCTYPE html>
<html>
	<head>
		<title>cossinus similarity </title>
	</head>
	<body>
	<h1>IR <br/> </h1>
		<?php 
			include 'koneksi.php';
			if($_POST['upload']){
				$ekstensi_diperbolehkan	= array('txt');
				$nama = $_FILES['file']['name'];
				$x = explode('.', $nama);
				$ekstensi = strtolower(end($x));
				$ukuran	= $_FILES['file']['size'];
				$file_tmp = $_FILES['file']['tmp_name'];	

				if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
					if($ukuran < 1044070){		
						$f = fopen("file/$nama",'r');
						while(!feof($f)){
							$a[] = fgets($f);
						}
						$a = implode(" ", $a);
						//move_uploaded_file($file_tmp, 'file/'.$nama);
						$query = mysqli_query($con,"INSERT INTO upload VALUES(NULL,'$a')");
						if($query){
							echo 'FILE BERHASIL DI UPLOAD';
						}else{
							echo 'GAGAL MENGUPLOAD FILE';
						}
					}else{
						echo 'UKURAN FILE TERLALU BESAR';
					}
				}else{
					echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN';
				}
			}
		?>

		<br/>
		<br/>
		<a href="upload.php"><button>Upload Lagi</button></a>
		<a href="index.php"><button>Preprocess</button></a>
		<br/>
		<br/>

		
	</body>
</html>