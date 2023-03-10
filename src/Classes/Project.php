<?php

namespace App\Classes;

use App\Interfaces\IdInterface;
use App\Interfaces\NameInterface;
use App\Interfaces\CodeNoteInterface;
use App\Traits\CodeNotesTrait;
use App\Traits\IdTrait;
use App\Traits\NameTrait;
use App\Classes\Customer;
use App\Classes\Host;

class Project implements 
    IdInterface, 
    nameInterface, 
    codeNoteInterface
{
    use idTrait;
    use NameTrait;
    use codeNotesTrait;
    
    public function __construct
    (
        private int $id,
        private string $name,
        private string $code,
        private ?string $lastpass_folder,
        private ?string $link_mock_ups,
        private int $managed_server,
        private ?string $notes,
        private Host $host,
        private Customer $customer,
    )
    {
    }

    public function __toString()
    {
        return $this->id;
    }

    //lastpass_folder
    public function getLastpast_folder(): ?string
    {
        return $this->lastpass_folder;
    }

    public function setLastpast_folder(string $lastpass_folder): void
    {
        $this->lastpass_folder = $lastpass_folder;
    }

    //link_mock_ups
    public function getLink_mock_ups(): ?string
    {
        return $this->link_mock_ups;
    }

    public function setLink_mock_ups(string $link_mock_ups): void
    {
        $this->link_mock_ups = $link_mock_ups;
    }

    //managed_server
    public function getManaged_server(): int
    {
        return $this->managed_server;
    }

    public function setManaged_server(int $managed_server): void
    {
        $this->managed_server = $managed_server;
    }

    //host
    public function getHost(): Host 
	{
		return $this->host;
	}

	public function setHost(Host $host_id): void
	{
		$this->host = $host_id;
	}

    //customer
	public function getCustomer(): Customer 
	{
		return $this->customer;
	}

	public function setCustomer(Customer $customer_id): void
	{
		$this->customer = $customer_id;
	}
}