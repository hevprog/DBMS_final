<!-- For the CRUD operations para tat products, orders, etc.-->
<?php
   
   class manage extends Database{
    
    
    function add_product($product_name, $category_id, $class_id,$price,$stock,$ROM,$RAM){
        $sql = "insert into product(name,category_id,
        class_id,price,stock,ROM,RAM) values( :name, :category_id, :class_id,
        :price, :stock, :ROM, :RAM);";
        
        $stmt = parent::connect()->prepare($sql);
        $stmt->bindValue( ":name",$product_name,PDO::PARAM_STR);
        $stmt->bindValue(":category_id", $category_id, PDO::PARAM_INT);
        $stmt->bindValue(":class_id", $class_id, PDO::PARAM_INT);
        
        //using param str in price kay auto na gin convert it mysql to decimal
        $stmt->bindValue(":price", $price, PDO::PARAM_STR);
        $stmt->bindParam(":stock", $stock, PDO::PARAM_INT);
        $stmt->bindParam(":ROM", $ROM, PDO::PARAM_INT);
        $stmt->bindParam(":RAM", $RAM, PDO::PARAM_INT);

        $stmt->execute();
        return ($stmt == false)? false:true;
    }
    function query($sql){ //DO NOT LET IT USER PAG INPUT HAN PARAM :)
        $database = parent::connect();
        $stmt = $database->prepare($sql);
        return ($stmt->execute())?$stmt->fetchAll(PDO::FETCH_ASSOC):0;
    }
   }
?>