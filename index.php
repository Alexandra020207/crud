<?php
require("connection.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container bg-dark text-light p-3 rounded my-4">
        <div class="d-flex align-items-center justify-content-between px-3">
            <h2>
                <a href="index.php" class="text-white text-decoration-none"><i class="bi bi-person-fill-lock"></i> Administrador</a>
            </h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addproduct">
                <i class="bi bi-plus-circle"></i> Agregar ticket
            </button>
        </div>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div class='container bg-dark text-light p-3 rounded my-4'>
            <div class='d-flex align-items-center justify-content-between px-3' >
                <span><?= htmlspecialchars($_GET['msg']) ?></span>
                <button type='button' class='btn-close btn-close-dark' aria-label='Close' onclick="this.parentElement.parentElement.style.display='none';"></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Mostrar todos los productos -->
    <div class="container">
        <table class="table border border-2 border-primary" style="border-color: #012538;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM tblproductos";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['ID']) ?></td>
                        <td><?= htmlspecialchars($row['Nombre']) ?></td>
                        <td><?= htmlspecialchars($row['Precio']) ?></td>
                        <td><?= htmlspecialchars($row['Descripcion']) ?></td>
                        <td><img src='uploads/<?= htmlspecialchars($row['Imagen']) ?>' width='100'></td>
                        <td>
                            <button class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#editproduct<?= htmlspecialchars($row['ID']) ?>'>Editar</button>
                            <a href='crud.php?delete=<?= htmlspecialchars($row['ID']) ?>' class='btn btn-danger btn-sm'>Eliminar</a>
                        </td>
                    </tr>

                    <!-- Modal para editar el producto -->
                    <div class='modal fade' id='editproduct<?= htmlspecialchars($row['ID']) ?>' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <form action='crud.php' method='POST' enctype='multipart/form-data'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Editar Producto</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <input type='hidden' name='id' value='<?= htmlspecialchars($row['ID']) ?>'>
                                        <div class='mb-3'>
                                            <label for='nombre' class='form-label'>Nombre</label>
                                            <input type='text' class='form-control' id='nombre' name='nombre' value='<?= htmlspecialchars($row['Nombre']) ?>' required>
                                        </div>
                                        <div class='mb-3'>
                                            <label for='precio' class='form-label'>Precio</label>
                                            <input type='number' class='form-control' id='precio' name='precio' value='<?= htmlspecialchars($row['Precio']) ?>' min='1' required>
                                        </div>
                                        <div class='mb-3'>
                                            <label for='descripcion' class='form-label'>Descripción</label>
                                            <textarea class='form-control' id='descripcion' name='descripcion' rows='3' required><?= htmlspecialchars($row['Descripcion']) ?></textarea>
                                        </div>
                                        <div class='mb-3'>
                                            <label for='imagen' class='form-label'>Imagen</label>
                                            <input type='file' class='form-control' id='imagen' name='imagen' accept='.jpg,.png,.svg'>
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                        <button type='submit' class='btn btn-primary' name='updateproduct'>Guardar cambios</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para agregar producto -->
    <div class="modal fade" id="addproduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="crud.php" method="POST" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Agregar Ticket</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" class="form-control" id="precio" name="precio" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept=".jpg,.png,.svg" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" name="addproduct">Agregar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>




