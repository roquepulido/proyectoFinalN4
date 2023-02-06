<?php session_start();

if (!isset($_SESSION["rol"]) or $_SESSION["rol"] != 2) {
    header("Location:./403.php");
}
$teacher = $_SESSION["user"];
/*
/var/www/src/proyectoFinalN4/views/maestro_alumnos.php:37:
array (size=3)
  'rol' => string '2' (length=1)
  'id_user' => string '2' (length=1)
  'user' => 
    array (size=8)
      'id_teacher' => string '8' (length=1)
      'id_user_fk' => string '2' (length=1)
      'first_name' => string 'Maestro' (length=7)
      'last_name' => string 'Maestro' (length=7)
      'address' => string '' (length=0)
      'birth_date' => string ' ' (length=1)
      'name' => string 'Maestro Maestro' (length=15)
      'rol' => string 'Maestro' (length=7)*/

include "../controllers/dbconn.php";

$query = "SELECT * FROM classes where id_teacher_fk = '{$teacher["id_teacher"]}'";

$dataSQL =  $db->query($query);
$clase = $dataSQL->fetch_assoc();
if (!empty($clase)) {
    $name_class = $clase["name_class"];
}
$query = "SELECT * FROM students left join student_class on id_student = id_student_fk where id_class_fk = '{$clase["id_class"]}'";
$dataSQL =  $db->query($query);
$estudiantes = $dataSQL->fetch_assoc();



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
    <?= var_dump($clase);
    var_dump($estudiantes) ?>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <?php if (empty($clase)) : ?>
            <h1>NO TIENES CLASE ASIGNADA</h1>
            <?php else : ?>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Alumnos de la Clase de <?= $name_class ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= $name_class ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <?php endif; ?>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <?php if (!empty($clase)) : ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <h3 class="card-title d-flex align-items-center">Alumnos de clase <?= $name_class ?>
                                </h3>
                            </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <?php if (empty($estudiantes)) : ?>
                            <h1>No tienes alumnos registrados</h1>
                            <?php else : ?>
                            <table id="tablaMaster" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre de alumno</th>
                                        <th>Calificacion</th>
                                        <th>Mensajes</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                            $x = 1;
                                            foreach ($estudiantes as $estudiante) {

                                            ?>
                                    <tr>
                                        <td><?= $x ?></td>
                                        <td><?= $estudiante["first_name"] . " " . $estudiante["last_name"] ?></td>
                                        <td>

                                        </td>
                                        <td>

                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="text-info mx-2"
                                                onclick="changeGrade(<?= $estudiante['id_student'] ?>)"><i
                                                    class="bi bi-clipboard2-plus"></i></a>
                                            <a href="#" class="text-info mx-2"
                                                onclick="addMsg(<?= $estudiante['id_student'] ?>)"><i
                                                    class="bi bi-chat-dots"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                                $x++;
                                            }

                                            ?>
                                </tbody>
                            </table>
                            <?php endif ?>
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
    <?php endif; ?>
</div>
<!-- /.content-wrapper -->

<!-- Modal -->
<div class="modal fade" id="modalUpdate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Editar</h1>
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
</script>

<?php

include "./templates/scripts_html_end.php";
?>