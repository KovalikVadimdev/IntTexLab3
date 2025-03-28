<?php
header("Content-Type: application/xml");

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
        WHERE teacher.name = :teacher_name";

    $prepare = $pdo->prepare($sql);
    $teacher_name = $_GET["teacher_name"];
    $prepare->bindParam(':teacher_name', $teacher_name);
    $executed = $prepare->execute();
    $elementDB = $prepare->fetchAll(PDO::FETCH_ASSOC);

    $xml = new SimpleXMLElement('<lessons/>');

    $headers = $xml->addChild('headers');
    $headers->addChild('title', 'Name group');
    $headers->addChild('week_day', 'Day of the week');
    $headers->addChild('lesson_number', 'Number of classes');
    $headers->addChild('auditorium', 'Audience');
    $headers->addChild('disciple', 'Discipline');
    $headers->addChild('type', 'Type of class');
    $headers->addChild('name', 'Name of the teacher');

    foreach ($elementDB as $row) {
        $lesson = $xml->addChild('lesson');
        $lesson->addChild('title', $row['title']);
        $lesson->addChild('week_day', $row['week_day']);
        $lesson->addChild('lesson_number', $row['lesson_number']);
        $lesson->addChild('auditorium', $row['auditorium']);
        $lesson->addChild('disciple', $row['disciple']);
        $lesson->addChild('type', $row['type']);
        $lesson->addChild('name', $row['name']);
    }
    echo $xml->asXML();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}