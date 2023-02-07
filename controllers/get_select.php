<?php session_start();

function get_disponible_class($db)
{
    $query = "SELECT * FROM classes where id_teacher_fk IS NULL";
    $data = $db->query($query);
    $ans = $data->fetch_all(MYSQLI_ASSOC);
    return $ans;
}
function get_disponible_maestro($db)
{
    $query = "SELECT teachers.* FROM teachers 
    LEFT JOIN users ON id_user_fk = id_user 
    WHERE active = 1 
    AND id_teacher NOT IN
    (SELECT id_teacher_fk from classes where id_teacher_fk is not null)";

    $data = $db->query($query);
    $ans = $data->fetch_all(MYSQLI_ASSOC);
    return $ans;
}
function get_roles($db)
{
    $query = "SELECT * FROM roles";
    $data = $db->query($query);
    $ans = $data->fetch_all(MYSQLI_ASSOC);
    return $ans;
}
///Fin de las funciones

if (isset($_SESSION["rol"]) and $_SESSION["rol"] == 1) {
    include "./dbconn.php";
    $table = $_GET["tabla"];
    switch ($table) {
        case "maestros":
            $ans = get_disponible_maestro($db);
            break;
        case "alumnos":

            break;
        case "usuarios":

            break;
        case "clases":
            $ans = get_disponible_class($db);
            break;
        case "calif":

            break;
        case "notas":

            break;
        case "roles":
            $ans = get_roles($db);

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