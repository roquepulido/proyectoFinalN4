<?php session_start();

function del_user($id, $db)
{
    if ($db->query("UPDATE users SET active = 0 WHERE id_user = '$id'")) {
        return true;
    } else {
        return false;
    }
}
function del_clases($id, $db)
{
    if ($db->query("DELETE FROM classes WHERE id_class = '$id'")) {
        return true;
    } else {
        return false;
    }
}
function del_roles($id, $db)
{
    if ($db->query("DELETE FROM roles WHERE id_rol = '$id'")) {
        return true;
    } else {
        return false;
    }
}
function del_inscripcion($id, $db)
{
    if ($db->query("DELETE FROM student_class WHERE id_student_fk = '{$id["id_student"]}' AND id_class_fk = '{$id["id_class"]}'")) {
        return true;
    } else {
        return false;
    }
}
function read_note($id, $db)
{
    if ($db->query("UPDATE notes SET read_it = 1 WHERE id_note = '{$id["id"]}'")) {
        return true;
    } else {
        return false;
    }
}
if (isset($_SESSION["rol"]) and $_SESSION["rol"] == 1) {
    include "./dbconn.php";
    $table = $_GET["tabla"];
    $id = $_GET["id"];
    switch ($table) {
        case "maestros":
            $res = del_user($id, $db); // Se pone user por que solo se cambia el active a false y ya no se mostrata ni podra acceder
            break;
        case "alumnos":
            $res = del_user($id, $db); // Se pone user por que solo se cambia el active a false y ya no se mostrata ni podra acceder
            break;
        case "usuarios":
            $res = del_user($id, $db);
            break;
        case "clases":
            $res = del_clases($id, $db);
            break;
        case "roles":
            $res = del_roles($id, $db);
            break;
        default:
            $ans["status"] = "error";
            $ans["answer"] = "No tienes permiso";
            break;
    }

    if ($res) {
        $ans["status"] = "ok";
        $ans["answer"] = "Se elimino con exito el registro de la tabla de $table";
    } else {
        $ans["status"] = "error";
        $ans["answer"] = "Fallo en eliminar trata de nuevo";
    }
} else {
    $ans["status"] = "error";
    $ans["answer"] = "No tienes permiso";
}

if (isset($_SESSION["rol"]) and $_SESSION["rol"] == 3) {
    include "./dbconn.php";
    $table = $_GET["tabla"];
    $id = $_GET;
    switch ($table) {
        case "inscripcion":
            $res = del_inscripcion($id, $db);
            break;
        case "notas";
            $res = read_note($id, $db);
        default:
            $ans["status"] = "error";
            $ans["answer"] = "No tienes permiso";
            break;
    }

    if ($res) {
        $ans["status"] = "ok";
        $ans["answer"] = "Se elimino con exito el registro de la tabla de $table";
    } else {
        $ans["status"] = "error";
        $ans["answer"] = "Fallo en eliminar trata de nuevo";
    }
} else {
    $ans["status"] = "error";
    $ans["answer"] = "No tienes permiso";
}

echo json_encode($ans);