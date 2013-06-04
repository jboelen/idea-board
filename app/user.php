<?php
/**
 * User: James
 * Date: 5/21/13
 * Time: 7:33 PM
 */


class User {
    public $id = 0;
    public $firstname = "";
    public $lastname = "";
    public $email = "";
    public $password = "";
    public $authlevel = 0;
    public $key = "";
    public $authority = 1;
    public $locked = 0;
    public $vote = 0;
    function __construct() {

    }

    function Bind($connection)
    {
        $connection->addOutParam($this->id);
        $connection->addOutParam($this->key);
        $connection->addOutParam($this->firstname);
        $connection->addOutParam($this->lastname);
        $connection->addOutParam($this->email);
        $connection->addOutParam($this->authority);
        $connection->addOutParam($this->locked);
        $connection->Go();
    }

    public static function Authenticate($email,$password) {
        global $SITE;
        $password = sha1($password);

        $SITE['runtime']['connection']->QueryString = "SELECT `userId`, `key`, `firstname`, `lastname`, `email`, `authority`, `locked` FROM User WHERE email=? AND password=? AND locked = 0";

        $SITE['runtime']['connection']->addInParam('s', $email);
        $SITE['runtime']['connection']->addInParam('s', $password);

        $result = new User();
        $result->Bind($SITE['runtime']['connection']);

        if ($SITE['runtime']['connection']->get_rows() == 1) {
            $result->authlevel = 1;

            $SITE['runtime']['connection']->fetch();
            $SITE['runtime']['connection']->close();

            return $result;
        }
        return null;
    }

    function ID()
    {
        return $this->id;
    }

    function Logout() {
        return true;
    }

    function GetByKey($key)
    {
        global $SITE;
        $SITE['runtime']['connection']->close();
        $SITE['runtime']['connection']->QueryString = "SELECT `userId`, `key`, `firstname`, `lastname`, `email`, `authority`, `locked` FROM `User` WHERE `key`=?";

        $SITE['runtime']['connection']->addInParam('s', $key);

        Bind($SITE['runtime']['connection']);

        if ($SITE['runtime']['connection']->get_rows() == 1) {
            $this->authlevel = 1;
            $SITE['runtime']['connection']->fetch();
            $SITE['runtime']['connection']->close();
            return true;
        }

        $SITE['runtime']['connection']->close();
        return false;
    }

    public static function GetById($id)
    {
        global $SITE;
        $SITE['runtime']['connection']->QueryString = "SELECT `userId`, `key`, `firstname`, `lastname`, `email`, `authority`, `locked` FROM `User` WHERE `userId`=?";

        $SITE['runtime']['connection']->addInParam('s', $id);
        $result = new User();

        $result->Bind($SITE['runtime']['connection']);

        if ($SITE['runtime']['connection']->get_rows() == 1) {
            $result->authlevel = 1;
            $SITE['runtime']['connection']->fetch();
            $SITE['runtime']['connection']->close();
            return $result;
        }

        $SITE['runtime']['connection']->close();
        return $result;
    }

    public static function GetAll()
    {
        global $SITE;
        $SITE['runtime']['connection']->QueryString = "SELECT `userId`, `key`, `firstname`, `lastname`, `email`, `authority`, `locked` FROM `User`";

        $SITE['runtime']['connection']->addOutParam($_id);
        $SITE['runtime']['connection']->addOutParam($_key);
        $SITE['runtime']['connection']->addOutParam($_firstname);
        $SITE['runtime']['connection']->addOutParam($_lastname);
        $SITE['runtime']['connection']->addOutParam($_email);
        $SITE['runtime']['connection']->addOutParam($_authority);
        $SITE['runtime']['connection']->addOutParam($_locked);

        $SITE['runtime']['connection']->Go();

        $result = array();
        while($SITE['runtime']['connection']->fetch()){
            $temp = new User();
            $temp->id = $_id;
            $temp->key = $_key;
            $temp->firstname = $_firstname;
            $temp->lastname = $_lastname;
            $temp->email = $_email;
            $temp->authority = $_authority;
            $temp->locked = $_locked;
            $result[] = $temp;
        }

        $SITE['runtime']['connection']->close();
        return $result;
    }

    function Save()
    {
        global $SITE;
        if ($this->id == 0)
        {
            $SITE['runtime']['connection']->QueryString = "INSERT INTO User (`key`,`firstname`,`lastname`,`email`) VALUES (?,?,?,?)";
            $SITE['runtime']['connection']->addInParam('s', $this->key);
            $SITE['runtime']['connection']->addInParam('s', $this->firstname);
            $SITE['runtime']['connection']->addInParam('s', $this->lastname);
            $SITE['runtime']['connection']->addInParam('s', $this->email);

            $SITE['runtime']['connection']->Go();

            $this->id = $SITE['runtime']['connection']->getInsertId();
            $SITE['runtime']['connection']->close();

            if ($this->ID() != 0)
                return true;
        }
        else
        {
            $SITE['runtime']['connection']->QueryString = "UPDATE User SET `firstname` = ?, `lastname` = ?, `email` = ?, `password` = ?, `key`= ?, `authority` = ?, `locked`=? WHERE `userId`= ?";

            $SITE['runtime']['connection']->addInParam('s', $this->firstname);
            $SITE['runtime']['connection']->addInParam('s', $this->lastname);
            $SITE['runtime']['connection']->addInParam('s', $this->email);
            $SITE['runtime']['connection']->addInParam('s', $this->password);
            $SITE['runtime']['connection']->addInParam('s', $this->key);
            $SITE['runtime']['connection']->addInParam('i', $this->authority);
            $SITE['runtime']['connection']->addInParam('i', $this->locked);
            $SITE['runtime']['connection']->addInParam('i', $this->id);

            $SITE['runtime']['connection']->Go();
            $SITE['runtime']['connection']->close();
            return true;
        }

        return false;
    }

    function SendInvite(){

        global $site_name;
        $to = "\"" . $this->firstname . " " . $this->lastname . "\"<" . $this->email . ">";
        $subject = "$site_name Invitation";

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        //$headers .= 'From: "$site_name" <no-reply@boelen.ca>' . "\r\n";
        $message = <<<eof
<html>
<head>
  <title>$subject</title>
</head>
<body>
  <h1>Hello {$this->firstname} {$this->lastname}!</h1>
  <p>You have been sent an invitation to collaborate and share ideas at $site_name. You may accept this
  invitation by clicking on the link below.</p>
  <p>
  Your invitation link:
  <a href="http://premise.boelen.ca/account.php?action=register&key=$this->key"> Click Here to Accept!</a>
  </p>
  <p>
  Your Registration Code: <strong>$this->key</strong>
  </p>
  <p>Sincerely,<br /> The Great Salmon Spirt.</p>
</body>
</html>
eof;
        return (mail($to, $subject, $message, $headers));
    }

}