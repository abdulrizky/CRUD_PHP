<?php
$con = new mysqli('localhost','root','','arkademy');

$err = false;
$dataProduk = $con->query("SELECT * FROM produk ");
$no = 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Arkademy CRUD</title>
	<style>
		a{
			text-decoration: none;
			color: #fff
		}
		table{
			width: 100%;
			background-color: #fff;
			border: 1px solid #555;
			border-radius: 5px;
		}
		td{
			border: 1px solid #ddd;
		}
		.form-control{
			margin:1px;
			width:100%;
			padding: 2px;
			line-height: 2;
			border:1px solid #888;
			border-radius: 5px;
		}
		.btn{
			margin: 1px;
			color: #fff;
			font-weight: 400;
			cursor: pointer;
			padding: 3px 10px;
			background-color: #0088ff;
			line-height: 2;
			border:0 ;
			border-radius: 5px;
		}
	</style>
</head>
<body style="background-color: #777">
	<?php if(isset($_POST['docreate'])){ 
		$add = $con->query("INSERT INTO produk VALUES(null,'$_POST[nama]','$_POST[keterangan]','$_POST[harga]','$_POST[jumlah]') ");
		if($add){
			header('Location:/arkademy_php');
		}else{
			exit('Fail to Insert data Produk');
		}
	}elseif(isset($_POST['doedit'])){
		$edit = $con->query("
			UPDATE produk 
			SET nama_produk = '$_POST[nama]', harga = '$_POST[harga]',jumlah = '$_POST[jumlah]',keterangan = '$_POST[keterangan]' 
			WHERE id='$_POST[id]'
			");
		if($edit){
			header('Location:/arkademy_php');
		}
	}elseif(isset($_POST['dodelete'])){ 
		$con->query("DELETE FROM produk where id='$_POST[id]'");
		header('Location:/arkademy_php');
	}elseif(isset($_POST['edit'])){ 
		?>
		<?php 
		$data = $con->query("SELECT * FROM produk where id='$_POST[id]'")->fetch_assoc() ?>
		<a href="" class="btn">Kembali ke Beranda</a>
		<h3>Edit Produk <?= $data['nama_produk'] ?></h3>
		<form action="" method="post" style="width:40%">
			<input class="form-control" type="hidden" name="id" value="<?= $_POST['id'] ?>"><br>
			Nama<input class="form-control" type="text" name="nama" value="<?= $data['nama_produk'] ?>"><br>
			Harga<input class="form-control" type="number" name="harga" value="<?= $data['harga'] ?>"><br>
			Jumlah<input class="form-control" type="number" name="jumlah" value="<?= $data['jumlah'] ?>"><br>
			Keterangan<textarea class="form-control" name="keterangan" ><?= $data['keterangan'] ?></textarea>
			<input class="btn" type="submit" name="doedit" value="Edit">
		</form>
	<?php }else{ ?>
		<div style="display: flex;justify-content: space-around;">
			<div>
				<h3>Kelola Produk</h3>
				<table >
					<thead>
						<tr>
							<td>No</td>
							<td >Nama</td>
							<td width="100">Harga</td>
							<td width="60">Jumlah</td>
							<td >Keterangan</td>
							<td>Action</td>
						</tr>
					</thead>
					<tbody>
						<?php while($v = $dataProduk->fetch_assoc()){ ?>
							<tr>
								<td><?= $no++ ?></td>
								<td><?= $v['nama_produk'] ?></td>
								<td><?= $v['harga'] ?></td>
								<td><?= $v['jumlah'] ?></td>
								<td><?= $v['keterangan'] ?></td>
								<td style="display: flex">
									<form action="" method="post">
										<input class="form-control" type="hidden" name="id" value="<?= $v['id'] ?>">
										<input class="btn" type="submit" name="edit" value="Edit">
									</form>
									<form action="" method="post">
										<input class="form-control" type="hidden" name="id" value="<?= $v['id'] ?>">
										<input class="btn" type="submit" name="dodelete" value="Hapus" onclick="if(!confirm('Yakin Akan Menghapus?')){return false}">
									</form>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div style="width: 20%">
				<h3>Tambah Produk</h3>
				<form action="" method="post">
					Nama<input class="form-control tambah_nama" type="text" name="nama" placeholder="Masukkan nama">
					Harga<input class="form-control tambah_harga" type="number" name="harga" placeholder="Masukkan harga">
					Jumlah<input class="form-control tambah_stok" type="number" name="jumlah" value="0" placeholder="Masukkan jumlah">
					Keterangan<textarea class="form-control" name="keterangan" ></textarea>
					<input class="btn tambah_button" type="submit" name="docreate" value="Tambah">
				</form>
			</div>
		</div>
	<?php } ?>
</body>
</html>