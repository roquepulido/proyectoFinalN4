<?php session_start();

function update_alumno($data, $db)
{
    $query = "UPDATE  students SET DNI = '{$data["dni"]}', first_name='{$data["first_name"]}',last_name='{$data["last_name"]}', address = '{$data["address"]}', birth_date = '{$data["birth_date"]}' WHERE id_student = {$data["id_student"]}";
    if ($db->query($query)) {
        return true;
    } else {
        return false;
    }
}

function update_clase($data, $db)
{
    if ($data["id_teacher"] == "0") {

        $query = "UPDATE classes SET  name_class = '{$data["name_class"]}', id_teacher_fk = NULL WHERE id_class = '{$data["id_class"]}';";
    } else {
        $query = "UPDATE classes SET  name_class = '{$data["name_class"]}', id_teacher_fk = {$data["id_teacher"]} WHERE id_class = '{$data["id_class"]}';";
    }
    if ($db->query($query)) {
        return true;
    } else {
        return false;
    }
}

function update_maestro($data, $db)
{
    if ($data["id_class"] != "0") {
        $query = "UPDATE classes SET id_teacher_fk = '{$data["id_teacher"]}' WHERE id_class = '{$data["id_class"]}'";
    } else {

        $query = "UPDATE classes SET id_teacher_fk = NULL WHERE id_teacher_fk = '{$data["id_teacher"]}'";
    }
    if (!$db->query($query)) {
        return false;
    }

    $query = "UPDATE  teachers SET  first_name='{$data["first_name"]}',last_name='{$data["last_name"]}', address = '{$data["address"]}', birth_date = '{$data["birth_date"]}' WHERE id_teacher = {$data["id_teacher"]}";

    if ($db->query($query)) {
        return true;
    } else {
        return false;
    }
}
function update_usuario($data, $db)
{
    isset($data["active"]) ? $active = 1 : $active = 0;
    $query = "UPDATE users SET email='{$data["email"]}',active='{$active}',id_rol_fk='{$data["id_rol"]}' WHERE id_user ='{$data["id_user"]}'";
    if ($db->query($query)) {
        return true;
    } else {
        return false;
    }
}
// Fin de funciones --------
if (isset($_SESSION["rol"]) and $_SESSION["rol"] == 1) {
    include "./dbconn.php";
    $data = json_decode(file_get_contents('php://input'), true);
    $table = $data["tabla"];
    switch ($table) {
        case "maestros":
            $res = update_maestro($data["data"], $db);
            break;
        case "alumnos":
            $res = update_alumno($data["data"], $db);
            break;
        case "usuarios":
            $res = update_usuario($data["data"], $db);
            break;
        case "clases":
            $res = update_clase($data["data"], $db);
            break;
        case "calif":
            $query = "DELETE FROM grades WHERE id_grade = '$id'"; //pendiente
            break;
        case "notas":
            $query = "DELETE FROM notes WHERE id_note = '$id'"; //pendiente
            break;
        case "roles":
            $query = "DELETE FROM roles WHERE id_rol = '$id'"; //pendiente
            break;
        default:
            $ans["status"] = "error";
            $ans["answer"] = "No tienes permiso";
            break;
    }

    if ($res) {
        $ans["status"] = "ok";
        $ans["answer"] = "Se actualizo con exito el registro de la tabla de $table";
    } else {
        $ans["status"] = "error";
        $ans["answer"] = "Fallo en actualizar trata de nuevo";
    }
} else {
    $ans["status"] = "error";
    $ans["answer"] = "No tienes permiso";
}

echo json_encode($ans);