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
function add_grade($grade_info, $db)
{
    $query = "SELECT id_grade_fk from student_class 
    where id_student_fk = '{$grade_info["id_student"]}' 
    AND id_class_fk = '{$grade_info["id_class"]}'";
    $sqlData = $db->query($query);
    $id_grade = $sqlData->fetch_assoc();
    $id_grade = $id_grade["id_grade_fk"];
    $grade = (int)$grade_info["grade"];
    if ($id_grade == null) {
        $query = "INSERT INTO grades(value) VALUES ('{$grade}')";
        $db->query($query);
        $id_grade = $db->insert_id;
        $query = "UPDATE student_class SET id_grade_fk ='$grade' 
        WHERE id_student_fk = '{$grade_info["id_student"]}'
        AND id_class_fk = '{$grade_info["id_class"]}'";
    } else {
        $query = "UPDATE grades SET value = '{$grade_info["grade"]}'
        WHERE id_grade ='{$id_grade}'";
    }

    if (!$db->query($query)) {
        $ans["status"] = "error";
        $ans["answer"] = "Fallo en registar mensaje";
        return $ans;
    }
    $ans["status"] = "ok";
    $ans["answer"] = "Calificacion registrada";
    return $ans;
}
function update_profile($data, $db)
{
    if ($data["email"] == "") {
        $ans["status"] = "error";
        $ans["answer"] = "Tienes que ingresar Correo";
        return $ans;
    }
    if ($data["email"] != $data["actual_email"]) {
        $query = "SELECT COUNT(*) FROM users WHERE email = '{$data['email']}'";
        $count = $db->query($query);
        $emailrepetido = $count->fetch_assoc();
        if ($emailrepetido["COUNT(*)"] != 0) {
            $ans["status"] = "error";
            $ans["answer"] = "Correo ya registrado";
            return $ans;
        }
    }
    if (isset($data["id_teacher"])) {
        $id = $data["id_teacher"];
        $table = "teacher";
    } else {
        $id = $data["id_student"];
        $table = "student";
    }

    if ($data["pass"] != "") {
        $hass_pass = password_hash($data["pass"], PASSWORD_DEFAULT);
        $query = "UPDATE users SET email = '{$data["email"]}', pass='$hass_pass' WHERE id_user = '{$data["id_user"]}'";
    } else {
        $query = "UPDATE users SET email = '{$data["email"]}' WHERE id_user = '{$data["id_user"]}'";
    }

    if (!$db->query($query)) {
        $ans["status"] = "error";
        $ans["answer"] = "Errormessage: $db->error";
        return $ans;
    }
    $query = "UPDATE {$table}s 
        SET first_name = '{$data["first_name"]}', last_name = '{$data["last_name"]}', address = '{$data["address"]}', birth_date = '{$data["birth_date"]}'
        WHERE id_{$table} = '$id'";
    if (!$db->query($query)) {
        $ans["status"] = "error";
        $ans["answer"] = "Errormessage: $db->error";
        return $ans;
    }
    return true;
}
// Fin de funciones --------
if (isset($_SESSION["rol"])) {
    include "./dbconn.php";
    $data = json_decode(file_get_contents('php://input'), true);
    $table = $data["tabla"];
    switch ($table) {
        case "maestros":
            $_SESSION["rol"] == 1 ?
                $res = update_maestro($data["data"], $db) :
                $res = false;
            break;
        case "alumnos":
            $_SESSION["rol"] == 1 ?
                $res = update_alumno($data["data"], $db) :
                $res = false;
            break;
        case "usuarios":
            $_SESSION["rol"] == 1 ?
                $res = update_usuario($data["data"], $db) :
                $res = false;
            break;
        case "clases":
            $_SESSION["rol"] == 1 ?
                $res = update_clase($data["data"], $db) :
                $res = false;
            break;
        case "grade":
            $_SESSION["rol"] == 2 ?
                $res = add_grade($data["data"], $db) :
                $res = false;
            break;
        case "profile":
            $res = update_profile($data["data"], $db);
            break;

        default:
            $ans["status"] = "error";
            $ans["answer"] = "No tienes permiso";
            break;
    }

    if (isset($res["status"])) {
        $ans = $res;
    } elseif ($res) {
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