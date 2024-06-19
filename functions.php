<?php
function image_upload($img) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($img["name"]);
    $upload_ok = 1;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($img["tmp_name"]);
    if($check === false) {
        $upload_ok = 0;
    }

    // Check file size
    if ($img["size"] > 500000) { // 500KB
        $upload_ok = 0;
    }

    // Allow certain file formats
    if($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "svg") {
        $upload_ok = 0;
    }

    // Check if $upload_ok is set to 0 by an error
    if ($upload_ok == 0) {
        return false;
    } else {
        if (move_uploaded_file($img["tmp_name"], $target_file)) {
            return basename($img["name"]);
        } else {
            return false;
        }
    }
}
?>

