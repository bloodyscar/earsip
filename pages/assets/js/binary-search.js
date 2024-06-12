$(document).ready(function () {
  // Initialize DataTables
  var table = $("#myTable").DataTable({
    // paging: false,
    searching: false,
    responsive: true,
  });
  var originalData = table.rows().data().toArray();
  var originalTableContent; // Variabel untuk menyimpan isi tabel asli

  // Fungsi pencarian
  window.search = function () {
    var searchValue = $("#searchInput").val().toLowerCase(); // Konversi ke huruf kecil
    if (searchValue !== "") {
      var index = binarySearch(searchValue);
      if (index !== -1) {
        $("#myTable tbody").empty();
        showMatchingRows(searchValue);
      } else {
        // Jika pencarian tidak menghasilkan hasil, kembalikan isi tabel asli
        // $("#myTable tbody").html(originalTableContent);
        resetTable();
      }
    } else {
      table.search("").draw(); // Hapus filter pencarian
      document.getElementById("step").innerHTML = "";
      // $("#myTable tbody").html(originalTableContent); // Kembalikan isi tabel asli
      resetTable();
    }
  };

  // Menyimpan isi tabel asli
  originalTableContent = $("#myTable tbody").html();

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
      var currentValue = rowData[4].toLowerCase(); // Mengambil nilai dari kolom nama (indeks 2) dan mengonversi ke huruf kecil
      var matchingRows = [];
      // table.clear();

      originalData.forEach(function (rowData) {
        var currentValue = rowData[4].toLowerCase();
        if (currentValue.includes(currentValue)) {
          matchingRows.push(rowData);
        }
      });

      addStepText(
        "Iterasi " +
          iteration +
          ": (" +
          low +
          " + " +
          high +
          ") / 2 = " +
          mid +
          ", Nama = " +
          "<b>" +
          currentValue +
          "</b>"
      );

      if (currentValue === value) {
        var endTime = performance.now(); // Waktu akhir proses pencarian
        var timeTaken = endTime - startTime; // Waktu yang dibutuhkan untuk proses pencarian
        addStepText(
          "Nilai <b>" +
            value +
            "</b> ditemukan pada indeks  <b>" +
            mid +
            "</b>, dengan penomoran: <b>" +
            (mid + 1) +
            "</b>"
        );
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

    originalData.forEach(function (rowData) {
      var currentValue = rowData[4].toLowerCase();
      if (currentValue.includes(searchValue)) {
        matchingRows.push(rowData);
      }
    });

    // Tambahkan kembali baris yang sesuai dengan hasil pencarian baru
    matchingRows.forEach(function (rowData) {
      table.row.add(rowData);
    });

    // Terapkan ulang pencarian DataTables
    table.search(searchValue).draw();
  }

  // Fungsi untuk mengembalikan tabel ke data asli
  function resetTable() {
    table.clear();
    originalData.forEach(function (rowData) {
      table.row.add(rowData);
    });
    table.draw();
  }

  // Live search saat input berubah
  $("#searchInput").on("input", function () {
    search();
  });
});
