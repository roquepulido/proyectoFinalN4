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
function get_clase($id, $db)
{
    $query = "SELECT c.*, t.first_name, t.last_name from classes as c left join teachers as t on c.id_teacher_fk = t.id_teacher where c.id_class = '$id'";
    $dataSQL = $db->query($query);
    $data = $dataSQL->fetch_assoc();
    return $data;
}
function get_user($id, $db)
{

    $query = "SELECT id_user, email, id_rol_fk, active from users where id_user = '$id'";
    $dataSQL = $db->query($query);
    $data = $dataSQL->fetch_assoc();
    return $data;
}
function get_msg($info, $db)
{
    $query = "SELECT * from notes
    left join classes on id_class = id_class_fk 
    where id_class_fk = '{$info["id_class"]}' 
    AND id_student_fk = '{$info["id_student"]}'";
    $dataSQL = $db->query($query);
    $data = $dataSQL->fetch_all(MYSQLI_ASSOC);
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
            $ans = get_user($id, $db);
            break;
        case "clases":
            $ans = get_clase($id, $db);
            break;
        case "calif":
            $query = "";
            break;
        case "notas":
            $query = "";
            break;
        case "roles":
            $query = "";
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


if (isset($_SESSION["rol"]) and ($_SESSION["rol"] == 3 or $_SESSION["rol"] == 2)) {
    include "./dbconn.php";
    $table = $_GET["tabla"];
    $info = $_GET;
    switch ($table) {
        case "msg":
            $ans = get_msg($info, $db);
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