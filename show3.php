<?php
    header('Content-Type: application/json');
    header("Cache-Control: no-cache, must-revalidate");

    include('connect.php');

    if(isset($_REQUEST["audClSch"])){
        $auditr = $_REQUEST["audClSch"];
        try{
            $sql = 'SELECT lesson.week_day, lesson.lesson_number, lesson.auditorium, lesson.disciple, teacher.name, lesson.type, groups.title FROM lesson 
            JOIN lesson_groups ON lesson.ID_Lesson = lesson_groups.FID_Lesson2
            JOIN groups ON lesson_groups.FID_Groups = groups.ID_Groups 
            JOIN lesson_teacher ON lesson.ID_Lesson = lesson_teacher.FID_Lesson1
            JOIN teacher ON lesson_teacher.FID_Teacher = teacher.ID_Teacher
            WHERE lesson.auditorium = :auditr';
            $sth = $dbh->prepare($sql);
            $sth->execute(array(':auditr' => $auditr));
            //json
            $timetable = $sth->fetchALL(PDO::FETCH_OBJ); 
            echo json_encode($timetable);
        }
        catch(PDOException $ex){
            echo $ex->GetMessage();
        }
    }
?>