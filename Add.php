<?php
    include('connect.php');
    $weekDayA = $_POST['weekDayAdd'];
    $lessonNum = (int) $_POST['lessonNumAdd'];
    $auditorium = $_POST['auditAdd'];
    $discip = $_POST['discAdd'];
    $teacher = $_POST['teachClAdd'];
    $grour = $_POST['grClAdd'];

    $sql = 'SELECT COUNT(ID_Lesson) FROM lesson';
    $sth = $dbh->prepare($sql);
    $sth->execute(array());
    $timetable = $sth->fetchALL(PDO::FETCH_NUM);
    $countLessons = $timetable[0][0] + 1;

    $sql = "INSERT INTO lesson (lesson.ID_Lesson, lesson.week_day, lesson.lesson_number, lesson.auditorium, lesson.disciple, lesson.type) VALUES (:countLessons, :weekDayA, :lessonNum, :auditorium, :discip, 'Practical')";
    $sth = $dbh->prepare($sql);
    $sth->execute(array(':countLessons' => $countLessons, ':weekDayA' => $weekDayA, ':lessonNum' => $lessonNum, ':auditorium' => $auditorium, ':discip' => $discip));
    $timetable = $sth->fetchALL(PDO::FETCH_NUM);

    $sql = 'INSERT INTO lesson_teacher (lesson_teacher.FID_Teacher, lesson_teacher.FID_Lesson1) VALUES ((SELECT teacher.ID_Teacher FROM teacher WHERE teacher.name = :teacher), :countLessons)';
    $sth = $dbh->prepare($sql);
    $sth->execute(array(':countLessons' => $countLessons, ':teacher' => $teacher));
    $timetable = $sth->fetchALL(PDO::FETCH_NUM);

    $sql = 'INSERT INTO lesson_groups (lesson_groups.FID_Lesson2, lesson_groups.FID_Groups) VALUES (:countLessons, (SELECT groups.ID_Groups FROM groups WHERE groups.title = :grour));';
    $sth = $dbh->prepare($sql);
    $sth->execute(array(':countLessons' => $countLessons, ':grour' => $grour));
    $timetable = $sth->fetchALL(PDO::FETCH_NUM);

    header('Location: incDBsrc.php');
?>