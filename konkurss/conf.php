 <?php
     $kasutaja="seva";
     $paroll="123456";
     $andmebass="seva";
     $serverinimi="localhost";

     $yhendus=new mysqli($serverinimi,$kasutaja,$paroll,$andmebass);
     $yhendus->set_charset("utf8");
