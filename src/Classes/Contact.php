<?php

namespace App\Classes;

use App\Interfaces\IdInterface;
use App\Traits\IdTrait;
use App\Interfaces\NameInterface;
use App\Traits\NameTrait;
use App\Classes\Customer;
use App\Classes\Host;

class Contact implements 
	IdInterface,
	NameInterface
{
	use idTrait;
	use NameTrait;
	
	private ?Customer $customer;
	private ?Host $host;

	public function __construct(
	private int $id,
	private string $name,
	private string $email,
	private string $phone_number,
	private string $role,
	Customer $customer = null,
	Host $host = null,
	)
	{
		$this->customer = $customer;
		$this->host = $host;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function setEmail(string $email): void
	{
		$this->email = $email;
	}

    public function getPhone(): string
	{
		return $this->phone_number;
	}

	public function setPhone(string $phone_number): void
	{
		$this->phone_number = $phone_number;
	}

    public function getRole(): string
	{
		return $this->role;
	}

	public function setRole(string $role): void
	{
		$this->role = $role;
	}

	public function getHost(): ?Host 
	{
		return $this->host;
	}

	public function setHost(Host $host): void
	{
		$this->host = $host;
	}

	public function getCustomer(): ?Customer 
	{
		return $this->customer;
	}

	public function setCustomer(Customer $customer): void
	{
		$this->customer = $customer;
	}
}