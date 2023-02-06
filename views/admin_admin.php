<?php session_start();

if (!isset($_SESSION["rol"]) or $_SESSION["rol"] != 1) {
    header("Location:./403.php");
}
$titulo = "Permiso";
include "../controllers/dbconn.php";

$query = "SELECT * FROM users";

$dataSQL =  $db->query($query);
$usuarios = $dataSQL->fetch_all(MYSQLI_ASSOC);



include "./templates/header_start.php";
include "./templates/header_links.php";
?>

<!-- DataTables -->
<link rel="stylesheet" href="../assets/plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

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
                    <h1 class="m-0">Lista de <?= $titulo ?>s</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= $titulo ?>s</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <h3 class="card-title d-flex align-items-center">Información de <?= $titulo ?>s</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tablaMaster" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Email / Usuario</th>
                                    <th>Permiso</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $x = 1;
                                foreach ($usuarios as $user) {

                                ?>
                                <tr>
                                    <td><?= $x ?></td>
                                    <td><?= $user["email"] ?></td>
                                    <td>
                                        <?php
                                            switch ($user["id_rol_fk"]) {
                                                case "1":
                                                    echo '<span class="badge badge-warning">Administrador</span>';
                                                    break;
                                                case "2":
                                                    echo '<span class="badge badge-info">Maestro</span>';
                                                    break;
                                                case "3":
                                                    echo '<span class="badge badge-secondary">Alumno</span>';
                                                    break;
                                                    defaul:
                                                    echo '<span class="badge badge-danger">Sin Permiso</span>';
                                            }

                                            ?>
                                    </td>
                                    <td><?= $user["active"] == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>' ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="text-info mx-2"
                                            onclick="showUpdate(<?= $user['id_user'] ?>)"><i
                                                class="bi bi-pencil-square"></i></a>
                                    </td>
                                </tr>
                                <?php
                                    $x++;
                                }
                                ?>
                            </tbody>
                        </table>
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
</div>
<!-- /.content-wrapper -->

<!-- Modal -->
<div class="modal fade" id="modalUpdate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Editar <?= $titulo ?></h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div id="modalUpdateBody" class="modal-body">
                <form id="updateForm">
                    <input type="hidden" name="id_user">
                    <div class="mb-3">
                        <label for="name_class" class="form-label">Email del Usuario</label>
                        <input type="email" class="form-control" id="emailInput" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="rol_id" class="form-label">Rol del usuario</label>
                        <select name="id_rol" class="form-control" id="rolSelect"></select>
                    </div>
                    <div class="mb-3">
                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                            <input type="checkbox" class="custom-control-input" id="customSwitch3" name="active">
                            <label class="custom-control-label" for="customSwitch3">Usuario Activo</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateSubmit">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>

<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
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

<script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../assets/plugins/jszip/jszip.min.js"></script>
<script src="../assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="../assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- custom script -->
<script>
$("#tablaMaster").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": true,
    "buttons": ["copy", "excel", "pdf", "colvis"]
}).buttons().container().appendTo('#tablaMaster_wrapper .col-md-6:eq(0)');
const btnUpdateSubmit = document.getElementById("updateSubmit");
const updateModal = document.getElementById("modalUpdate");
const rolSelect = document.getElementById("rolSelect");


const getRoles = async () => {
    const url = "../controllers/get_select.php?tabla=roles"
    const res = await fetch(url).then(res => res.json());
    return res;
}

async function showUpdate(id) {
    rolSelect.innerHTML = "";
    const url = "../controllers/get_data.php?id=" + id + "&" + "tabla=usuarios";
    const userInfo = await fetch(url).then(res => res.json());
    getRoles().then(res => {
        res.forEach((rol) => {
            const opt = document.createElement('option');
            opt.value = rol.id_rol;
            opt.innerHTML = rol.name_rol;
            userInfo.id_rol_fk == rol.id_rol ? opt.selected = true : opt.selected = false;
            rolSelect.appendChild(opt);
        });
    });

    const form = document.forms.updateForm;
    form.id_user.value = userInfo.id_user;
    form.email.value = userInfo.email;
    userInfo.active == 1 ? form.active.checked = true : form.active.checked = false;
    const myModal = new bootstrap.Modal(modalUpdate, {});
    myModal.show();
}

btnUpdateSubmit.addEventListener("click", async () => {
    const url = "../controllers/update.php"
    formData = Object.fromEntries(new FormData(updateForm).entries())
    data = {
        data: formData,
        tabla: "usuarios",
    };
    const options = {
        method: "POST",
        body: JSON.stringify(data)
    };
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

});
</script>
<?php
include "./templates/scripts_html_end.php";
?>