<!DOCTYPE html>
<html>
<head>
    <title>İzinler Tablosu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            text-align: center;
        }

        a {
            display: inline-block;
            margin: 20px 10px;
            color: #fff;
            background-color: #007bff;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
            width: 100px;
        }

        a:hover {
            background-color: #0056b3;
        }

        h2 {
            margin-top: 30px;
            color: #007bff;
        }

        table {
            width: 80%;
            margin: 30px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ccc;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        /* Optional: Adjust table header width to make it consistent with the content */
        th:nth-child(1),
        td:nth-child(1) {
            width: 10%;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 10%;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 10%;
        }

        th:nth-child(4),
        td:nth-child(4) {
            width: 10%;
        }

        th:nth-child(5),
        td:nth-child(5) {
            width: 25%;
        }

        th:nth-child(6),
        td:nth-child(6) {
            width: 25%;
        }
    </style>
</head>
<body>
    <div style="text-align: center;">
        <h2>İzinler Tablosu</h2>
        <div style="display: inline-block;">
        <?php
        session_start();
            // Veritabanı bağlantı bilgileri
            $host = "localhost"; // Veritabanı sunucu adı veya IP adresi
            $db_user = "root"; // Veritabanı kullanıcı adı
            $db_pass = ""; // Veritabanı şifre
            $db_name = "takip"; // Veritabanı 

            // Veritabanına bağlanma
            $conn = mysqli_connect($host, $db_user, $db_pass, $db_name);

            // Bağlantı hatasını kontrol etme
            if (mysqli_connect_errno()) {
                die("Veritabanı bağlantı hatası: " . mysqli_connect_error());
            }

            // Personel ve izin tablolarındaki verileri almak için sorgu
            $sql = "SELECT * FROM izin WHERE PersonelID= ".$_SESSION['loggedInPersonelID'];

            // Sorguyu çalıştırma
            $result = mysqli_query($conn, $sql);
            
            // Yetki değerini almak için sorgu
            $yetkiSql = "SELECT YetkiID FROM personel WHERE PersonelID = ".$_SESSION['loggedInPersonelID'];
            $yetkiResult = mysqli_query($conn, $yetkiSql);
            $yetkiRow = mysqli_fetch_assoc($yetkiResult);
            $yetki = $yetkiRow['YetkiID'];

            // Verileri işleme
            if (mysqli_num_rows($result) > 0) {
                echo "<table border='1' style='width: 100%; height: 250px; margin-right: 450px'>";
                echo "<tr><th>Personel ID</th><th>İzin ID</th><th>Talep ID</th><th>İzin Türü ID</th><th>İzin Başlangıç Tarihi</th><th>İzin Bitiş Tarihi</th></tr>";
            
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td style='width: 10%;'>" . $row["PersonelID"] . "</td>";
                    echo "<td style='width: 10%;'>" . $row["IzinID"] . "</td>";
                    echo "<td style='width: 10%;'>" . $row["TalepID"] . "</td>";
                    echo "<td style='width: 10%;'>" . $row["IzinTuruID"] . "</td>";
                    echo "<td style='width: 25%;'>" . $row["IzinBaslangic"] . "</td>";
                    echo "<td style='width: 25%;'>" . $row["IzinBitis"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "Eşleşen veri bulunamadı.";
            }
            

// Ana sayfa butonuna tıklanınca yetkiye göre yönlendirme
            if ($yetki == 1) {
            echo "<a href='ana_sayfa.php'>Ana Sayfa</a>";
            } elseif ($yetki == 2) {
            echo "<a href='ana_sayfa2.php'>Ana Sayfa</a>";
            } elseif ($yetki == 3) {
            echo "<a href='ana_sayfa3.php'>Ana Sayfa</a>";
            }

// ...


            // Veritabanı bağlantısını kapatma
            mysqli_close($conn);
            ?>
        </div>
    </div>
    <a href="talep_ekle.php" style="background-color: #5fbf00;"
           onmouseover="this.style.backgroundColor='#007c04';"
           onmouseout="this.style.backgroundColor='#5fbf00';">İzin Talep</a>
    <a href="cikis.php" style="background-color: #ff0000;"
           onmouseover="this.style.backgroundColor='#720000';"
           onmouseout="this.style.backgroundColor='#ff0000';">Çıkış Yap</a>
</body>
</html>
