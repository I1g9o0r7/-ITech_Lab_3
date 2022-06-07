<?php
    include('connect.php');

    if(isset($_REQUEST["grClSch"]))
    {
        $grou = $_REQUEST["grClSch"];
        
        //echo "Group number: ".$grou;
        
        try{
            $sql = 'SELECT lesson.week_day, lesson.lesson_number, lesson.auditorium, lesson.disciple, teacher.name, lesson.type, groups.title FROM lesson 
            JOIN lesson_groups ON lesson.ID_Lesson = lesson_groups.FID_Lesson2
            JOIN groups ON lesson_groups.FID_Groups = groups.ID_Groups 
            JOIN lesson_teacher ON lesson.ID_Lesson = lesson_teacher.FID_Lesson1
            JOIN teacher ON lesson_teacher.FID_Teacher = teacher.ID_Teacher
            WHERE groups.title = :grou';
            $sth = $dbh->prepare($sql);
            $sth->execute(array(':grou' => $grou));

            $timetable = $sth->fetchALL(PDO::FETCH_NUM);
            foreach($timetable as $row){
                $weekDay = $row[0];
                    $lessonNum = $row[1];
                    $auditorium = $row[2];
                    $discip = $row[3];
                    $teachernamer = $row[4];
                    $typer = $row[5];
                    $grop = $row[6];



                    print "<tr> <td>$weekDay</td> <td>$lessonNum</td> <td>$auditorium</td> <td>$discip</td> <td>$teachernamer</td><td>$typer</td><td>$grop</td></tr>";
            }
        }
        catch(PDOException $ex){
            echo $ex->GetMessage();
        }
    }
?>