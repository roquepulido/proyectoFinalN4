<?php session_start();

function get_disponible_class($db)
{
    $query = "SELECT * FROM classes where id_teacher_fk IS NULL";
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