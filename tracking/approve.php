<?php
$servername = "localhost";
$username = "root"; // Veritabanı kullanıcı adınız
$password = ""; // Veritabanı şifreniz
$dbname = "takip"; // Kullandığınız veritabanının adı

// Veritabanı bağlantısı oluşturma
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol etme
if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

$talepID = $_GET["id"];

// Talebi onaylama ve silme
$sql = "SELECT * FROM izintalep WHERE TalepID = $talepID";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $izinTuruID = $row["IzinturuID"];
    $izinBaslangic = $row["IzinBaslangic"];
    $izinBitis = $row["IzinBitis"];
    $personelID = $row["PersonelID"];


// ... (Önceki kod parçası)

// İzin tablosuna kaydetme
$sql = "INSERT INTO izin (TalepID, PersonelID, IzinTuruID, IzinBaslangic, IzinBitis) VALUES ($talepID, $personelID, $izinTuruID, '$izinBaslangic', '$izinBitis')";
if ($conn->query($sql) === TRUE) {
    // İzin kaydetme başarılı, talebi silme
    $sql = "DELETE FROM izintalep WHERE TalepID = $talepID";
    if ($conn->query($sql) === TRUE) {
        // Talep silindi, izin hakkını güncelle
        $sql = "SELECT DATEDIFF('$izinBitis', '$izinBaslangic') AS IzinSuresi"; // İzin süresini hesapla
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $izinSuresi = $row["IzinSuresi"];

            $sql = "UPDATE personel SET IzinHakki = IzinHakki - $izinSuresi WHERE PersonelID = $personelID";
            if ($conn->query($sql) === TRUE) {
                // İzin hakkı güncellendi
                header("Location: izintalep.php");
            } else {
                echo "Hata: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Hata: İzin süresi hesaplanamadı.";
        }
    } else {
        echo "Hata: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Hata: " . $sql . "<br>" . $conn->error;
}

// ... (Kalan kod ve bağlantı kapatma işlemleri)


} else {
    echo "Talep bulunamadı.";
}

$conn->close();
?>
