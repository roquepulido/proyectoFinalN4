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
// Get clases inscritas para el alumno
$query = "SELECT * FROM student_class 
left join classes on id_class_fk = id_class 
where id_student_fk = '{$alumno["id_student"]}'";
$dataSQL =  $db->query($query);
$clases_inscritas = $dataSQL->fetch_all(MYSQLI_ASSOC);

// Get clases disponibles para el alumno
$query = "SELECT id_class, name_class FROM classes 
    LEFT JOIN student_class ON id_class = id_class_fk 
    WHERE id_class NOT IN
    (SELECT id_class FROM student_class
    LEFT JOIN classes ON id_class = id_class_fk
    where id_student_fk = '{$alumno["id_student"]}')";

$dataSQL =  $db->query($query);
$clases_disponibles = $dataSQL->fetch_all(MYSQLI_ASSOC);

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
                    <h1 class="m-0">Esquema de Clases</h1>
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
                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tus Materias Inscritas</h3>
                        </div>

                        <div class="card-body">
                            <?php if (empty($clases_inscritas)) : ?>
                                <h1>No estas registrado en alguna clase.</h1>

                            <?php else : ?>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Materia</th>
                                            <th>Darse de baja</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($clases_inscritas as $index => $clase) :
                                            $query = "SELECT id_grade_fk FROM student_class WHERE id_class_fk = '{$clase['id_class']}' AND id_student_fk = '{$alumno["id_student"]}'";
                                            $sqlData = $db->query($query);
                                            $grade = $sqlData->fetch_assoc();
                                        ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= $clase["name_class"] ?></td>
                                                <td>
                                                    <?php if ($clase['id_class'] != null) : ?>
                                                        <a href="#" class="text-danger mx-2" onclick="delReg(<?= $alumno['id_student'] . ', ' . $clase['id_class'] ?>)">
                                                            <i class="bi bi-journal-x"></i>
                                                        <?php else : ?>
                                                            <span>No puedes dar debaja tienes calificación</span>
                                                        <?php endif ?>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            <?php endif ?>
                        </div>

                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Materias para inscribir</h3>
                        </div>

                        <div class="card-body ">
                            <div class="form-group">
                                <?php if (empty($clases_disponibles)) : ?>
                                    <h4>Ya estas inscrito a todas las clases.</h4>

                                <?php else : ?>
                                    <form id="formInscripcion">
                                        <label>Selecciona la(s) Clase(s) usa la tecla ctrl</label>
                                        <input type="hidden" name="id_student" id="id_student" value="<?= $alumno["id_student"] ?>">
                                        <select multiple="" name="classes" id="classes" class="custom-select" size=<?= sizeof($clases_disponibles) ?> style="overflow:hidden;">
                                            <?php
                                            foreach ($clases_disponibles as $clase_dis) : ?>
                                                <option value="<?= $clase_dis["id_class"] ?>"><?= $clase_dis["name_class"] ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                    </form>
                            </div>
                            <button type="button" class="btn btn-primary float-right" id="btnInscribir">Inscribir</button>
                        <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->
<?php
include "./templates/footer.php";
?>
<!-- DataTables  & Plugins -->
<script src="../assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- custom script -->
<script>
    document.getElementById("btnInscribir").addEventListener("click", async () => {
        const url = "../controllers/new_data.php"
        const classIncribir = $('#classes').val();
        const idStudent = $("#id_student").val();



        data = {
            data: {
                id_classes: classIncribir,
                id_student: idStudent
            },
            tabla: "ins",

        };
        const options = {
            method: "POST",
            body: JSON.stringify(data)
        };
        const res = await fetch(url, options).then(res => res.json());


        if (res.status === "ok") {
            Swal.fire(
                "Registrado!",
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
            );
        }

    });

    function delReg(id_student, id_class) {
        const url = "../controllers/delete.php?id_class=" + id_class + "&" + "tabla=inscripcion&" + "id_student=" +
            id_student;
        Swal.fire({
            title: "Estas Seguro?",
            text: "Tendras que inscribirte de nuevo",
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