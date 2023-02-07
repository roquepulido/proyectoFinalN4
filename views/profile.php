<?php session_start();

if (!isset($_SESSION["rol"])) {
    header("Location:./403.php");
}
$user_data = $_SESSION["user"];

include "../controllers/dbconn.php";
if (isset($user_data["id_teacher"])) {
    $tabla = "teachers";
    $id_name = "id_teacher";
    $id = $user_data["id_teacher"];
} else {
    $tabla = "students";
    $id_name = "id_student";
    $id = $user_data["id_student"];
}
$query = "SELECT * FROM users
WHERE id_user = '{$user_data["id_user_fk"]}'";
$dataSQL = $db->query($query);
$user_data_table = $dataSQL->fetch_assoc();

$query = "SELECT * FROM $tabla
WHERE $id_name = '$id'";
$dataSQL = $db->query($query);

$profile_data =  $dataSQL->fetch_assoc();;

include "./templates/header_start.php";
include "./templates/header_links.php";
?>

<!-- DataTables -->
<link rel="stylesheet" href="../assets/plugins/sweetalert2/sweetalert2.min.css">

<?php
include "./templates/header_end.php";
include "./templates/navbar.php";
include "./templates/aside.php";

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="max-height: 80vh;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Editar datos de perfil</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Perfil</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <h3 class="card-title d-flex align-items-center">Información de Usuario</h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form id="updateForm">
                                <input type="hidden" name="id_user" value="<?= $profile_data["id_user_fk"] ?>">
                                <?= $_SESSION["rol"] == 2 ? '<input type="hidden" name="id_teacher" value="' . $profile_data["id_teacher"] . '">' : "" ?>
                                <?php if ($_SESSION["rol"] == 3) : ?>
                                <input type="hidden" name="id_student" value="<?= $profile_data["id_student"] ?>">
                                <div class="mb-3">
                                    <label for="dni" class="form-label">Matricula</label>
                                    <input type="text" class="form-control" name="dni"
                                        placeholder="Ingresa la matricula" disabled value="<?= $profile_data["DNI"] ?>">
                                </div>
                                <?php endif ?>
                                <input type="hidden" name="actual_email" value="<?= $user_data_table["email"] ?>">

                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo Electronico</label>
                                    <input type="email" class="form-control" name="email" placeholder="Ingresa email"
                                        value="<?= $user_data_table["email"] ?>" autocomplete="off">
                                </div>
                                <div class="mb-3">
                                    <label for="pass" class="form-label">Contraseña ingresa para cambiar la
                                        contraseña</label>
                                    <input type="password" class="form-control" name="pass"
                                        placeholder="Para modificar ingresa una nueva contraseña" autocomplete="off"
                                        value="">
                                </div>
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">Nombre(s)</label>
                                    <input type="text" class="form-control" name="first_name"
                                        placeholder="Ingresa nombre(s)" value="<?= $profile_data['first_name'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Apellido(s)</label>
                                    <input type="text" class="form-control" name="last_name"
                                        placeholder="Ingresa la apellido(s)" value="<?= $profile_data['last_name'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Dirección</label>
                                    <input type="text" class="form-control" name="address"
                                        placeholder="Ingresa la dirección" value="<?= $profile_data['address'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="birth_date" class="form-label">Fecha de nacimiento</label>
                                    <input type="date" class="form-control" name="birth_date"
                                        placeholder="Ingresa fecha de nacimiento"
                                        value="<?= $profile_data['birth_date'] ?>">
                                </div>

                            </form>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary " id="updateSubmit">Guardar cambios</button>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <?php
    echo "------profil------------";
    var_dump($profile_data);
    echo "----------------userdatateble";
    var_dump($user_data_table);
    echo "----------------userdata";
    var_dump($user_data) ?>


</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>
<!-- /.control-sidebar -->
<?php
include "./templates/footer.php";
?>
<!-- DataTables  & Plugins -->


<script src="../assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- custom script -->
<script>
document.getElementById("updateSubmit").addEventListener("click", async () => {
    const url = "../controllers/update.php"
    formData = Object.fromEntries(new FormData(document.getElementById("updateForm")).entries());;
    data = {
        data: formData,
        tabla: "profile",
    };
    const options = {
        method: "POST",
        body: JSON.stringify(data)
    };
    if (formData.pass != "") {
        Swal.fire({
            title: 'Ingresa de nuevo la nueva contraseña para cambiar',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'verificar',
            showLoaderOnConfirm: true,
        }).then(async (pass) => {
            if (pass.value != formData.pass) {

                Swal.fire(
                    "Falla!",
                    "Contraseña no concuerda",
                    "error"
                )
            } else {
                const res = await fetch(url, options).then(res => res.json());
                if (res.status === "ok") {
                    Swal.fire(
                        "Actualizado!",
                        res.answer,
                        "success"
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                } else {
                    Swal.fire(
                        "Falla!",
                        res.answer,
                        "error"
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                }

            }
        })
    } else {
        const res = await fetch(url, options).then(res => res.json());
        if (res.status === "ok") {
            Swal.fire(
                "Actualizado!",
                res.answer,
                "success"
            ).then((result) => {
                if (result.isConfirmed) {
                    window.location.reload();
                }
            });
        } else {
            Swal.fire(
                "Falla!",
                res.answer,
                "error"
            ).then((result) => {
                if (result.isConfirmed) {
                    window.location.reload();
                }
            });
        }
    }

});
</script>

<?php

include "./templates/scripts_html_end.php";
?>