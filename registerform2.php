<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biodata_pelatih";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize inputs
    $nama = htmlspecialchars($_POST['nama']);
    $jantina = htmlspecialchars($_POST['jantina']);
    $kumpulan_etnik = htmlspecialchars($_POST['kumpulan_etnik']);
    $tarikh_lahir = htmlspecialchars($_POST['tarikh_lahir']);
    $no_kp = htmlspecialchars($_POST['no_kp']);
    $tahap_pendidikan = htmlspecialchars($_POST['tahap_pendidikan']);
    $status_pekerjaan = htmlspecialchars($_POST['status_pekerjaan']);
    $no_telefon = htmlspecialchars($_POST['no_telefon']);
    $alamat_rumah = htmlspecialchars($_POST['alamat_rumah']);
    $pusat_pemulihan = htmlspecialchars($_POST['pusat_pemulihan']);
    $jenis_dadah = htmlspecialchars($_POST['jenis_dadah']);
    $rekod_polis = htmlspecialchars($_POST['rekod_polis']);

    // Debugging: print the variables to check values
    echo "Nama: $nama\n";
    echo "Jantina: $jantina\n";
    echo "Kumpulan Etnik: $kumpulan_etnik\n";
    echo "Tarikh Lahir: $tarikh_lahir\n";
    echo "No KP: $no_kp\n";
    echo "Tahap Pendidikan: $tahap_pendidikan\n";
    echo "Status Pekerjaan: $status_pekerjaan\n";
    echo "No Telefon: $no_telefon\n";
    echo "Alamat Rumah: $alamat_rumah\n";
    echo "Pusat Pemulihan: $pusat_pemulihan\n";
    echo "Jenis Dadah: $jenis_dadah\n";
    echo "Rekod Polis: $rekod_polis\n";

    // Prepare and bind for biodata_pelatih
    $stmt = $conn->prepare("INSERT INTO biodata_pelatih (nama, jantina, kumpulan_etnik, tarikh_lahir, no_kp, tahap_pendidikan, status_pekerjaan, no_telefon, alamat_rumah, pusat_pemulihan, jenis_dadah, rekod_polis) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssssssssss", $nama, $jantina, $kumpulan_etnik, $tarikh_lahir, $no_kp, $tahap_pendidikan, $status_pekerjaan, $no_telefon, $alamat_rumah, $pusat_pemulihan, $jenis_dadah, $rekod_polis);

    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    $pelatih_ID = $stmt->insert_id;

    // Close the first statement
    $stmt->close();

    // Retrieve and sanitize health data
    $hospital = htmlspecialchars($_POST['hospital']);
    $rawatan = htmlspecialchars($_POST['rawatan']);
    $penyakit_kronik = htmlspecialchars($_POST['penyakit_kronik']);
    $penyakit_kronik_nyatakan = htmlspecialchars($_POST['penyakit_kronik_nyatakan']);

    // Debugging: print health data
    echo "Hospital: $hospital\n";
    echo "Rawatan: $rawatan\n";
    echo "Penyakit Kronik: $penyakit_kronik\n";
    echo "Penyakit Kronik Nyatakan: $penyakit_kronik_nyatakan\n";

    // Prepare and bind for maklumat_kesihatan
    $stmt = $conn->prepare("INSERT INTO maklumat_kesihatan (pelatih_id, hospital, rawatan, penyakit_kronik, penyakit_kronik_nyatakan) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("issss", $pelatih_ID, $hospital, $rawatan, $penyakit_kronik, $penyakit_kronik_nyatakan);

    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    // Close the statement
    $stmt->close();

    // Close the connection
    $conn->close();

    // Output success message
    echo "Data successfully inserted!";
}
?>
