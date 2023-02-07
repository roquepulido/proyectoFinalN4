<?php session_start();

if (!isset($_SESSION["rol"]) or $_SESSION["rol"] != 2) {
    header("Location:./403.php");
}
$teacher = $_SESSION["user"];

function get_grade_alumno($estudiante, $clase, $db)
{
    $query = "SELECT value from students 
    left join student_class on id_student = id_student_fk
    left join grades on id_grade = id_grade_fk
    where id_student = '$estudiante' and id_class_fk = '$clase'";
    $dataSQL =  $db->query($query);
    $grade = $dataSQL->fetch_assoc();
    return $grade["value"];
}
function get_msg_count_alumno($estudiante, $clase, $db)
{
    $query = "SELECT count(*) as c from notes
    where id_student_fk = '$estudiante' and id_class_fk = '$clase'";
    $dataSQL =  $db->query($query);
    $count = $dataSQL->fetch_assoc();
    return $count["c"];
}
function get_msg_new_count_alumno($estudiante, $clase, $db)
{
    $query = "SELECT count(*) as c from notes
    where id_student_fk = '$estudiante' and id_class_fk = '$clase'
    and read_it = 0";
    $dataSQL =  $db->query($query);
    $count = $dataSQL->fetch_assoc();
    return $count["c"];
}

include "../controllers/dbconn.php";

$query = "SELECT * FROM classes where id_teacher_fk = '{$teacher["id_teacher"]}'";

$dataSQL =  $db->query($query);
$clase = $dataSQL->fetch_assoc();
if (!empty($clase)) {
    $name_class = $clase["name_class"];
    $query = "SELECT * FROM students left join student_class on id_student = id_student_fk where id_class_fk = '{$clase["id_class"]}'";
    $dataSQL =  $db->query($query);
    $estudiantes = $dataSQL->fetch_all(MYSQLI_ASSOC);
}



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
                                            foreach ($estudiantes as $estudiante) :

                                            ?>
                                    <tr>
                                        <td><?= $x ?></td>
                                        <td><?= $estudiante["first_name"] . " " . $estudiante["last_name"] ?></td>
                                        <td>
                                            <?php
                                                        $calificaciones = get_grade_alumno($estudiante["id_student"], $clase["id_class"], $db);
                                                        echo $calificaciones;
                                                        ?>

                                        </td>
                                        <td>
                                            <?php
                                                        $count = get_msg_count_alumno($estudiante["id_student"], $clase["id_class"], $db);
                                                        $new_msg = get_msg_new_count_alumno($estudiante["id_student"], $clase["id_class"], $db);
                                                        if ($count > 0) : ?>

                                            <button class="btn"
                                                onclick="showMGS(<?= $clase['id_class'] ?>,<?= $estudiante['id_student'] ?>,'<?= $clase['name_class'] ?>','<?= $estudiante['first_name'] . ' ' . $estudiante['last_name'] ?>')">
                                                <i class="bi bi-chat-square-dots h4"></i>
                                                <span style="vertical-align:top;"
                                                    class="badge badge-warning"><?= $new_msg ?></span>
                                            </button>
                                            <?php else : ?>
                                            <span class="badge badge-info">No hay mensajes</span>
                                            <?php endif ?>


                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="mx-2"
                                                onclick="changeGrade(<?= $estudiante['id_student'] ?>)"><i
                                                    class="bi bi-clipboard2-plus h4"></i></a>
                                            <a href="#" class="mx-2"
                                                onclick="addMsg(<?= $estudiante['id_student'] ?>)"><i
                                                    class="bi bi-send-plus h4"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                                $x++;
                                            endforeach;

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
<?php if (!empty($clase)) : ?>
$("#tablaMaster").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": true,
    "buttons": ["copy", "excel", "pdf", "colvis"]
}).buttons().container().appendTo('#tablaMaster_wrapper .col-md-6:eq(0)');
const msgBox = document.getElementById("msgInfo");


async function showMGS(idClass, idStudent, nameClass, nameStudent) {
    document.getElementById("msgContainer").innerHTML = "";

    const url = "../controllers/get_data.php?id_student=" + idStudent + "&" + "tabla=msg" + "&id_class=" + idClass;
    const msgInfo = await fetch(url).then(res => res.json());

    document.getElementById("modalClass").innerText = nameClass + "  -  " + nameStudent;
    msgInfo.forEach((msg, i) => {
        const msgText = document.createElement('div');
        msgText.innerHTML = `<div $id="msg${i}" class="card card-outline card-primary">
        <div class="card-header d-flex align-items-center justify-content-between">
        <h3 class="card-title">Mensaje ${i+1} </h3>
        ${msg.read_it == 1? `<span class="badge badge-secondary">Mensaje leido</span>`:""}
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

function changeGrade(idStudent) {
    const url = "../controllers/update.php";
    Swal.fire({
        title: 'Ingresa Calificacion (0-100)',
        input: 'number',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Enviar',
        showLoaderOnConfirm: true,
        preConfirm: (gradeInput) => {
            data = {
                data: {
                    id_student: idStudent,
                    id_class: <?= $clase["id_class"] ?>,
                    grade: gradeInput,
                },
                tabla: "grade",

            };
            const options = {
                method: "POST",
                body: JSON.stringify(data)
            };

            return fetch(url, options)
                .then(response => {
                    return response.json()
                })
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((res) => {

        if (res.isConfirmed) {
            Swal.fire(
                "Calificacion Enviado!",
                "Se registro la calificacion con exito",
                "success"
            ).then((result) => {
                if (result.isConfirmed) {
                    window.location.reload();
                }
            });
        } else {
            Swal.fire(
                "Falla!",
                res.value.answer,
                "error"
            ).then((result) => {
                if (result.isConfirmed) {
                    window.location.reload();
                }
            });
        }
    })
}

function addMsg(idStudent) {
    const url = "../controllers/new_data.php";
    Swal.fire({
        title: 'Ingresa el mensaje nuevo',
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Enviar',
        showLoaderOnConfirm: true,
        preConfirm: (textoMsg) => {
            data = {
                data: {
                    id_student: idStudent,
                    id_class: <?= $clase["id_class"] ?>,
                    text: textoMsg,
                },
                tabla: "msg",

            };
            const options = {
                method: "POST",
                body: JSON.stringify(data)
            };

            return fetch(url, options)
                .then(response => {
                    return response.json()
                })
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((res) => {

        if (res.isConfirmed) {
            Swal.fire(
                "Mensaje Enviado!",
                "Se registro mesaje con exito",
                "success"
            ).then((result) => {
                if (result.isConfirmed) {
                    window.location.reload();
                }
            });
        } else {
            Swal.fire(
                "Falla!",
                res.value.answer,
                "error"
            ).then((result) => {
                if (result.isConfirmed) {
                    window.location.reload();
                }
            });
        }
    })
}
<?php endif ?>
</script>

<?php

include "./templates/scripts_html_end.php";
?>