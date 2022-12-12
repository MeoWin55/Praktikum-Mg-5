<?php include 'koneksi.php'; ?>
<?php
    $query_prodi = "SELECT * FROM prodi";
    $data_prodi = mysqli_query($connection, $query_prodi);

    $query_mahasiswa = "
        SELECT m.*, p.nama as nama_prodi, p.code as code_prodi
        FROM mahasiswa as m
        LEFT JOIN prodi as p on p.id = m.id_prodi";
    $data_mahasiswa = mysqli_query($connection, $query_mahasiswa);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winda Basudara</title>
    <style>
        .table {
            border-collapse: collapse;
        }
        .table, th, td {
            border: 1px solid #999;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>
<body>
    Prodi
    <select name="prodi" id="prodi">
        <option value="">- Pilih Prodi -</option>
        <?php
        while ($row = mysqli_fetch_assoc($data_prodi)) {
            echo '<option value="'. $row['id'] .'">'. $row['nama'] .'</option>';
        }
        ?>
    </select>

    <table id="dataMahasiswa" style="margin-top: 1rem;">
        <thead>
            <tr>
                <th>NO</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Program Studi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($data_mahasiswa)) {
                echo '
                <tr>
                    <td>'. $no .'</td>
                    <td>'. $row['nim'] .'</td>
                    <td>'. $row['nama'] .'</td>
                    <td>'. $row['code_prodi'] .'</td>
                </tr>';
                $no++;
            }
            ?>
        </tbody>
    </table>

    <script>
        $('#prodi').on('change', function() {
            $.ajax({
                type: "GET",
                url: "tampil_data_mahasiswa.php",
                data: {
                    'id_prodi': function () {return $('#prodi').val()}
                },
                success: function(response){
                    $('#dataMahasiswa tbody').html('');
                    no = 1;
                    data = JSON.parse(response);
                    data.forEach(item => {
                        $('#dataMahasiswa tbody').append(
                            `<tr>
                                <td>${no}</td>
                                <td>${item['nim']}</td>
                                <td>${item['nama']}</td>
                                <td>${item['code_prodi']}</td>
                            </tr>`
                        );
                        no++;
                    });
                }
            });
        });
    </script>
</body>
</html>