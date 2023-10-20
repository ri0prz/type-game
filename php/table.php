<?php
require 'function.php';

// Retrieve data
$pelanggan = query("SELECT * FROM hasil");
$i = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel</title>
</head>

<body>
    <h1>Hasil Bermain</h1>
    <table border='1' cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>username</th>
            <th>repetion</th>
        </tr>        
        <?php foreach ($pelanggan as $row): ?>
            <tr>
                <td>
                    <?php echo $row['id']; ?>
                </td>
                <td>
                    <?php echo $row['username']; ?>
                </td>
                <td>
                    <?php echo $row['repetion']; ?>
                </td>
            </tr>
            <?php $i++ ?>
        <?php endforeach; ?>
    </table>
</body>

</html>