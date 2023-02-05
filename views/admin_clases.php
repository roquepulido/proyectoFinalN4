<?php session_start();

function count_alumnos_class($id, $db)
{
    $query = "SELECT COUNT(id_class_fk) FROM student_class WHERE id_class_fk = '$id'";
    $dataSQL = $db->query($query);
    $count = $dataSQL->fetch_assoc();
    return $count["COUNT(id_class_fk)"];
}


if (!isset($_SESSION["rol"]) or $_SESSION["rol"] != 1) {
    header("Location:./403.php");
}

include "../controllers/dbconn.php";

$query = "SELECT c.*, t.first_name, t.last_name FROM classes as c LEFT JOIN teachers AS t ON c.id_teacher_fk = t.id_teacher";

$dataSQL = $db->query($query);
$classes = $dataSQL->fetch_all(MYSQLI_ASSOC);



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
                    <h1 class="m-0">Lista de Clases</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Clases</li>
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
                                <h3 class="card-title d-flex align-items-center">Información de Clases</h3>
                                <button id="btnNewClass" type="button" class="btn btn-primary">Agregar Clase</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tablaMaestro" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Clase</th>
                                    <th>Maestro</th>
                                    <th>Alumnos inscritos</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $x = 1;
                                foreach ($classes as $class) {

                                ?>
                                <tr>
                                    <td><?= $x ?></td>
                                    <td><?= $class["name_class"] ?></td>
                                    <td><?= !empty($class["id_teacher_fk"]) ? $class["first_name"] . " " . $class["last_name"] : '<span class="badge badge-warning">Sin asignación</span>' ?>
                                    </td>
                                    <td><?php
                                            $count = count_alumnos_class($class["id_class"], $db);
                                            echo $count == 0 ? '<span class="badge badge-warning">Sin alumnos</span>' : "$count"; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="text-info mx-2"
                                            onclick="update(<?= $class['id_class'] ?>)"><i
                                                class="bi bi-pencil-square"></i></a>

                                        <a href="#" class="text-danger mx-2" onclick='del(<?= $class["id_class"] ?>)'><i
                                                class="bi bi-trash3-fill"></i></a>


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
                <h1 class="modal-title fs-5">Editar Clase</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div id="modalUpdateBody" class="modal-body">

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
<div class="modal fade" id="newClass">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Agregar clase</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div id="modalNewBody" class="modal-body">

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
const modalUpdateBody = document.getElementById("modalUpdateBody");
const modalUpdate = document.getElementById("modalUpdate");
const modalNew = document.getElementById("newClass");
const modalNewBody = document.getElementById("modalNewBody");
const btnNewModal = document.getElementById("btnNewClass");

$("#tablaMaestro").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": true,
    "buttons": ["copy", "excel", "pdf", "colvis"]
}).buttons().container().appendTo('#tablaMaestro_wrapper .col-md-6:eq(0)');

btnNewModal.addEventListener("click", async () => {
    modalNewBody.innerHTML = "";
    modalUpdateBody.innerHTML = "";
    const url = "../controllers/get_modal_data.php?" + "id=0&" + "tabla=clases";
    const res = await fetch(url).then(res => res.text());

    modalNewBody.innerHTML = res;
    const myModalNew = new bootstrap.Modal(modalNew, {});

    document.getElementById("newSubmit").addEventListener("click", async () => {
        const url = "../controllers/new_data.php"
        data = {
            name_class: document.getElementById("name_class").value,
            id_teacher: document.getElementById("id_teacher").value,
            tabla: "clases",

        };
        const options = {
            method: "POST",
            body: JSON.stringify(data)
        };
        const res = await fetch(url, options).then(res => res.json());

        if (res.status === "ok") {
            Swal.fire(
                "Clase creada!",
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

    myModalNew.show();
});

async function update(id) {
    modalNewBody.innerHTML = "";
    modalUpdateBody.innerHTML = "";
    const url = "../controllers/get_modal_data.php?id=" + id + "&" + "tabla=clases";
    const res = await fetch(url).then(res => res.text());

    modalUpdateBody.innerHTML = res;
    const myModal = new bootstrap.Modal(modalUpdate, {});
    document.getElementById("updateSubmit").addEventListener("click", async () => {
        const url = "../controllers/update.php"
        data = {
            id_class: id,
            name_class: document.getElementById("name_class").value,
            id_teacher: document.getElementById("id_teacher").value,
            tabla: "clases",

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



    })
    myModal.show();
}

function del(id) {
    const url = "../controllers/delete.php?id=" + id + "&" + "tabla=clases";
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