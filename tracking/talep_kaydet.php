<?php
session_start();

$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "takip";

$conn = mysqli_connect($host, $db_user, $db_pass, $db_name);

if (mysqli_connect_errno()) {
    die("Veritabanı bağlantı hatası: " . mysqli_connect_error());
}

$personelID = $_POST['PersonelID'];
$mudurlukID = $_POST['MudurlukID'];
$izinTuruID = $_POST['IzinTuruID'];
$izinBaslangic = $_POST['IzinBaslangic']; // Tarih formatını doğrudan al
$izinBitis = $_POST['IzinBitis']; // Tarih formatını doğrudan al

$izinHakkiQuery = "SELECT izinHakki FROM personel WHERE personelID = '$personelID'";
$izinHakkiResult = mysqli_query($conn, $izinHakkiQuery);
$row = mysqli_fetch_assoc($izinHakkiResult);
$izinHakki = $row['izinHakki'];

$izinSuresi = (strtotime($izinBitis) - strtotime($izinBaslangic)) / (60 * 60 * 24);

$onay = "beklemede";

if ($izinSuresi > $izinHakki) {
    echo "Hata: İzin hakkınızdan fazla izin talep ettiniz.";
} else {
    $sql = "INSERT INTO izintalep (PersonelID, MudurlukID, IzinTuruID, IzinBaslangic, IzinBitis, Onay)
            VALUES ('$personelID', '$mudurlukID', '$izinTuruID', '$izinBaslangic', '$izinBitis', '$onay')";

    if (mysqli_query($conn, $sql)) {
        echo "İzin talebi başarıyla eklendi.";
    } else {
        echo "Hata: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
<a href="ana_sayfa.php" style="font-family:Arial, sans-serif; background-color:#f2f2f2; text-align:center; display:inline-block; margin: 20px 10px;">Ana Sayfa</a>
