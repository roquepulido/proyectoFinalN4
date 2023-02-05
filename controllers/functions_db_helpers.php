<?php

function get_class_by_teacher($id, $db)
{
    $query = "SELECT name_class FROM classes AS c LEFT JOIN teachers as t ON c.id_teacher_fk = t.id_teacher where id_teacher = '$id'";
    $res = $db->query($query);
    return $res->fetch_assoc();
}