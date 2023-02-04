<?php session_start();
/*
'name_class' => string 'Ciencias de la 4234' (length=19)
  'id_teacher' => string '3' (length=1)
  'tabla' => string 'clases' (length=6)
  */

if (isset($_SESSION["rol"]) and $_SESSION["rol"] == 1) {
    include "./dbconn.php";
    $data = json_decode(file_get_contents('php://input'), true);
    $table = $data["tabla"];
    switch ($table) {
        case "maestros":
            $query = "DELETE FROM teachers WHERE id_teacher = '$id'"; //pendiente
            break;
        case "estudiantes":
            $query = "DELETE FROM students WHERE id_student = '$id'"; //pendiente
            break;
        case "usuarios":
            $query = "DELETE FROM users WHERE id_user = '$id'"; //pendiente
            break;
        case "clases":
            $data["id_teacher"] == "Selecciona maestro" ? $id_teacher_fk = 'NULL' : $id_teacher_fk = "'{$data["id_teacher"]}'";
            $query = "INSERT INTO class(name_class, id_teacher_fk) values ('{$data["name_class"]}',{$id_teacher_fk})";
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
    if (isset($query)) {
        $dataSQL = mysqli_query($db, $query) or die(mysqli_error($db));
        if ($dataSQL) {
            $ans["status"] = "ok";
            $ans["answer"] = "Se creao el nuevo registro en la tabla de $table";
        } else {
            $ans["status"] = "error";
            $ans["answer"] = "Fallo en actualizar trata de nuevo";
        }
    }
} else {
    $ans["status"] = "error";
    $ans["answer"] = "No tienes permiso";
}

echo json_encode($ans);