<?php

$conn = mysqli_connect("localhost", "root", "", "toko_atk");

function query($query)
{
    global $conn;
    $query = "SELECT * FROM tb_produk";
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function tambah($data)
{
    global $conn;
    $nama_produk = htmlspecialchars($data["nama_produk"]);
    $harga = htmlspecialchars($data["harga"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);
    $id_produk = htmlspecialchars($data["id_produk"]);
    $foto_produk = htmlspecialchars($data["foto_produk"]);

    //upload gambar
    $gambar = upload();
    if (!$gambar) {
        return false;
    }


    $query = "INSERT INTO tb_produk VALUES ('$id_produk', '$nama_produk', '$harga', '$foto_produk', '$deskripsi')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload()
{
    $namafile = $_FILES['foto_produk']['name'];
    $ukuranfile = $_FILES['foto_produk']['size'];
    $error = $_FILES['foto_produk']['error'];
    $tmpName = $_FILES['foto_produk']['tmp_name'];

    if ($error === 4) {
        echo "<script>alert('Pilih Gambar Terlebih Dahulu')</script>";
        return false;
    }

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namafile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>alert('Yang Anda Upload Bukan Gambar')</script>";
        return false;
    }

    if ($ukuranfile > 1000000) {
        echo "<script>alert('Yang Anda Upload Bukan Gambar')</script>";
        return false;
    }

    $namafilebaru = uniqid();
    $namafilebaru .= '.';
    $namafilebaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namafilebaru);

    return $namafilebaru;
}

function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM tb_produk WHERE id_produk = '$id'");
    return mysqli_affected_rows($conn);
}

function ubah($data)
{
    global $conn;
    $id = $data["id_produk"];
    $nama_produk = htmlspecialchars($data["nama_produk"]);
    $harga = htmlspecialchars($data["harga"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);
    $gambarlama = htmlspecialchars($data["gambarlama"]);

    if ($_FILES['gambar']['error'] === 4) {
        $foto_produk = $gambarlama;
    } else {
        $gambar = upload();
    }


    $query = "UPDATE tb_produk SET nama_produk = '$nama_produk', harga = '$harga', deskripsi = '$deskripsi', foto_produk = '$foto_produk' WHERE id_produk = '$id' ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function cari($keyword)
{
    $query = "SELECT * FROM tb_produk WHERE nama_produk LIKE '%$keyword%'";
    return query($query);
}

function user($username)
{
    global $conn;
    $query = "SELECT * FROM tb_akun";
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function hapususer($username)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM tb_akun WHERE id = '$username'");
    return mysqli_affected_rows($conn);
}
