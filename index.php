<?php

abstract class Entity {


    protected $db;

    public function __construct() {
        
        try {
            $this->db = new \PDO('mysql:host=localhost;dbname=blog','root', '');
        

            try { 
                $this->db->beginTransaction(); 
                $this->db->commit(); 
                print $this->db->lastInsertId(); 
            } catch(PDOException $e) { 
                $this->db->rollback(); 
                print "Error!: " . $e->getMessage() . "</br>"; 
            } 
        
        } catch (\Exception $e) {
            throw new \Exception('Error creating a database connection ');
        }
    }


    protected $tableName; 

    public function set() {

        $class = new \ReflectionClass($this);
        
        $tableName = '';

        if ($this->tableName != '') {
            $tableName = $this->tableName;
        } else {
            $tableName = strtolower($class->getShortName());
        }
    
        $propsToImplode = [];
    
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) { // consider only public properties of the providen 
            $propertyName = $property->getName();
            $propsToImplode[] = '`'.$propertyName.'` = "'.$this->{$propertyName}.'"';
        }
    
        $setClause = implode(',',$propsToImplode); // glue all key value pairs together
        $sqlQuery = '';
    
        if ($this->id > 0) {
            $sqlQuery = 'UPDATE `'.$tableName.'` SET '.$setClause.' WHERE id = '.$this->id;
        } else {
            $sqlQuery = 'INSERT INTO `'.$tableName.'` SET '.$setClause.', id = '.$this->id;
        }
    
        $result = self::$db->exec($sqlQuery);
    
        if (self::$db->errorCode()) {
            throw new \Exception(self::$db->errorInfo()[2]);
        }
    
        return $result;
    }
  }

?>