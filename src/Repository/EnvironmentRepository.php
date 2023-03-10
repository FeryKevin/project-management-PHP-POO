<?php

namespace App\Repository;

use App\Classes\Environment;
use App\Database\Connection;
use App\Repository\ProjectRepository;

class EnvironmentRepository{

    //select id
    public static function getEnvironmentById(int $id): ?Environment{
        $database = Connection::connect();
        $statement = $database->prepare('SELECT * FROM environment WHERE id = ?');
        $statement->execute(array($id));
        $rep = $statement->fetch();
        $env = ($rep) ? new Environment($id, $rep['name'], $rep['link'], $rep['ip_address'], $rep['ssh_port'],
        $rep['ssh_username'], $rep['phpmyadmin_link'], $rep['ip_restriction'], ProjectRepository::getProjectById($rep['project_id'])) : null;
        $database = Connection::disconnect();
        return $env;
    }

    //select *
    public static function getEnvironment() : array{
        $rep = array();
        $database = Connection::connect();
        $statement = $database->prepare('SELECT * FROM environment');
        $statement->execute();
        $database = Connection::disconnect();
        while($environment = $statement->fetch()){
            $temp = new Environment ($environment['id'], $environment['name'], $environment['link'], $environment['ip_address'], $environment['ssh_port'],
            $environment['ssh_username'], $environment['phpmyadmin_link'], $environment['ip_restriction'], project : ProjectRepository::getProjectById($environment['project_id']));
            $rep[] = $temp;
        }
        return $rep;
    }

    //insert
    public static function addEnvironment(Environment $environment): void{
        $database = Connection::connect();
        $statement = $database->prepare('INSERT INTO environment (name, link, ip_address, ssh_port, ssh_username, phpmyadmin_link, 
        ip_restriction, project_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $statement->execute(array($environment->getName(), $environment->getLink(), $environment->getIp_address(), 
        $environment->getSsh_port(), $environment->getSsh_username(), $environment->getPhpmyadmin_link(),
        $environment->getIp_restriction(), $environment->getProject()->getId()));
        $database = Connection::disconnect();
    }

    //update
    public static function updateEnvironment(Environment $oldEnv, Environment $newEnv): void{
        $database = Connection::connect();
        $statement = $database->prepare ('UPDATE environment set name = ?, link = ?, ip_address = ?, ssh_port = ?, ssh_username = ?, 
        phpmyadmin_link = ?, ip_restriction = ? WHERE id = ?');
        $statement->execute(array($newEnv->getName(), $newEnv->getLink(), $newEnv->getIp_address(), $newEnv->getSsh_port(), $newEnv->getSsh_username(),
        $newEnv->getPhpmyadmin_link(), $newEnv->getIp_restriction(), $oldEnv->getId()));
        $database = Connection::disconnect();
    }

    //delete
    public static function deleteEnvironment(Environment $environment): void{
        $database = Connection::connect();
        $statement = $database->prepare('DELETE from environment WHERE id = ?');
        $statement->execute(array($environment->getId()));
        $database = Connection::disconnect();
    }

    //afficher environnement par projet 
    public static function getEnvironmentByProject(int $id): ?array{
        $rep = array();
        $database = Connection::connect();
        $statement = $database->prepare('SELECT * FROM environment WHERE project_id = ?');
        $statement->execute(array($id));
        while ($env = $statement->fetch()){
            $rep[] = new Environment($env['id'], $env['name'], $env['link'], $env['ip_address'], $env['ssh_port'],
            $env['ssh_username'], $env['phpmyadmin_link'], $env['ip_restriction'], project : ProjectRepository::getProjectById($id));
        }
        $database = Connection::disconnect();
        return $rep;
    }
}