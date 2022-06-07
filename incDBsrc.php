<?php
    include('connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lab_3</title>
    <script>
        const ajax = new XMLHttpRequest();

        //ajax
        function get1(){
            ajax.onreadystatechange = loadData1;
            let grClSch =  document.getElementById("grClSch").value;
            ajax.open("GET", "show1.php?grClSch=" + grClSch, true);
            ajax.send();
        }

        function loadData1(){
            if(ajax.readyState === 4)
            {
                if(ajax.status === 200)
                {
                    console.log(ajax.response);
                    document.getElementById("res").innerHTML = ajax.response;
                }
            }
        }


        // xml
        function get2(){
            ajax.onreadystatechange = loadData2;
            var teachClSch =  document.getElementById("teachClSch").value;
            ajax.open("GET", "show2.php?teachClSch=" + teachClSch);
            ajax.send();

        }
        function loadData2(){
            if(ajax.readyState === 4)
            {
                if(ajax.status === 200)
                {
                    console.dir(ajax);
                    console.log(ajax.response);
                    let rows = ajax.responseXML.firstChild.children;
                    let res = "";
                    for(var i=0; i<rows.length; i++){
                        res += "<tr>";
                        res += "<td>" + rows[i].children[0].textContent + "</td>";
                        res += "<td>" + rows[i].children[1].textContent + "</td>";
                        res += "<td>" + rows[i].children[2].textContent + "</td>";
                        res += "<td>" + rows[i].children[3].textContent + "</td>";
                        res += "<td>" + rows[i].children[4].textContent + "</td>";
                        res += "<td>" + rows[i].children[5].textContent + "</td>";
                        res += "<td>" + rows[i].children[6].textContent + "</td>";
                        res += "</tr>";
                    }
                    document.getElementById("res").innerHTML = res;
                }
            }
        }

        


        // json
        function get3(){
            ajax.onreadystatechange = loadData3;
            let audClSch =  document.getElementById("audClSch").value;
            ajax.open("GET", "show3.php?audClSch=" + audClSch);
            ajax.send();
        }

        function loadData3(){
            if(ajax.readyState === 4){
                if(ajax.status === 200){
                    console.dir(ajax.response);

                    let par = JSON.parse(ajax.response);
                    console.dir(par);
                    let res = "";

                    // for(raa of par){
                    //     //console.log(raa);
                    //     res += "<tr>";
                    //     res += "<td>" + raa.week_day + "</td>";
                    //     res += "<td>" + raa.lesson_number + "</td>";
                    //     res += "<td>" + raa.auditorium + "</td>";
                    //     res += "<td>" + raa.disciple + "</td>";
                    //     res += "<td>" + raa.name + "</td>";
                    //     res += "<td>" + raa.type + "</td>";
                    //     res += "<td>" + raa.title + "</td>";
                    //     res += "</tr>";
                    // }

                    for(raa in par){
                        //console.log(raa);
                        res += "<tr>";
                        res += "<td>" + par[raa].week_day + "</td>";
                        res += "<td>" + par[raa].lesson_number + "</td>";
                        res += "<td>" + par[raa].auditorium + "</td>";
                        res += "<td>" + par[raa].disciple + "</td>";
                        res += "<td>" + par[raa].name + "</td>";
                        res += "<td>" + par[raa].type + "</td>";
                        res += "<td>" + par[raa].title + "</td>";
                        res += "</tr>";
                    }

                    // for(var i = 0; i < par.length; i++){
                    //     res += "<tr>";
                    //     res += "<td>" + par[i].week_day + "</td>";
                    //     res += "<td>" + par[i].lesson_number + "</td>";
                    //     res += "<td>" + par[i].auditorium + "</td>";
                    //     res += "<td>" + par[i].disciple + "</td>";
                    //     res += "<td>" + par[i].name + "</td>";
                    //     res += "<td>" + par[i].type + "</td>";
                    //     res += "<td>" + par[i].title + "</td>";
                    //     res += "</tr>";
                    // }

                    document.getElementById("res").innerHTML = res;
                }
            }
        }

    </script>
</head>
<body >
    <div>
        <b>Вывести расписание занятий группы</b> 
        <select name="grClSch" id="grClSch">
        <?php
            try{
                
                $sql = 'SELECT title FROM groups';
                foreach($dbh->query($sql) as $row){
                    $name = $row[0];
                    print"<option value='$name'> $name</option>";
                }
                
            }
            catch(PDOException $ex){
                echo $ex->GetMessage();
            }
        ?>
        </select>
        <br>
        <input type = 'button' value = "Get" onclick = "get1()">

        

        <br>
        <b>Вывести рассписание преподавателя</b>
        <select name="teachClSch" id="teachClSch">
        <?php
            try{
                $sql = 'SELECT name FROM teacher';
                foreach($dbh->query($sql) as $row){
                    $name = $row[0];
                    print"<option value='$name'> $name</option>";
                }
            }
            catch(PDOException $ex){
                echo $ex->GetMessage();
            }

        ?>
        </select>
        <br>
        <input type = 'button' value = "Get" onclick = "get2()">



        <br>
        <b>Вывести расписание для аудитории</b>
        <select name="audClSch" id="audClSch">
        <?php
            try{
                $sql = 'SELECT auditorium FROM lesson';
                foreach($dbh->query($sql) as $row){
                    $name = $row[0];
                    print"<option value='$name'> $name</option>";
                }
            }
            catch(PDOException $ex){
                echo $ex->GetMessage();
            }

        ?>
        </select>
        <br>
        <input type = 'button' value = "Get" onclick = "get3()">

        
        <br>
        <b>Добавление нового ПЗ</b>
        <form action = 'Add.php' method = 'post'>
            Введите день недели   
            <input type = 'text' placeholder = "Введите день недели" name = 'weekDayAdd' /><br />

            Введите номер пары   
            <input type = 'number' placeholder = "Введите номер пары" name = 'lessonNumAdd' /><br />

            Введите номер аудитории   
            <input type = 'text' placeholder = "Введите номер аудитории" name = 'auditAdd' /><br />

            Введите название дисплины   
            <input type = 'text' placeholder = "Введите название дисплины" name = 'discAdd' /><br />


            <b>Выберите преподователя</b>
            <select name="teachClAdd">
            <?php
                try{
                    $sql = 'SELECT name FROM teacher';
                    foreach($dbh->query($sql) as $row){
                        $name = $row[0];
                        print"<option value='$name'> $name</option>";
                    }
                }
                catch(PDOException $ex){
                    echo $ex->GetMessage();
                }
            ?>
            </select>

            
            <b>Выберите группу</b>
            <select name="grClAdd">
            <?php
                try{
                    
                    $sql = 'SELECT title FROM groups';
                    foreach($dbh->query($sql) as $row){
                        $name = $row[0];
                        print"<option value='$name'> $name</option>";
                    }
                    
                }
                catch(PDOException $ex){
                    echo $ex->GetMessage();
                }
            ?>
            </select>

            <br>
            <input type = 'submit' value = 'Добавить' />
        </form>
    </div>

    

    <table border="1">
        <thead>
            <tr>
                <th>week_day</th>
                <th>lesson_num</th>
                <th>auditorium</th>
                <th>disciple</th>
                <th>name</th>
                <th>type</th>
                <th>group</th>
            </tr>
        </thead>
        <tbody id="res">

        </tbody>
    </table>

</body>
</html>