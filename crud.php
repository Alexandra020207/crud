<?php
require("connection.php");
require("functions.php");

if (isset($_POST['addproduct'])) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = mysqli_real_escape_string($con, $value);
    }

    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $img_name = $_FILES['imagen'];

    $uploaded_img_name = image_upload($img_name);

    if ($uploaded_img_name) {
        $query = "INSERT INTO tblproductos (Nombre, Precio, Descripcion, Imagen) VALUES ('$nombre', '$precio', '$descripcion', '$uploaded_img_name')";
        if (mysqli_query($con, $query)) {
            header("Location: index.php?msg=Producto agregado correctamente");
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
}

if (isset($_POST['updateproduct'])) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = mysqli_real_escape_string($con, $value);
    }

    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $img_name = $_FILES['imagen'];

    $set_clause = "Nombre='$nombre', Precio='$precio', Descripcion='$descripcion'";

    if ($img_name['tmp_name']) {
        $uploaded_img_name = image_upload($img_name);
        if ($uploaded_img_name) {
            $set_clause .= ", Imagen='$uploaded_img_name'";
        }
    }

    $query = "UPDATE tblproductos SET $set_clause WHERE ID='$id'";
    if (mysqli_query($con, $query)) {
        header("Location: index.php?msg=Producto actualizado correctamente");
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($con, $_GET['delete']);
    $query = "DELETE FROM tblproductos WHERE ID='$id'";
    if (mysqli_query($con, $query)) {
        header("Location: index.php?msg=Producto eliminado correctamente");
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

