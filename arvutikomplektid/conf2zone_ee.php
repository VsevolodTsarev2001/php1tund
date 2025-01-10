 <?php
 //zone kasutaja jaoks conf fail
 $serverinimi="d132044.mysql.zonevs.eu";
 $kasutaja="d132044_sevatsarev";
 $paroll="**********";
 $andmebass="d132044_baasphp";


     $yhendus=new mysqli($serverinimi,$kasutaja,$paroll,$andmebass);
     $yhendus->set_charset("utf8");

     if ($yhendus->connect_error) {
        die("Ошибка подключения к базе данных: " . $yhendus->connect_error);
    }
    ?>
