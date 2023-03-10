<?php

namespace App\Repository;

use App\Classes\Host;
use App\Database\Connection;

class HostRepository{

    //select id
    public static function getHostById(int $id): ?Host{
        $database = Connection::connect();
        $statement = $database->prepare('SELECT * FROM host WHERE id = ?');
        $statement->execute(array($id));
        $rep = $statement->fetch();
        $host = ($rep) ? new Host ($id, $rep['code'], $rep['name'], $rep['notes']) : null;
        $database = Connection::disconnect();
        return $host;
    }

    //select *
    public static function getHost() : array{
        $rep = array();
        $database = Connection::connect();
        $statement = $database->prepare('SELECT * FROM host');
        $statement->execute();
        $database = Connection::disconnect();
        while($host = $statement->fetch()){
            $temp = new Host ($host['id'], $host['code'], $host['name'], $host['notes']);
            $rep[] = $temp;
        }
        return $rep;
    }

    //insert
    public static function addHost(Host $host): void{
        $database = Connection::connect();
        $statement = $database->prepare('INSERT INTO Host (code, name, notes) VALUES (?, ?, ?)');
        $statement->execute(array($host->getCode(), $host->getName(), $host->getNotes()));
        $database = Connection::disconnect();
    }

    //update
    public static function updateHost (Host $oldHost, Host $newHost): void{
        $database = Connection::connect();
        $statement = $database->prepare ('UPDATE host set code = ?, name = ?, notes = ? WHERE id= ?');
        $statement->execute(array($newHost->getCode(), $newHost->getName(), $newHost->getNotes(), $oldHost->getId()));
        $database = Connection::disconnect();
    }

    //delete
    public static function deleteHost(Host $host): void{
        $database = Connection::connect();
        $statement = $database->prepare('DELETE from Host WHERE id = ?');
        $statement->execute(array($host->getId()));
        $database = Connection::disconnect();
    }

    //filtre code 
    public static function getByCode(string $code): ?array{
        $tab=array();

        $database = Connection::connect();
        $statement = $database->prepare('SELECT * FROM Host WHERE name LIKE ?');
        $statement->execute(array('%'.$code.'%'));

        try{
            while($host = $statement->fetch()){
                
                $temp = new Host($host['id'], $host['code'], $host['name'], $host['notes']);
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
        $statement = $database->prepare('SELECT * FROM Host WHERE name LIKE ?');
        $statement->execute(array('%'.$name.'%'));

        try{
            while($host = $statement->fetch()){
                
                $temp = new Host($host['id'], $host['code'], $host['name'], $host['notes']);
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
        $statement = $database->prepare('SELECT * FROM Host WHERE name LIKE ?');
        $statement->execute(array('%'.$notes.'%'));

        try{
            while($host = $statement->fetch()){
                
                $temp = new Host($host['id'], $host['code'], $host['name'], $host['notes']);
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