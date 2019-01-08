<!DOCTYPE html>
<html>
<head>
	<title>Preprocessing</title>
</head>
<body>
	<h1>Upload File</h1>
	<form action="aksi.php" method="post" enctype="multipart/form-data">
		<input type="file" name="file">
		<input type="submit" name="upload" value="Upload">
	</form><br>
	<a href="index.php"><button>Preprocess</button></a>
	<br><br>
	<p>Daftar Dokumen</p>
	<table>
            <?php 
	            include 'koneksi.php';
	            $temp='';
				$data = mysqli_query($con,"select * from upload");
				$i=1;
				while($d = mysqli_fetch_array($data)){				
			?>
			<tr>
				<td>
					<?php
					echo "Doc $i : "; 
					$i+=1;
                    echo($d['isi_file']); ?>
				</td>		
			</tr>
			<?php } ?>
		</table>
</body>
</html>