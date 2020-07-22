<?php
require_once "config.php";
// Downloads files
if (isset($_GET['WORK_ID'])) {
    $id = $_GET['WORK_ID'];

    // fetch file to download from database
    $sql = "SELECT * FROM volunteer_work_assign WHERE WORK_ID=$id";
    $result = mysqli_query($MyConnection, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'Work_Assigned/' . $file['WORK_PDF'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('Work_Assigned/' . $file['WORK_PDF']));
        readfile('Work_Assigned/' . $file['WORK_PDF']);

        // Now update downloads count
//        $newCount = $file['downloads'] + 1;
//        $updateQuery = "UPDATE files SET downloads=$newCount WHERE id=$id";
//        mysqli_query($conn, $updateQuery);
        exit;
    }

}
?>