<?php session_start();

if (!isset($_SESSION["rol"]) or $_SESSION["rol"] != 3) {
    header("Location:./403.php");
}
$alumno = $_SESSION["user"];
/*
'first_name' => string 'nombre' (length=6)
  'last_name' => string 'apellido' (length=8)
  'id_student' => string '11' (length=2)
  'name' => string 'nombre apellido' (length=15)
  'rol' => string 'Alumno' (length=6)*/

include "../controllers/dbconn.php";

$query = "SELECT * FROM student_class 
left join classes on id_class_fk = id_class 
left join grades on id_grade = id_grade_fk 
where id_student_fk = '{$alumno["id_student"]}'";
$dataSQL =  $db->query($query);
$clases = $dataSQL->fetch_all(MYSQLI_ASSOC);

$query = "SELECT * FROM notes
WHERE id_student_fk = '{$alumno["id_student"]}'";
$dataSQL =  $db->query($query);
$notes = $dataSQL->fetch_all(MYSQLI_ASSOC);

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
    <?= var_dump($alumno);
    var_dump($clases) ?>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <?php if (empty($clases)) : ?>
            <h1>NO TIENES CLASES ASIGNADA</h1>
            <p>Puedes inscribirte a alguna en el apartado de inscripiones o en el siguiente <a
                    href="./alumno_inscripciones.php">link</a></p>
            <?php else : ?>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Calificaciones y mensajes de tus clases</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Clases</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <?php endif; ?>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <?php if (!empty($clases)) : ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <h3 class="card-title d-flex align-items-center">Calificaciones y mensajes de tus clases
                                </h3>
                            </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">


                            <table id="tablaMaster" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre de clase</th>
                                        <th>Calificacion</th>
                                        <th>Mensajes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                        $x = 1;
                                        foreach ($clases as $clase) {

                                        ?>
                                    <tr>
                                        <td><?= $x ?></td>
                                        <td><?= $clase["name_class"] ?></td>
                                        <td>
                                            <?= empty($clase["value"]) ? "Sin calificacion" : $clase["value"] ?>

                                        </td>

                                        <td>
                                            <a href="#">
                                                <i class="far fa-bell"></i>
                                                <span
                                                    class="badge badge-info navbar-badge"><?= $clase["get_msg id({$clase["id_student"]},{$clase["id_class_fk"]})"] ?></span>
                                            </a>

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