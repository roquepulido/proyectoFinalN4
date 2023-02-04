<?php session_start();
include "./helpers.php";

if (isset($_SESSION["rol"]) and $_SESSION["rol"] == 1) {
    include "./dbconn.php";
    $data = json_decode(file_get_contents('php://input'), true);
    $table = $data["tabla"];
    switch ($table) {
        case "maestros":
            $query = "DELETE FROM teachers WHERE id_teacher = '$id'"; //pendiente
            break;
        case "alumnos":
            $res = new_alumno($data, $db);
            break;
        case "usuarios":
            $query = "DELETE FROM users WHERE id_user = '$id'"; //pendiente
            break;
        case "clases":
            $res = new_class($data, $db);
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
} else {
    $res["status"] = "error";
    $res["answer"] = "No tienes permiso";
}

echo json_encode($res);


function new_class($data, $db)
{
    $data["id_teacher"] == "Selecciona maestro" ? $id_teacher_fk = 'NULL' : $id_teacher_fk = "'{$data["id_teacher"]}'";
    $query = "INSERT INTO class(name_class, id_teacher_fk) values ('{$data["name_class"]}',{$id_teacher_fk})";
    $db->query($query);
    $id_class = $db->insert_id;

    if ($id_class != 0) {
        $ans["status"] = "ok";
        $ans["answer"] = "registro creado";
    } else {
        $ans["status"] = "error";
        $ans["answer"] = "Fallo en crear trata de nuevo";
    }
    return $ans;
}


function new_alumno($data, $db)
{
    $alumno = $data["data"];
    $pass = random_str(8);
    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
    $rol = 3;
    $query = "INSERT INTO users(email,pass,pass_org,id_rol_fk) VALUES ('{$alumno["email"]}','{$pass_hash}','{$pass}','{$rol}')";

    $db->query($query);
    $id_user = $db->insert_id;
    $query = "INSERT INTO students(id_user_fk, DNI,first_name,last_name,address, birth_date) VALUES ($id_user,'{$alumno["dni"]}','{$alumno["first_name"]}','{$alumno["last_name"]}','{$alumno["address"]}','{$alumno["birth_date"]}')";
    $db->query($query);
    $id_student = $db->insert_id;
    if ($id_student != 0) {
        $ans["status"] = "ok";
        $ans["answer"] = "registro creado";
        $ans["answer"]["pass"] = $pass;
    } else {
        $ans["status"] = "error";
        $ans["answer"] = "Fallo en crear trata de nuevo";
    }
    return $ans;
}