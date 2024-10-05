<?php
session_start();
$nama = $email = $komentar = "";
$namaErr = $emailErr = $komentarErr = "";

// Fungsi untuk logout
function logout() {
    session_destroy();
    header("Location: ?page=login");
    exit();
}

// Fungsi untuk memeriksa apakah pengguna sudah login
function is_logged_in() {
    return isset($_SESSION['username']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["nama"])) {
        $namaErr = "Nama wajib diisi";
    } else {
        $nama = test_input($_POST["nama"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $nama)) {
            $namaErr = "Hanya huruf dan spasi yang diperbolehkan";
        }
    }
    
    if (empty($_POST["email"])) {
        $emailErr = "Email wajib diisi";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Format email tidak valid";
        }
    }
    
    if (empty($_POST["komentar"])) {
        $komentarErr = "Komentar wajib diisi";
    } else {
        $komentar = test_input($_POST["komentar"]);
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Buku Tamu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #d1b22c;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            display: flex;
            gap: 20px;
        }

        .form-container, .file-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .form-container {
            flex: 2;
        }

        .file-container {
            flex: 1;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            width: 100%;
            height: 100px;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            resize: vertical; /* Memungkinkan pengguna mengubah ukuran vertikal */
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: #FF0000;
            font-size: 14px;
            margin-top: 5px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-top: 20px;
            border-radius: 4px;
            border: 1px solid #c3e6cb;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Form Buku Tamu</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($nama);?>">
                <span class="error"><?php echo $namaErr;?></span>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email);?>">
                <span class="error"><?php echo $emailErr;?></span>

                <label for="komentar">Komentar:</label>
                <textarea id="komentar" name="komentar"><?php echo htmlspecialchars($komentar);?></textarea>
                <span class="error"><?php echo $komentarErr;?></span>

                <input type="submit" name="submit" value="Kirim">
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($namaErr) && empty($emailErr) && empty($komentarErr)) {
                echo "<div class='success'>";
                echo "<h3>Data yang Anda masukkan:</h3>";
                echo "Nama: " . htmlspecialchars($nama) . "<br>";
                echo "Email: " . htmlspecialchars($email) . "<br>";
                echo "Komentar: " . nl2br(htmlspecialchars($komentar));
                echo "</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>