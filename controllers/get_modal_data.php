<?php session_start();


if (isset($_SESSION["rol"]) and $_SESSION["rol"] == 1) {
    include "./dbconn.php";
    $table = $_GET["tabla"];
    $id = $_GET["id"];
    switch ($table) {
        case "maestros":
            $query = "SELECT * FROM teachers WHERE id_teacher = '$id'";
            break;
        case "alumnos":
            $ans = alumnos($id, $db);
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
            $ans = "Error,No tienes permiso";
            break;
    }
} else {
    $ans = "Error,No tienes permiso";
}

echo $ans;

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
        $query = "SELECT * FROM class WHERE id_class = '$id'";
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

function alumnos($id, $db)
{
    if ($id != "0") {
        $query = "SELECT * FROM class WHERE id_class = '$id'";
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
    <label for="dni" class="form-label">DNI</label>
    <input type="text" class="form-control" id="dni" name="dni" placeholder="Ingresa la matricula" required>
</div>
<div class="mb-3">
    <label for="email" class="form-label">Correo Electronico</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa email" required>
</div>
<div class="mb-3">
    <label for="first_name" class="form-label">Nombre(s)</label>
    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Ingresa nombre(s)" required>
</div>
<div class="mb-3">
    <label for="last_name" class="form-label">Apellido(s)</label>
    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Ingresa la apellido(s)"
        required>
</div>
<div class="mb-3">
    <label for="address" class="form-label">Dirección</label>
    <input type="text" class="form-control" id="address" name="address" placeholder="Ingresa la dirección" required>
</div>
<div class="mb-3">
    <label for="birth_date" class="form-label">Fecha de nacimiento</label>
    <input type="date" class="form-control" id="birth_date" name="birth_date" placeholder="Ingresa fecha de nacimiento"
        required>
</div>
<?php

    }
}