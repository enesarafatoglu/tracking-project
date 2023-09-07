<!DOCTYPE html>
<html>
<head>
    <title>İzin Talebi Ekle</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        text-align: center;
    }

    h2 {
        margin-top: 30px;
        color: #007bff;
    }

    form {
        width: 60%;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    label {
        display: inline-block;
        width: 150px;
        text-align: right;
        margin-right: 10px;
    }

    input[type="text"],
    input[type="date"] {
        width: 60%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    input[type="submit"] {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    a {
        display: inline-block;
        margin-top: 10px;
        color: #007bff;
        text-decoration: none;
    }
</style>

</head>
<body>
    <h2>İzin Talebi Ekle</h2>
    
    <form method="post" action="talep_kaydet.php">
        <?php
        session_start();
        $loggedInPersonelID = $_SESSION['loggedInPersonelID']; // Giriş yapmış personel ID'si
        echo "<input type='hidden' name='PersonelID' value='$loggedInPersonelID'>";
        $loggedInMudurlukID = $_SESSION['loggedInMudurlukID'];
        echo "<input type='hidden' name='MudurlukID' value='$loggedInMudurlukID'>";
        ?>
        
        <label for="IzinTuruID">İzin Türü:</label>
        <select name="IzinTuruID" required>
            <option value="1">Raporsuz</option>
            <option value="2">Raporlu</option>
        </select><br>
        
        <label for="IzinBaslangic">İzin Başlangıç Tarihi:</label>
        <input type="date" name="IzinBaslangic" required><br>
        
        <label for="IzinBitis">İzin Bitiş Tarihi:</label>
        <input type="date" name="IzinBitis" required><br>
        
        <input type="hidden" name="Onay" value="0">
        
        <input type="submit" value="Talep Ekle">
    </form>
    
    <a href="ana_sayfa.php">Ana Sayfa</a>
</body>
</html>
