<?php

class User
{
    private $name;
    private $email;
    private $phone;
    private $address;
    private $password;

    public function __construct($name, $email, $phone, $address, $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function register()
    {
        global $db;

        $check = mysqli_query($db->getConnection(), "SELECT * FROM user WHERE email = '$this->email'");

        if (mysqli_num_rows($check) == 1) {
            return false;
        }

        $sql = "INSERT INTO user (name, email, password, phone, address) VALUES ('$this->name', '$this->email', '$this->password', '$this->phone', '$this->address')";

        if (mysqli_query($db->getConnection(), $sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }
}

class UserService
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function login(string $email, string $password): ?User
    {
        $user = $this->getUserByEmail($email);

        if ($user && $user->verifyPassword($password)) {
            return $user;
        }

        return null;
    }

    public function getUserByEmail(string $email): ?User
    {
    $query = "SELECT * FROM user WHERE email = '$email'";
    $result = $this->db->query($query);

    if (mysqli_num_rows($result) === 1) {
        $data = mysqli_fetch_assoc($result);
        return new User($data['name'], $data['email'], $data['password'], $data['phone'], $data['address']);
    }

    return null;
    }
}