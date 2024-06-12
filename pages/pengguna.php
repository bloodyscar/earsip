<?php
session_start();
include "../koneksi/koneksi.php";

if (!isset($_SESSION["login"])) {
    header("location: login");
}

$level = $_SESSION['level'];
$id_user = $_SESSION['id_user'];

function fsize($file)
{
    $a = array("B", "KB", "MB", "GB", "TB", "PB");
    $pos = 0;
    $size = filesize($file);
    while ($size >= 1024) {
        $size /= 1024;
        $pos++;
    }
    return round($size, 2) . " " . $a[$pos];
}

if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $id_user = mysqli_real_escape_string($koneksi, $_GET['id_user']);
    $select_user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='$id_user'");
    $hasil_select = mysqli_fetch_array($select_user);
    $nama_user = $hasil_select['username'];
    $hapus = mysqli_query($koneksi, "DELETE FROM user WHERE id_user='$id_user'");
    if (is_dir("file_pribadi/$nama_user")) {
        $files = glob("file_pribadi/$nama_user/*");
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        rmdir("file_pribadi/$nama_user");
    }
    echo "<script>alert('Data pengguna berhasil dihapus!'); window.location='pengguna';</script>";
}

if (isset($_POST['update'])) {
    $id_user = mysqli_real_escape_string($koneksi, $_POST['id_user']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password_baru = !empty($_POST['password_baru']) ? md5($_POST['password_baru']) : null;

    if ($password_baru) {
        $update = mysqli_query($koneksi, "UPDATE user SET username='$username', password='$password_baru' WHERE id_user='$id_user'");
    } else {
        $update = mysqli_query($koneksi, "UPDATE user SET username='$username' WHERE id_user='$id_user'");
    }

    echo "<script>alert('Data pengguna berhasil diupdate!'); window.location='pengguna';</script>";
}

if (isset($_POST['add'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5(mysqli_real_escape_string($koneksi, $_POST['password']));
    $level = mysqli_real_escape_string($koneksi, $_POST['level']);
    $insert = mysqli_query($koneksi, "INSERT INTO user (username, password, level) VALUES ('$username', '$password', '$level')");
    if ($insert) {
        echo "<script>alert('Pengguna berhasil ditambahkan!'); window.location='pengguna';</script>";
    } else {
        echo "<script>alert('Pengguna gagal ditambahkan!'); window.location='pengguna';</script>";
    }
 if (isset($_POST['upload'])) {
        $jenis_document = mysqli_real_escape_string($koneksi, $_POST['jenis_document']);
        if (is_dir("file/$jenis_document")) {
        } else {
            mkdir("file/$jenis_document");
        }
        $input = mysqli_query($koneksi, "INSERT INTO jenis_document VALUES(NULL,'$jenis_document')");
        echo "<script>window.alert('Jenis Document $jenis_document berhasil di Tambahkan !!!')
        window.location='jenis_document'</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Fitrah Hanniah</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/vendors/DataTables/datatables.css">
    <link rel="stylesheet" href="assets/css/mystyle.css">
    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/logo-arsip.jpg" type="image/x-icon">
</head>

<body>
    <div id="app">
        <div id="sidebar" class='active'>
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <img style="width: 55%; height: auto; display: block; margin-left: auto; margin-right: auto;" src="assets/images/smk.jpg">
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class='sidebar-title'>Menu</li>
                        <li class="sidebar-item">
                            <a href="dashboard" class='sidebar-link'>
                                <i data-feather="home" width="20"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item has-sub">
                            <a href="#" class='sidebar-link'>
                                <i data-feather="database" width="20"></i>
                                <span>Master Data</span>
                            </a>
                            <ul class="submenu active">
                                <li><a href="jenis_document">Jenis Document</a></li>
                                <li><a href="pengguna">Data Pengguna</a></li>
                            </ul>
                        </li>
                        <li class="sidebar-item"><a href="document" class='sidebar-link'><i data-feather="briefcase" width="20"></i><span>Document Umum</span></a></li>
                        <li class="sidebar-item"><a href="document_pribadi" class='sidebar-link'><i data-feather="folder" width="20"></i><span>Document Pribadi</span></a></li>
                        <li class="sidebar-item has-sub">
                            <a href="#" class='sidebar-link'><i data-feather="check" width="20"></i><span>Cek Share Document</span></a>
                            <ul class="submenu">
                                <li><a href="document_masuk">Document Masuk</a></li>
                                <li><a href="document_keluar">Document Keluar</a></li>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a href="logout" onclick="return confirm('Ingin Keluar dari Aplikasi?')" class='sidebar-link'><i data-feather="log-out" width="20"></i><span>Keluar</span></a>
                        </li>
                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main">
            <?php require_once "../template/sidebar.php"; ?>

            <div class="main-content container-fluid">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h4>Data Pengguna</h4>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class='breadcrumb-header'>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Data Pengguna</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <?php if ($level == 'Administratif') { ?>
                        <div class="card">
                            <div class="card-header">
                                <a href="" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#primary"><i data-feather="user-plus"></i> Tambah Pengguna</a>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="card">
                        <div class="card-header"></div>
                        <div class="card-body">
                            <div class="box-input">
                                <input type="text" id="searchInput" placeholder="Cari username pengguna..">
                                <br>
                                <p id="step"></p>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table style="color: black; font-size: 10pt;" class="table table-datatable" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Username</th>
                                            <th>Password (Enkripsi)</th>
                                            <th>Level Akses</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $user = mysqli_query($koneksi, "SELECT * FROM user ORDER BY username ASC");
                                        while ($row_user = mysqli_fetch_array($user)) {
                                        ?>
                                            <tr style="color: black;">
                                                <td><?= $no++; ?></td>
                                                <td><?= $row_user['username']; ?></td>
                                                <td><?= $row_user['password']; ?></td>
                                                <td><?= $row_user['level']; ?></td>
                                                <td>
                                                    <a href="" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#edituser<?= $row_user['id_user']; ?>"><i data-feather="edit"></i> Edit</a>
                                                    <a href="pengguna?aksi=hapus&id_user=<?= $row_user['id_user']; ?>" onclick="return confirm('Apakah yakin ingin menghapus data pengguna ini?')" class="btn btn-danger"><i data-feather="trash"></i> Hapus</a>
                                                </td>
                                            </tr>
                                            <div class="modal-primary me-1 mb-1 d-inline-block">
                                                <div class="modal fade text-left" id="edituser<?= $row_user['id_user']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myModalLabel160">Edit Pengguna</h5>
                                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <i data-feather="x"></i>
                                                                </button>
                                                            </div>
                                                            <form action="" method="POST">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="id_user" value="<?= $row_user['id_user']; ?>">
                                                                    <label>Username</label>
                                                                    <div class="form-group">
                                                                        <input type="text" name="username" value="<?= $row_user['username']; ?>" class="form-control" required>
                                                                    </div>
                                                                    <label>Password Baru</label>
                                                                    <div class="form-group">
                                                                        <input type="password" name="password_baru" class="form-control">
                                                                        <small>Kosongkan jika tidak ingin mengubah password</small>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                                        <i data-feather="x"></i>
                                                                        <span>Close</span>
                                                                    </button>
                                                                    <button type="submit" name="update" class="btn btn-primary ml-1">
                                                                        <i data-feather="check"></i>
                                                                        <span>Save</span>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php require_once "../template/footer.php"; ?>
        </div>
    </div>
    <div class="modal-primary me-1 mb-1 d-inline-block">
        <div class="modal fade text-left" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel160">Tambah Pengguna</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form action="" method="POST">
                        <div class="modal-body">
                            <label>Username</label>
                            <div class="form-group">
                                <input type="text" name="username" placeholder="username" class="form-control" required>
                            </div>
                            <label>Password</label>
                            <div class="form-group">
                                <input type="password" name="password" placeholder="password" class="form-control" required>
                            </div>
                            <label>Level Akses</label>
                            <div class="form-group">
                                <select name="level" class="form-control" required>
                                    <option value="">Pilih Level</option>
                                    <option value="Administratif">Administratif</option>
                                    <option value="Guru">Guru</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i data-feather="x"></i>
                                <span>Close</span>
                            </button>
                            <button type="submit" name="add" class="btn btn-primary ml-1">
                                <i data-feather="check"></i>
                                <span>Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/feather-icons/feather.min.js"></script>
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/app.js"></script>

    <script src="assets/vendors/DataTables/datatables.js"></script>
    <script src="assets/js/vendors.js"></script>

    <script src="assets/js/main.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTables
            var table = $("#myTable").DataTable({
                searching: false,
                responsive: true,
            });

            var table2 = $("#myTable2").DataTable({
                searching: false,
                responsive: true,
            });

            // Style tambahan
            $("#myTable2").css("display", "none");
            $("#myTable2_length").css("display", "none");
            $("#myTable2_info").css("display", "none");

            var originalData = table.rows().data().toArray();
            var originalTableContent = table.rows().data().toArray(); // Variabel untuk menyimpan isi tabel asli

            // Fungsi pencarian
            window.search = function() {
                var searchValue = $("#searchInput").val().toLowerCase(); // Konversi ke huruf kecil
                if (searchValue !== "") {
                    var index = binarySearch(searchValue);
                    if (index !== -1) {
                        $("#myTable tbody").empty();
                        showMatchingRows(searchValue);
                    } else {
                        // Jika pencarian tidak menghasilkan hasil, berikan hasil guess pencarian
                        // Style tambahan
                        $("#myTable").css("display", "none");
                        $("#myTable_length").css("display", "none");
                        $("#myTable_info").css("display", "none");
                        $("#myTable").css("display", "none");
                        $("#myTable2").css("display", "block");
                        $("#myTable2").css("display", "block");
                        $("#myTable2_length").css("display", "block");
                        $("#myTable2_info").css("display", "block");
                        // Menampilkan hasil guess
                        showMatchingRows2(searchValue);
                    }
                } else {
                    table.search("").draw(); // Hapus filter pencarian
                    table2.search("").draw(); // Hapus filter pencarian
                    document.getElementById("step").innerHTML = "";
                    resetTable(); // reset table
                }
            };

            function binarySearch(value) {
                var startTime = performance.now(); // Waktu awal proses pencarian
                var low = 0;
                var high = table.rows().count() - 1;
                var iteration = 0; // Inisialisasi hitungan iterasi
                var stepElement = document.getElementById("step"); // Mendapatkan elemen DOM dengan ID "step"

                // Fungsi untuk menambahkan teks ke dalam elemen DOM "step"
                function addStepText(text) {
                    stepElement.innerHTML += "<p>" + text + "</p>"; // Menambahkan teks ke dalam elemen "step"
                }

                // Membersihkan konten sebelumnya dari elemen "step"
                stepElement.innerHTML = "";

                while (low <= high) {
                    iteration++; // Tambah hitungan iterasi
                    var mid = Math.floor((low + high) / 2);
                    var rowData = table.row(mid).data();
                    var currentValue = rowData[1].toLowerCase(); // Mengambil nilai dari kolom nama (indeks 2) dan mengonversi ke huruf kecil
                    var matchingRows = [];
                    // table.clear();

                    originalData.forEach(function(rowData) {
                        var currentValue = rowData[1].toLowerCase();
                        if (currentValue.includes(currentValue)) {
                            matchingRows.push(rowData);
                        }
                    });

                    // addStepText("Iterasi " + iteration + ": (" + low + " + " + high + ") / 2 = " + mid + ", Nama = " + currentValue);

                    if (currentValue === value) {
                        var endTime = performance.now(); // Waktu akhir proses pencarian
                        var timeTaken = endTime - startTime; // Waktu yang dibutuhkan untuk proses pencarian
                        // addStepText("Nilai <b>" + value + "</b> ditemukan pada indeks  <b>" + mid + "</b>, dengan penomoran: <b>" + (mid + 1) + "</b>");
                        addStepText("Durasi Pencarian: " + timeTaken.toFixed(2) + " milidetik");
                        return mid; // Nilai ditemukan
                    } else if (currentValue < value) {
                        low = mid + 1; // Menuju setengah kanan
                    } else {
                        high = mid - 1; // Menuju setengah kiri
                    }
                }

                addStepText("Nilai " + value + " tidak ditemukan");
                return -1; // Nilai tidak ditemukan
            }

            // Fungsi untuk menampilkan baris yang sesuai dengan hasil pencarian
            function showMatchingRows(searchValue) {
                // Simpan baris yang sesuai dengan hasil pencarian
                var matchingRows = [];
                table.clear();

                originalData.forEach(function(rowData) {
                    var currentValue = rowData[1].toLowerCase();
                    if (currentValue.includes(searchValue)) {
                        matchingRows.push(rowData);
                    }
                });

                // Tambahkan kembali baris yang sesuai dengan hasil pencarian baru
                matchingRows.forEach(function(rowData) {
                    table.row.add(rowData);
                });

                // Terapkan ulang pencarian DataTables
                table.search(searchValue).draw();
            }

            function showMatchingRows2(searchValue) {
                // Simpan baris yang sesuai dengan hasil pencarian
                var matchingRows = [];
                table2.clear();

                originalData.forEach(function(rowData) {
                    var currentValue = rowData[1].toLowerCase();
                    if (currentValue.includes(searchValue)) {
                        matchingRows.push(rowData);
                    }
                });

                // Tambahkan kembali baris yang sesuai dengan hasil pencarian baru
                matchingRows.forEach(function(rowData) {
                    table2.row.add(rowData);
                });

                // Terapkan ulang pencarian DataTables
                table2.search(searchValue).draw();
            }

            // Fungsi untuk mengembalikan tabel ke data asli
            function resetTable() {
                table.clear();
                table2.clear();
                originalData.forEach(function(rowData) {
                    table.row.add(rowData);
                    table2.row.add(rowData);
                });
                table.draw();
                table2.draw();
            }

            // Live search saat input berubah
            $("#searchInput").on("input", function() {
                search();
            });
        });
    </script>

</body>

</html>