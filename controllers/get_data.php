<?php session_start();

function get_alumno($id, $db)
{
    $query = "SELECT s.* , u.email FROM students as s LEFT JOIN users AS u ON s.id_user_fk = id_user WHERE id_student = '$id'";
    $dataSQL = $db->query($query);
    $data = $dataSQL->fetch_array(MYSQLI_ASSOC);
    return $data;
}
function get_maestro($id, $db)
{
    $query = "SELECT t.* , u.email, c.* FROM teachers as t LEFT JOIN users AS u ON t.id_user_fk = u.id_user LEFT JOIN classes AS c ON t.id_teacher = c.id_teacher_fk WHERE id_teacher = '$id'";
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
            $ans = get_maestro($id, $db);
            break;
        case "alumnos":
            $ans = get_alumno($id, $db);
            break;
        case "usuarios":
            $query = "SELECT * FROM users WHERE id_user = '$id'";
            break;
        case "clases":

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