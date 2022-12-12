<?php include 'koneksi.php'; ?>
<?php
    $query_filter = "";
    if (isset($_GET['id_prodi']) && $_GET['id_prodi'] != '') {
        $query_filter .= "AND id_prodi = ". $_GET['id_prodi'];
    }
    $query_mahasiswa = "
        SELECT m.*, p.nama as nama_prodi, p.code as code_prodi
        FROM mahasiswa as m
        LEFT JOIN prodi as p on p.id = m.id_prodi
        WHERE 1 " . $query_filter;

    $data_mahasiswa = mysqli_query($connection, $query_mahasiswa);
    $result = [];
    while ($row = mysqli_fetch_assoc($data_mahasiswa)) {
        array_push($result, $row);
    }
    echo json_encode($result);
?>