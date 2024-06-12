<?php
$koneksi = mysqli_connect("localhost", "root", "", "skripsi");
if (mysqli_connect_error()) {
	echo "Koneksi Ke database Gagal !!!" . mysqli_connect_error();
}
