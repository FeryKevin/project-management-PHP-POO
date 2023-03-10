<?php

namespace App\Repository;

use App\Classes\Project;
use App\Database\Connection;
use App\Repository\HostRepository;
use App\Repository\CustomerRepository;


class ProjectRepository{

    //select id
    public static function getProjectById(int $id): ?Project{
        $database = Connection::connect();
        $statement = $database->prepare('SELECT * FROM project WHERE id = ?');
        $statement->execute(array($id));
        $rep = $statement->fetch();

        $customer = CustomerRepository::getCustomerById($rep['customer_id']);
        $host = HostRepository::getHostById($rep['host_id']);

        $pro = ($rep) ? new Project($id, $rep['name'], $rep['code'], 
            $rep['lastpass_folder'], $rep['link_mock_ups'], 
            $rep['managed_server'], $rep['notes'], 
            $host, $customer) : null;
        $database = Connection::disconnect();
        return $pro;
    }

    //select *
    public static function getProject() : array{
        $rep = array();
        $database = Connection::connect();
        $statement = $database->prepare('SELECT * FROM project');
        $statement->execute();
        while($pro = $statement->fetch()){
            $host = HostRepository::getHostById($pro['host_id']);
            $customer = CustomerRepository::getCustomerById($pro['customer_id']);
            $temp = 
            new Project($pro['id'], $pro['name'], $pro['code'], 
                $pro['lastpass_folder'], $pro['link_mock_ups'], 
                $pro['managed_server'], $pro['notes'], 
                $host, $customer);
            $rep[] = $temp;
        }
        $database = Connection::disconnect();
        return $rep;
    }

    //insert
    public static function addProject(Project $project): void{
        $database = Connection::connect();
        $statement = $database->prepare('INSERT INTO project (name, code, lastpass_folder, link_mock_ups, 
            managed_server, notes, host_id, customer_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $statement->execute(array($project->getName(), $project->getCode(), 
            $project->getLastpast_folder(), $project->getLink_mock_ups(), 
            $project->getManaged_server(), $project->getNotes(), $project->getHost()->getId(), 
            $project->getCustomer()->getId()));
        $database = Connection::disconnect();
    }

    //update
    public static function updateProject (Project $oldPro, Project $newPro): void{
        $database = Connection::connect();
        $statement = $database->prepare('UPDATE project set name=? , code=?, lastpass_folder=?, 
            link_mock_ups=?, managed_server=?, notes=?, host_id=?, customer_id=?
            WHERE id = ?');
        $statement->execute(array($newPro->getName(), $newPro->getCode(), 
            $newPro->getLastpast_folder(), $newPro->getLink_mock_ups(), 
            $newPro->getManaged_server(), $newPro->getNotes(), $newPro->getHost()->getId(), 
            $newPro->getCustomer()->getId(), 
            $oldPro->getId()));
        $database = Connection::disconnect();
    }

    //delete
    public static function deleteProject(Project $project): void{
        $database = Connection::connect();
        $statement = $database->prepare('DELETE from project WHERE id = ?');
        $statement->execute(array($project->getId()));
        $database = Connection::disconnect();
    }

    //filtre name
    public static function getByName(string $name): ?array{
        $tab=array();

        $database = Connection::connect();
        $statement = $database->prepare('SELECT * FROM project WHERE name LIKE ?');
        $statement->execute(array('%'.$name.'%'));

        try{
            while($pro = $statement->fetch()){
                $host = HostRepository::getHostById($pro['host_id']);
                $customer = CustomerRepository::getCustomerById($pro['customer_id']);
                $temp = new Project($pro['id'], $pro['name'], $pro['code'], 
                    $pro['lastpass_folder'], $pro['link_mock_ups'], 
                    $pro['managed_server'], $pro['notes'], 
                    $host, $customer);
                $tab[] = $temp;
            }
        }
        catch(int $i){
            return null;
        }

        $database = Connection::disconnect();
        return $tab;
    }

    //filtre customer
    public static function getProjectByCustomer(string $name): ?array{
        $tab = array();
        $database = Connection::connect();
        $statement = $database->prepare('SELECT * FROM project WHERE customer_id in 
            (SELECT id FROM customer WHERE name LIKE ?)');
        $statement->execute(array('%'.$name.'%'));

        try{
            while($pro = $statement->fetch()){
                $host = HostRepository::getHostById($pro['host_id']);
                $customer = CustomerRepository::getCustomerById($pro['customer_id']);
                $temp = new Project($pro['id'], $pro['name'], $pro['code'], 
                    $pro['lastpass_folder'], $pro['link_mock_ups'], 
                    $pro['managed_server'], $pro['notes'], 
                    $host, $customer);
                $tab[] = $temp;
            }
        }
        catch(int $i){
            return null;
        }

        $database = Connection::disconnect();
        return $tab;
    }

    //filtre host
    public static function getProjectByHost(string $name): ?array{
        $tab = array();
        $database = Connection::connect();
        $statement = $database->prepare('SELECT * FROM project WHERE host_id in 
            (SELECT id FROM host WHERE name LIKE ?)');
        $statement->execute(array('%'.$name.'%'));

        try{
            while($pro = $statement->fetch()){
                $host = HostRepository::getHostById($pro['host_id']);
                $customer = CustomerRepository::getCustomerById($pro['customer_id']);
                $temp = new Project($pro['id'], $pro['name'], $pro['code'], 
                    $pro['lastpass_folder'], $pro['link_mock_ups'], 
                    $pro['managed_server'], $pro['notes'], 
                    $host, $customer);
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