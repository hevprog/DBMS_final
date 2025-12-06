<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager</title>
</head>
<body>
   <form method="post" action="../admin/manage.php">
        <input type="hidden" name="is_pressed" value="true">
        Product Name: <input type="text" name="Product_name"><br>
        Choose categories<br>
        <?php
            require_once __DIR__."/../config/database.php";
            require_once __DIR__."/../admin/manage.php";
            $manage = new manage();
            $categories = $manage->query("SELECT category_name FROM category");
            if($categories != false){
                foreach($categories as $col){
                    echo '<input type="radio" id="'.$col["category_name"].
                    '" name= category" value="'.$col["category_name"].'">';
                    echo '<label for="'.$col["category_name"].'">'.$col["category_name"].'</label><br>';
                }
            }else{
                echo "NO categories found<br>";
            }
        ?>
        Choose class ID <br>
        <?php
            require_once __DIR__."/../config/database.php";
            require_once __DIR__."/../admin/manage.php";
            $manage = new manage();
            $class = $manage->query("SELECT class_name FROM class");
            if($class != false){
                foreach($class as $col){
                    echo '<input type="radio" id="'.$col["class_name"].
                    '" name=class value="'.$col["class_name"].'">';
                    echo '<label for="'.$col["class_name"].'">'.$col["class_name"].'</label><br>';
                }
            }else{
                echo "NO classes found<br>";
            }
        ?>
        <button type="submit">INSERT</button>
    </form>
    
</body>
</html>