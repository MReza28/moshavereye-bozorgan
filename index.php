<?php
    $k =  file_get_contents("people.json"); 
    $array = json_decode($k, true);
    $keys = array_keys($array);

    if (empty($_POST["person"])){
        $question = "";
        $en_name = $keys[rand(0,15)] ;
        $msg = "سوال خود را مطرح کنید";
    }
    else {
        $question = $_POST["question"];
        $en_name = $_POST["person"] ;

        $code = $question.$en_name;
        $int = intval(hash("crc32", $code), 16);

        $message = file_get_contents("messages.txt");
        $marray = explode("\n" , $message);
        $msg = $marray[$int%16];
        
        //baraye estefade as آیا dar avval soal
        $ayya = explode(" " , $question);
        if ($ayya[0] != "آیا"){
            $msg = "سوال درستی پرسیده نشده است" ;
        }
    }
    $fa_name = $array[$en_name];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>
<body>
<p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
<div id="wrapper">
    <?php
    if (empty($_POST["person"])){
    echo "<div id=\"title\">
        <span id=\"label\"></span>";
    }
    else{
        echo "<div id=\"title\">
        <span id=\"label\">پرسش:</span>";
    }
    ?>
        <span id="question"><?php echo $question ?></span>
    </div>
    
    <div id="container">
        <div id="message">
            <p><?php echo $msg ?></p>
        </div>
        <div id="person">
            <div id="person">
                <img src="images/people/<?php echo "$en_name.jpg" ?>"/>
                <p id="person-name"><?php echo $fa_name ?></p>
            </div>
        </div>
    </div>
    <div id="new-q">
        <form method="post">
            سوال
            <input type="text" name="question" value="<?php echo $question ?>" maxlength="150" placeholder="..."/>
            را از
            <select name="person">
                <?php
                    for ($i = 0; $i < 16; $i++) {
                        $cursor = $keys[$i];
                        $answer = $array[$cursor];
                        if ($cursor == $en_name){
                            echo "<option value=\"$cursor\" selected> $answer </option>";
                        }
                        else{
                            echo "<option value=\"$cursor\" > $answer </option>";
                        }
                    }
                ?>
            </select>
            <input type="submit" value="بپرس"/>
        </form>
    </div>
</div>
</body>
</html>