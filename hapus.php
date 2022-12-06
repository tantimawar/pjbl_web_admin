<?php

include 'function.php';

$id_produk = $_GET["id_produk"];
$query_delete = "DELETE FROM tb_produk WHERE id_produk='$id_produk';";
$hasil = mysqli_query($conn, $query_delete);


if ($hasil) {
    echo "<script>alert('Berhasil Menghapus Barang'); document.location.href = 'barang.php'; </script>";
} else {
}
