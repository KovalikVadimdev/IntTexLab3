<?php

$host = "127.0.0.1";
$dbname = "lb_pdo_lessons";
$username = "root";
$password = "password";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $sql = "SELECT DISTINCT group_student.title, lesson.week_day, lesson.lesson_number, lesson.auditorium, lesson.disciple, lesson.type, teacher.name
        FROM group_student 
        INNER JOIN lesson_groups ON group_student.ID_Groups = lesson_groups.FID_Groups 
        INNER JOIN lesson ON lesson_groups.FID_Lesson2 = lesson.ID_Lesson 
        INNER JOIN lesson_teacher ON lesson.ID_Lesson = lesson_teacher.FID_Lesson1 
        INNER JOIN teacher ON lesson_teacher.FID_Teacher = teacher.ID_Teacher 
        WHERE group_student.title = :name_group";

    $prepare = $pdo->prepare($sql);
    $name_group = $_REQUEST["name_group"];
    $prepare->bindParam(':name_group', $name_group);
    $executed = $prepare->execute();
    $elementDB = $prepare->fetchAll(PDO::FETCH_ASSOC);

    $title = [
        "title" => "Name group",
        "week_day" => "Day of the week",
        "lesson_number" => "Number of classes",
        "auditorium" => "Audience",
        "disciple" => "Discipline",
        "type" => "Type of class",
        "name" => "Name of the teacher"
    ];

    array_unshift($elementDB, $title);
    echo json_encode($elementDB);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
