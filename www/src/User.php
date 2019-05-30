<?php

require "QueryBuilder.php";

class User
{
    const TABLE = "users";

    private $login;
    private $email;
    private $password_hash;
    private $password;
    private $admin = 0;
    private $queryBuilder;

    function __construct(array $kwargs)
    {
        if ($kwargs["login"] && $kwargs["password"]) {
            $this->login = $kwargs["login"];
            $this->password_hash = hash("whirlpool", $kwargs["password"]);
            $this->password = $kwargs["password"];
            $this->queryBuilder = new QueryBuilder(["db" => new PDO("mysql:host=db; dbname=myDb", "user", "test")]);
        }
        if ($kwargs["email"]){
            $this->email = $kwargs["email"];
        }
    }

    public function __set($name, $value)
    {
        echo "This attribute $name is private or couldn't be initialized with value $value\n";
    }

    public function __get($name)
    {
        echo "This attribute $name is private or doesn't exist\n";
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function setPassword($password)
    {
        $this->password_hash = hash("whirlpool", $password);
    }

    public function setAdmin($admin)
    {
        $this->admin = (is_numeric($admin)) ? $admin : 0;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getPassword()
    {
        return $this->password_hash;
    }

    public function getAdmin()
    {
        return $this->admin;
    }

    public function authUser()
    {
        if (!($user = $this->queryBuilder->filterDataByCol(USER::TABLE, "login", $this->login)[0])) {
            return false;
        }
        if (!$user["activated"])
            throw new RuntimeException("activation");
        return $user["password"] === $this->password_hash;
    }

    public function isUserAdmin()
    {
        if (!($user = $this->queryBuilder->filterDataByCol(USER::TABLE, "login", $this->login)[0])) {
            return false;
        }
        $this->admin = $user["admin"];
        return $user["admin"] === 1;
    }

    //add user data to $_SESSION
    public function loginUser()
    {
        try {
            $success = $this->authUser();
        } catch (Exception $exception) {
            throw $exception;
        }
        if ($success) {
            $_SESSION["logged"] = [
                "login" => $this->login,
                "password" => $this->password_hash,
            ];
            $_SESSION["logged"]["admin"] = ($this->isUserAdmin()) ? 1 : 0;
            return true;
        }
        return false;
    }

    public function isLoggedUser()
    {
        return (isset($_SESSION["logged"])) ? true : false;
    }

    public function logoutUser()
    {
        unset($_SESSION["logged"]);
    }

    private function createRegisterEmail($hash)
    {
        $subject = "SignUp | Great Site !!";
        $message = '
        
        Thanks for signing up!
        Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
        
        ------------------------
        Username: ' . $this->login . '
        Password: ' . $this->password . '
        ------------------------
        
        Please click this link to activate your account:'
        .$_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["SERVER_NAME"].':'.$_SERVER["SERVER_PORT"].'/src/verify.php?email=' . $this->email .
            '&hash='. $hash . '
        
        ';
        return ["subject" => $subject, "message" => $message];
    }

    //register
    public function registerUser()
    {
        if ($this->authUser()) {
            throw new Exception("login");
        }
        if ($this->queryBuilder->filterDataByCol("users", "email", $this->email)) {
            throw new Exception("email");
        }
        $path = "/var/www/html/data/$this->login";
        if (!file_exists($path))
            mkdir($path, 0777, true);
        try {
            $hash = bin2hex(random_bytes(16));
        } catch (Exception $exception) {
            $hash = bin2hex(openssl_random_pseudo_bytes(16));
        }
        if ($this->queryBuilder->insertDataIntoTable(USER::TABLE,
            [$this->login, $this->email, $this->password_hash, $this->admin, $hash, 0])) {
            $letter = $this->createRegisterEmail($hash);
            return mail($this->email,
                $letter["subject"], $letter["message"]);
        }
        return false;
    }

    //change login
    public function changeLoginUser($newLogin)
    {
        if (!($user = $this->queryBuilder->filterDataByCol(USER::TABLE, "login", $this->login))) {
            return false;
        }
        $user["login"] = $newLogin;
        return $this->queryBuilder->updateDataById(USER::TABLE, "id",
            $user["id"], $user);
    }

    //change password
    public function changePasswordUser($newPassword)
    {
        if (!($user = $this->queryBuilder->filterDataByCol(USER::TABLE, "login", $this->login))) {
            return false;
        }
        $user["password"] = hash("whirlpool", $newPassword);
        return $this->queryBuilder->updateDataById(USER::TABLE, "id",
            $user["id"], $user);
    }
}
