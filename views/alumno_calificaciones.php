<?php session_start();

if (!isset($_SESSION["rol"]) or $_SESSION["rol"] != 3) {
    header("Location:./403.php");
}
$alumno = $_SESSION["user"];

include "../controllers/dbconn.php";
//get classes
$query = "SELECT * FROM student_class 
left join classes on id_class_fk = id_class 
left join grades on id_grade = id_grade_fk 
where id_student_fk = '{$alumno["id_student"]}'";
$dataSQL =  $db->query($query);
$clases = $dataSQL->fetch_all(MYSQLI_ASSOC);

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

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <?php if (!empty($clases)) : ?>
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
                                            <?php
                                                    $query = "SELECT COUNT(*) as c FROM notes
                                                    WHERE id_student_fk = '{$alumno["id_student"]}' 
                                                    AND id_class_fk = '{$clase["id_class"]}'";
                                                    $dataSQL =  $db->query($query);
                                                    $notes = $dataSQL->fetch_assoc();
                                                    $query = "SELECT COUNT(*) as c FROM notes
                                                    WHERE id_student_fk = '{$alumno["id_student"]}' 
                                                    AND id_class_fk = '{$clase["id_class"]}'
                                                    AND read_it = 0";
                                                    $dataSQL =  $db->query($query);
                                                    $new_notes = $dataSQL->fetch_assoc();
                                                    if ($notes["c"] > 0) : ?>
                                            <button class="btn"
                                                onclick="showMGS(<?= $clase['id_class'] ?>,<?= $alumno['id_student'] ?>,'<?= $clase['name_class'] ?>')">
                                                <i style="font-size: 1.5rem;" class="bi bi-chat-square-dots"></i>
                                                <span style="vertical-align:top;"
                                                    class="badge badge-warning"><?= $new_notes["c"] ?></span>
                                            </button>
                                            <?php else : ?>
                                            <span class="badge badge-info">No hay mensajes</span>
                                            <?php endif ?>

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
            <?php endif; ?>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal -->
<div class="modal fade" id="modalMsg">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Mensajes</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div id="modalMsgBody" class="modal-body">
                <h4 class="text-center" id="modalClass"></h4>
                <div class="card">
                    <div class="card-body p-3">
                        <div id="msgContainer">
                        </div>



                    </div>
                    <!-- /.card-body -->
                </div>

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

const msgBox = document.getElementById("msgInfo");

function cheackRead(id) {
    const url = "../controllers/delete.php?id=" + id + "&" + "tabla=notas";
    fetch(url)
        .then((res) => res.json())
        .then((res) => {
            if (res.status === "ok") {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: "Borrado! " + res.answer,
                    showConfirmButton: false,
                    timer: 1500
                }).then(window.location.reload());
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
async function showMGS(idClass, idStudent, nameClass) {
    document.getElementById("msgContainer").innerHTML = "";

    const url = "../controllers/get_data.php?id_student=" + idStudent + "&" + "tabla=msg" + "&id_class=" + idClass;
    const msgInfo = await fetch(url).then(res => res.json());

    document.getElementById("modalClass").innerText = nameClass;

    msgInfo.forEach((msg, i) => {
        const msgText = document.createElement('div');
        msgText.innerHTML = `<div $id="msg${i}" class="card card-outline card-primary">
        <div class="card-header d-flex align-items-center justify-content-between">
        <h3 class="card-title">Mensaje ${i+1} </h3>
        ${msg.read_it == 0? `<button type="button" class="btn btn-outline-info btn-sm" onclick="cheackRead(${msg.id_note})">Marcar como leido</button>`:""}
        <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
        <i class="fas fa-minus"></i>
        </button>
        </div>
        </div>
        <div class="card-body" style="display: block;">
        ${msg.text}        
        </div>        
        </div>`;
        document.getElementById("msgContainer").appendChild(msgText);
    });

    const myModal = new bootstrap.Modal(document.getElementById("modalMsg"), {});

    myModal.show();

}
</script>

<?php

include "./templates/scripts_html_end.php";
?>