<?php

namespace App\Repository;

use App\Classes\Contact;
use App\Database\Connection;
use App\Repository\HostRepository;
use App\Repository\CustomerRepository;

class ContactRepository{

    //select id
    public static function getContactById(int $id): ?Contact{
        $database = Connection::connect();
        $statement = $database->prepare('SELECT * FROM contact WHERE id = ?');
        $statement->execute(array($id));
        $rep = $statement->fetch();
        $cus = ($rep) ? new Contact($id, $rep['name'], $rep['email'], $rep['phone_number'], $rep['role']) : null;
        $database = Connection::disconnect();
        return $cus;
    }

    //select *
    public static function getContact() : array{
        $rep = array();
        $database = Connection::connect();
        $statement = $database->prepare('SELECT * FROM contact');
        $statement->execute();
        $database = Connection::disconnect();
        while($con = $statement->fetch()){
            if (null === $con['host_id']){
                $temp = new Contact($con['id'], $con['name'], $con['email'], $con['phone_number'], $con['role'], customer:CustomerRepository::getCustomerById($con['customer_id']));
                $rep[] = $temp;
            }else{
                $temp = new Contact($con['id'], $con['name'], $con['email'], $con['phone_number'], $con['role'], host : HostRepository::getHostById($con['host_id']));
                $rep[] = $temp;
            }

        }
        return $rep;
    }

    //insert
    public static function addContact(Contact $contact): void{
        $database = Connection::connect();
        $statement = $database->prepare('INSERT INTO contact (name, email, phone_number, role, host_id, customer_id) VALUES (?, ?, ?, ?, ?, ?)');
        if (null === $contact->getCustomer()){
            $statement->execute(array($contact->getName(), $contact->getEmail(), $contact->getPhone(), $contact->getRole(), $contact->getHost()->getId(), null));
        }
        else{
            $statement->execute(array($contact->getName(), $contact->getEmail(), $contact->getPhone(), $contact->getRole(), null, $contact->getCustomer()->getId()));
        }
        $database = Connection::disconnect();
    }

    //update
    public static function updateContact(Contact $oldCon, Contact $newCon): void{
        $database = Connection::connect();
        $statement = $database->prepare ('UPDATE contact set name = ?, email = ?, phone_number = ?, 
        role = ? WHERE id= ?');
        $statement->execute(array($newCon->getName(), $newCon->getEmail(), $newCon->getPhone(), 
        $newCon->getRole(), $oldCon->getId()));
        $database = Connection::disconnect();
    }

    //delete
    public static function deleteContact(Contact $contact): void{
        $database = Connection::connect();
        $statement = $database->prepare('DELETE from contact WHERE id = ?');
        $statement->execute(array($contact->getId()));
        $database = Connection::disconnect();
    }

    public static function getContactByHost(int $id): ?array{
        $rep = array();
        $database = Connection::connect();
        $statement = $database->prepare('SELECT * FROM contact WHERE host_id = ?');
        $statement->execute(array($id));
        while ($con = $statement->fetch()){
            $rep[] = new Contact($con['id'], $con['name'], $con['email'], $con['phone_number'], $con['role'], host : HostRepository::getHostById($id));
        }
        $database = Connection::disconnect();
        return $rep;
    }

    public static function getContactByCustomer(int $id): ?array{
        $rep = array();
        $database = Connection::connect();
        $statement = $database->prepare('SELECT * FROM contact WHERE customer_id = ?');
        $statement->execute(array($id));
        while ($con = $statement->fetch()){
            $rep[] = new Contact($con['id'], $con['name'], $con['email'], $con['phone_number'], $con['role'], host : HostRepository::getHostById($id));
        }
        $database = Connection::disconnect();
        return $rep;
    }
}