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
    if ($data["id_teacher"] == "0" or $data["id_teacher"] == "Selecciona maestro") {

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


// Fin de fusiones --------
if (isset($_SESSION["rol"]) and $_SESSION["rol"] == 1) {
    include "./dbconn.php";
    $data = json_decode(file_get_contents('php://input'), true);
    $table = $data["tabla"];
    switch ($table) {
        case "maestros":
            $query = "DELETE FROM teachers WHERE id_teacher = '$id'"; //pendiente
            break;
        case "alumnos":
            $res = update_alumno($data["data"], $db);
            break;
        case "usuarios":
            $query = "DELETE FROM users WHERE id_user = '$id'"; //pendiente
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