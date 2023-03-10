<?php

namespace App\Forms;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use App\Classes\Customer;
use App\Classes\Environment;
use App\Classes\Host;
use App\Classes\Project;
use App\Classes\Contact;
use App\Repository\CustomerRepository;
use App\Repository\HostRepository;


class Validator{
    // Verificaition des inputs
    public static function verifyInput($var){
        $var = trim($var);
        $var = stripslashes($var);
        $var = htmlspecialchars($var);
        return $var;
    }    

    //customer
    public static function checkCustomer(Customer $customer): ?array{
        $rep = array();

        if (null == $customer->getName()){
            $rep ["nameError"] = 'Veuillez renseigner un nom';
        }
        return (empty($rep))? null : $rep;
    }

    //host
    public static function checkHost(Host $host): ?array{
        $rep = array();

        if (null == $host->getName()){
            $rep ["nameError"] = 'Veuillez renseigner un nom';
        }

        return (empty($rep))? null : $rep;
    }

    //project
    public static function checkProject(Project $project): ?array{
        $rep = array();

        if (null == $project->getName()){
            $rep ["nameError"] = 'Veuillez renseigner un nom';
        }

        if (null == HostRepository::getHostById($project->getHost()->getId())){
            $rep ["hostError"] = 'Veuillez renseigner un hébergeur';
        }

        if (null == CustomerRepository::getCustomerById($project->getCustomer()->getId())){
            $rep ["customerError"] = 'Veuillez renseigner un client';
        }

        return (empty($rep))? null : $rep;
    }

    //Contact
    public static function checkContact(Contact $contact): ?array{
        $rep = array();
        $validator = new EmailValidator();

        if (null == $contact->getName()){
            $rep ["nameError"] = 'Veuillez renseigner un nom';
        }

        if (null != $contact->getEmail()){
            if(!$validator->isValid($contact->getEmail(), new RFCValidation())){
                $rep['emailError'] = 'Veuillez renseigner une adresse email correcte';
            }
        }

        if (null === $contact->getHost() && null === $contact->getCustomer()){
            $rep['hostCusError'] = 'Veuillez renseigner soit un client, soit un hébergeur';
        }

        return (empty($rep))? null : $rep;
    }

    //Environment
    public static function checkEnvironment(Environment $environment): ?array{
        $rep = array();

        if (null == $environment->getProject()){
            $rep['projectError'] = 'Veuillez sélectionner un projet';
        }

        if (null != $environment->getSsh_port() && !preg_match('/^[1-9][0-9]*$/',$environment->getSsh_port())){
            $rep['ssh_portError'] = 'Veuillez rentrez un port valide';
        }

        return (empty($rep))? null : $rep;
    }
}