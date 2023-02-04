<?php session_start();

if (isset($_SESSION["rol"]) and $_SESSION["rol"] == 1) {
    include "./dbconn.php";
    $table = $_GET["tabla"];
    $id = $_GET["id"];
    switch ($table) {
        case "maestros":
            $query = "DELETE FROM teachers WHERE id_teacher = '$id'";
            break;
        case "estudiantes":
            $query = "DELETE FROM students WHERE id_student = '$id'";
            break;
        case "usuarios":
            $query = "DELETE FROM users WHERE id_user = '$id'";
            break;
        case "clases":
            $query = "DELETE FROM class WHERE id_class = '$id'";
            break;
        case "calif":
            $query = "DELETE FROM grades WHERE id_grade = '$id'";
            break;
        case "notas":
            $query = "DELETE FROM notes WHERE id_note = '$id'";
            break;
        case "roles":
            $query = "DELETE FROM roles WHERE id_rol = '$id'";
            break;
        default:
            $ans["status"] = "error";
            $ans["answer"] = "No tienes permiso";
            break;
    }
    if (isset($query)) {
        $dataSQL = mysqli_query($db, $query) or die(mysqli_error($db));
        if ($dataSQL) {
            $ans["status"] = "ok";
            $ans["answer"] = "Se elimino con exito el registro de la tabla de $table";
        } else {
            $ans["status"] = "error";
            $ans["answer"] = "Fallo en eliminar trata de nuevo";
        }
    }
} else {
    $ans["status"] = "error";
    $ans["answer"] = "No tienes permiso";
}

echo json_encode($ans);