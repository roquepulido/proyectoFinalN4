<?php session_start();

if (!isset($_SESSION["rol"]) or $_SESSION["rol"] != 1) {
    header("Location:./403.php");
}
$titulo = "Maestro";
include "../controllers/dbconn.php";
include "../controllers/functions_db_helpers.php";

$query = "SELECT s.*, u.email, u.id_user,u.active FROM teachers as s LEFT JOIN users AS u ON s.id_user_fk = u.id_user";

$dataSQL =  $db->query($query);
$maestros = $dataSQL->fetch_all(MYSQLI_ASSOC);



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
                                <button id="btnNewModal" type="button" class="btn btn-primary">Agregar
                                    <?= $titulo ?></button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tablaMaster" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Dirección</th>
                                        <th>Fec. de Nacimiento</th>
                                        <th>Clase Asignada</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $x = 1;
                                    foreach ($maestros as $maestro) {
                                        if ($maestro["active"] != 0) {

                                    ?>
                                    <tr>
                                        <td><?= $x ?></td>
                                        <td><?= $maestro["first_name"] . " " . $maestro["last_name"] ?></td>
                                        <td><?= $maestro["email"] ?></td>
                                        <td><?= $maestro["address"] ?></td>
                                        <td><?= $maestro["birth_date"] ?></td>
                                        <td>
                                            <?php
                                                    $class = get_class_by_teacher($maestro["id_teacher"], $db);
                                                    echo $class == NULL ? '<span class="badge badge-warning">Sin Asignación</span>' : $class["name_class"];
                                                    ?></td>
                                        <td class="text-center">
                                            <a href="#" class="text-info mx-2"
                                                onclick="showUpdate(<?= $maestro['id_teacher'] ?>)"><i
                                                    class="bi bi-pencil-square"></i></a>
                                            <?php if ($class == NULL) : ?>
                                            <a href="#" class="text-danger mx-2"
                                                onclick="delReg(<?= $maestro['id_user'] ?>)"><i
                                                    class="bi bi-trash3-fill"></i></a>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                    <?php
                                            $x++;
                                        }
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
                    <input type="hidden" name="id_teacher">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electronico</label>
                        <input type="email" class="form-control" name="email" placeholder="Ingresa email" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="first_name" class="form-label">Nombre(s)</label>
                        <input type="text" class="form-control" name="first_name" placeholder="Ingresa nombre(s)"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Apellido(s)</label>
                        <input type="text" class="form-control" name="last_name" placeholder="Ingresa la apellido(s)"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Dirección</label>
                        <input type="text" class="form-control" name="address" placeholder="Ingresa la dirección"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="birth_date" class="form-label">Fecha de nacimiento</label>
                        <input type="date" class="form-control" name="birth_date"
                            placeholder="Ingresa fecha de nacimiento" required>
                    </div>
                    <div class="mb-3">
                        <label for="class" class="form-label">Clase Asignada</label>
                        <select id="selectUpdate" class="form-select" name="id_class">
                            <option value="0">Selecciona Clase</option>
                        </select>
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
<!-- /. Modal -->
<!-- Modal New class -->

<!-- Modal -->
<div class="modal fade" id="modalNew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Agregar <?= $titulo ?></h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="newForm">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electronico</label>
                        <input type="email" class="form-control" name="email" placeholder="Ingresa email" required>
                    </div>
                    <div class="mb-3">
                        <label for="first_name" class="form-label">Nombre(s)</label>
                        <input type="text" class="form-control" name="first_name" placeholder="Ingresa nombre(s)"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Apellido(s)</label>
                        <input type="text" class="form-control" name="last_name" placeholder="Ingresa la apellido(s)"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Dirección</label>
                        <input type="text" class="form-control" name="address" placeholder="Ingresa la dirección"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="birth_date" class="form-label">Fecha de nacimiento</label>
                        <input type="date" class="form-control" name="birth_date"
                            placeholder="Ingresa fecha de nacimiento" required>
                    </div>
                    <div class="mb-3">
                        <label for="class" class="form-label">Clase Asignada</label>
                        <select id="selectNew" class="form-select" name="id_class">
                            <option value=0>Selecciona Clase</option>
                        </select>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="newSubmit">Crear</button>
            </div>
        </div>
    </div>
</div>
<!-- /. Modal New Class -->
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
const btnNewModal = document.getElementById("btnNewModal");
const modalNew = document.getElementById("modalNew");
const modalUpdate = document.getElementById("modalUpdate");
const updateForm = document.getElementById("updateForm");
const newForm = document.getElementById("newForm");
const selectNew = document.getElementById("selectNew");
const selectUpdate = document.getElementById("selectUpdate")

const get_disponible_class = async () => {
    const url = "../controllers/get_select.php?tabla=clases"
    const res = await fetch(url).then(res => res.json());
    return res;
}

$("#tablaMaster").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": true,
    "buttons": ["copy", "excel", "pdf", "colvis"]
}).buttons().container().appendTo('#tablaMaster_wrapper .col-md-6:eq(0)');

//funcion open #newModal
btnNewModal.addEventListener("click", async () => {
    const myModal = new bootstrap.Modal(modalNew, {});
    get_disponible_class().then(res => {
        res.forEach((materia) => {
            const opt = document.createElement('option');
            opt.value = materia.id_class;
            opt.innerHTML = materia.name_class;
            selectNew.appendChild(opt);
        });
        const opt = document.createElement('option');
        opt.value = 0;
        opt.innerHTML = "Sin Asignar";
        selectNew.appendChild(opt);
    });
    myModal.show();

});
//funcion de enviar el formulario de nuevo registro
document.getElementById("newSubmit").addEventListener("click", async () => {
    const url = "../controllers/new_data.php"
    formData = Object.fromEntries(new FormData(newForm).entries())
    data = {
        data: formData,
        tabla: "maestros",

    };
    const options = {
        method: "POST",
        body: JSON.stringify(data)
    };
    const res = await fetch(url, options).then(res => res.json());


    if (res.status === "ok") {
        Swal.fire(
            "Registrado!",
            res.answer + " Guarda la siguente contraseña para acceso " + res.pass,
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
        );
    }
});

async function showUpdate(id) {

    selectUpdate.innerHTML = "";
    const url = "../controllers/get_data.php?id=" + id + "&" + "tabla=maestros";
    const teacherInfo = await fetch(url).then(res => res.json());
    get_disponible_class().then((res) => {
        const optBlank = document.createElement('option');
        optBlank.value = 0;
        optBlank.innerHTML = "Sin Asignar";
        selectUpdate.appendChild(optBlank);
        res.forEach((materia) => {
            const opt = document.createElement('option');
            opt.value = materia.id_class;
            opt.innerHTML = materia.name_class;
            selectUpdate.appendChild(opt);

        });
        if (teacherInfo.id_class != null) {
            const optActual = document.createElement('option');
            optActual.value = teacherInfo.id_class;
            optActual.innerHTML = teacherInfo.name_class;
            optActual.selected = true;
            selectUpdate.appendChild(optActual);
        }


    });
    const myModal = new bootstrap.Modal(modalUpdate, {});
    const form = document.forms.updateForm;
    form.email.value = teacherInfo.email;
    form.first_name.value = teacherInfo.first_name;
    form.last_name.value = teacherInfo.last_name;
    form.birth_date.value = teacherInfo.birth_date;
    form.address.value = teacherInfo.address;
    form.id_user.value = teacherInfo.id_user_fk;
    form.id_teacher.value = teacherInfo.id_teacher;

    myModal.show();
}
//funcion para enviar los datos del update
document.getElementById("updateSubmit").addEventListener("click", async () => {
    const url = "../controllers/update.php"
    formData = Object.fromEntries(new FormData(updateForm).entries())
    data = {
        data: formData,
        tabla: "maestros",
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

function delReg(id) {
    const url = "../controllers/delete.php?id=" + id + "&" + "tabla=alumnos";
    Swal.fire({
        title: "Estas Seguro?",
        text: "No podras recuperarlo una vez hecho...",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, borrar",
    }).then((result) => {
        if (result.isConfirmed) {
            const ans = fetch(url)
                .then((res) => res.json())
                .then((res) => {
                    if (res.status === "ok") {
                        Swal.fire(
                            "Borrado!",
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
        }
    });

}
</script>
<?php
include "./templates/scripts_html_end.php";
?>