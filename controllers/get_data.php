<?php session_start();

function select_all_teachers($db, $id = 0)
{
    $query = "SELECT id_teacher, first_name, last_name FROM teachers";
    $dataSQL = $db->query($query);
    $data = $dataSQL->fetch_all(MYSQLI_ASSOC);
    $res = "";

    if ($id == 0 or $id == null) {

        $res .= '<select id="id_teacher" class="form-select" name="id_teacher" value="0"><option selected>Selecciona maestro</option>';
    } else {
        $res .= '<select id="id_teacher" class="form-select" name="id_teacher" value="0" ><option>Selecciona maestro</option>';
    }
    foreach ($data as $teacher) {

        $res .= '<option value="' . $teacher["id_teacher"] . '"';
        if ($teacher["id_teacher"] == $id) {
            $res .= "selected";
        }
        $res .= '>' . $teacher["first_name"] . ' ' . $teacher["last_name"] . '</option>';
    }
    if ($id != 0) {
        $res .= '<option value="0" >Quitar Maestro</option>';
    }

    $res .= '</select>';
    return $res;
}

function clases($id, $db)
{
    if ($id != "0") {
        $query = "SELECT * FROM classes WHERE id_class = '$id'";
        $dataSQL = $db->query($query);
        $data = $dataSQL->fetch_array(MYSQLI_ASSOC);
?>
<div class="mb-3">
    <label for="name_class" class="form-label">Nombre de la Materia</label>
    <input type="text" class="form-control" id="name_class" value="<?= $data["name_class"] ?>">
</div>
<div class="mb-3">
    <?= select_all_teachers($db, $data["id_teacher_fk"]) ?>
</div>

<?php
    } else { ?>

<div class="mb-3">
    <label for="name_class" class="form-label">Nombre de la Materia</label>
    <input type="text" class="form-control" id="name_class" placeholder="Ingresa la materia" required>
</div>
<div class="mb-3">
    <?= select_all_teachers($db) ?>
</div>

<?php

    }
}

function get_alumno($id, $db)
{

    $query = "SELECT s.* , u.email FROM students as s LEFT JOIN users AS u ON s.id_user_fk = id_user WHERE id_student = '$id'";
    $dataSQL = $db->query($query);
    $data = $dataSQL->fetch_array(MYSQLI_ASSOC);
    return $data;
}
///Fin de las funciones
if (isset($_SESSION["rol"]) and $_SESSION["rol"] == 1) {
    include "./dbconn.php";
    $table = $_GET["tabla"];
    $id = $_GET["id"];
    switch ($table) {
        case "maestros":
            $query = "SELECT * FROM teachers WHERE id_teacher = '$id'";
            break;
        case "alumnos":
            $ans = get_alumno($id, $db);
            break;
        case "usuarios":
            $query = "SELECT * FROM users WHERE id_user = '$id'";
            break;
        case "clases":
            $ans = clases($id, $db);
            break;
        case "calif":
            $query = "SELECT * FROM grades WHERE id_grade = '$id'";
            break;
        case "notas":
            $query = "SELECT * FROM notes WHERE id_note = '$id'";
            break;
        case "roles":
            $query = "SELECT * FROM roles WHERE id_rol = '$id'";
            break;
        default:
            $ans["status"] = "error";
            $ans["answer"] = "No existe $table en esta WEB";
            break;
    }
} else {
    $ans["status"] = "error";
    $ans["answer"] = "No tienes permiso";
}

echo json_encode($ans);