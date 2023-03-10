<?php

namespace App\Repository;

use App\Classes\Customer;
use App\Database\Connection;

class CustomerRepository{

    //select id
    public static function getCustomerById(int $id): ?Customer{
        $database = Connection::connect();
        $statement = $database->prepare('SELECT * FROM customer WHERE id = ?');
        $statement->execute(array($id));
        $rep = $statement->fetch();
        $cus = ($rep) ? new Customer($id, $rep['code'], $rep['name'], $rep['notes']) : null;
        $database = Connection::disconnect();
        return $cus;
    }

    //select *
    public static function getCustomer() : array{
        $rep = array();
        $database = Connection::connect();
        $statement = $database->prepare('SELECT * FROM customer');
        $statement->execute();
        $database = Connection::disconnect();
        while($cus = $statement->fetch()){
            $temp = new Customer($cus['id'], $cus['code'], $cus['name'], $cus['notes']);
            $rep[] = $temp;
        }
        return $rep;
    }

    //insert
    public static function addCustomer(Customer $customer): void{
        $database = Connection::connect();
        $statement = $database->prepare('INSERT INTO customer (code, name, notes) VALUES (?, ?, ?)');
        $statement->execute(array($customer->getCode(), $customer->getName(), $customer->getNotes()));
        $database = Connection::disconnect();
    }

    //update
    public static function updateCustomer (Customer $oldCus, Customer $newCus): void{
        $database = Connection::connect();
        $statement = $database->prepare ('UPDATE customer set code = ?, name = ?, 
        notes = ? WHERE id= ?');
        $statement->execute(array($newCus->getCode(), $newCus->getName(), 
        $newCus->getNotes(), $oldCus->getId()));
        $database = Connection::disconnect();
    }

    //delete
    public static function deleteCustomer(Customer $customer): void{
        $database = Connection::connect();
        $statement = $database->prepare('DELETE from Customer WHERE id = ?');
        $statement->execute(array($customer->getId()));
        $database = Connection::disconnect();
    }

    //filtre code 
    public static function getByCode(string $code): ?array{
        $tab=array();

        $database = Connection::connect();
        $statement = $database->prepare('SELECT * FROM Customer WHERE name LIKE ?');
        $statement->execute(array('%'.$code.'%'));

        try{
            while($cus = $statement->fetch()){
                
                $temp = new Customer($cus['id'], $cus['code'], $cus['name'], $cus['notes']);
                $tab[] = $temp;
            }
        }
        catch(int $i){
            return null;
        }

        $database = Connection::disconnect();
        return $tab;
    }

    //filtre name
    public static function getByName(string $name): ?array{
        $tab=array();

        $database = Connection::connect();
        $statement = $database->prepare('SELECT * FROM Customer WHERE name LIKE ?');
        $statement->execute(array('%'.$name.'%'));

        try{
            while($cus = $statement->fetch()){
                
                $temp = new Customer($cus['id'], $cus['code'], $cus['name'], $cus['notes']);
                $tab[] = $temp;
            }
        }
        catch(int $i){
            return null;
        }

        $database = Connection::disconnect();
        return $tab;
    }

    //filtre notes
    public static function getByNotes(string $notes): ?array{
        $tab=array();

        $database = Connection::connect();
        $statement = $database->prepare('SELECT * FROM Customer WHERE name LIKE ?');
        $statement->execute(array('%'.$notes.'%'));

        try{
            while($cus = $statement->fetch()){
                
                $temp = new Customer($cus['id'], $cus['code'], $cus['name'], $cus['notes']);
                $tab[] = $temp;
            }
        }
        catch(int $i){
            return null;
        }

        $database = Connection::disconnect();
        return $tab;
    }
}