<?php
/**
 * User: James
 * Date: 5/21/13
 * Time: 8:35 PM
 */

class Idea {
    public $id;
    public $owner;
    private $ownerId;
    public $title;
    public $summary;
    public $description;
    public $promoted;
    public $upvotes;
    public $downvotes;
    public $submitted;
    public $deleted;
    public $vote;
    public $editable;
    public $isOwner;

    private $hotscore;

    function __construct() {
        $this->id = 0;
        $this->title = "";
        $this->owner = null;
        $this->summary = "";
        $this->description = "";
        $this->promoted = false;
        $this->upvotes = 0;
        $this->downvotes = 0;
        $this->submitted = new DateTime;
        $this->deleted = false;
        $this->vote = 0;
        $this->editable = false;
        $this->isOwner = false;
    }

    function Bind($connection){

    }

    function Score()
    {
        return $this->upvotes - $this->downvotes;
    }

    function SetUpVotes( $value ) {
        $this->upvotes += $value;
    }

    function SetDownVotes( $value ) {
        $this->downvotes += $value;
    }

    function Save(){
        global $SITE;

        if ($this->id == 0)
        {
            $SITE['runtime']['connection']->QueryString = "INSERT INTO Idea (`userId`,`title`,`summary`,`description`,`upvotes`,`downvotes`,`submitted`,`promoted`) VALUES (?,?,?,?,?,?,?,?)";

            $SITE['runtime']['connection']->addInParam('s', $this->owner->ID());
            $SITE['runtime']['connection']->addInParam('s', $this->title);
            $SITE['runtime']['connection']->addInParam('s', $this->summary);
            $SITE['runtime']['connection']->addInParam('s', $this->description);
            $SITE['runtime']['connection']->addInParam('i', $this->upvotes);
            $SITE['runtime']['connection']->addInParam('i', $this->downvotes);
            $SITE['runtime']['connection']->addInParam('s', $this->submitted->format('Y-m-d H:i:s'));
            $SITE['runtime']['connection']->addInParam('i', $this->promoted);

            $SITE['runtime']['connection']->prepare();
            $SITE['runtime']['connection']->execute();
            $this->id = $SITE['runtime']['connection']->getInsertId();
            $SITE['runtime']['connection']->close();

            if ($this->ID() != 0)
                return true;

        }
        else
        {
            $SITE['runtime']['connection']->QueryString = "UPDATE `Idea` SET `title` = ?, `summary` = ?, `description` = ?, `upvotes` = ?, `downvotes` = ?, `promoted` = ?, `deleted`= ? WHERE `ideaId` = ?";

            $SITE['runtime']['connection']->addInParam('s', $this->title);
            $SITE['runtime']['connection']->addInParam('s', $this->summary);
            $SITE['runtime']['connection']->addInParam('s', $this->description);
            $SITE['runtime']['connection']->addInParam('i', $this->upvotes);
            $SITE['runtime']['connection']->addInParam('i', $this->downvotes);
            $SITE['runtime']['connection']->addInParam('i', $this->promoted);
            $SITE['runtime']['connection']->addInParam('i', $this->deleted);
            $SITE['runtime']['connection']->addInParam('i', $this->id);

            $SITE['runtime']['connection']->prepare();
            $SITE['runtime']['connection']->execute();

            $SITE['runtime']['connection']->close();
            return true;
        }

        return false;
    }

    function ID(){
        return $this->id;
    }

    function Value(){
    }

    function get_Owner(){
        if ($this->owner == null)
            $this->owner = User::GetById($this->ownerId);

        return $this->owner;

    }

    //https://github.com/reddit/reddit/blob/master/r2/r2/lib/db/_sorts.pyx
    function get_HotScore(){
        if(!isset($this->hotscore))
        {
            $s = $this->Score();
            $order = log(max(abs($s),1), 2);

            if ($s > 0)
                $sign = 1;
            else if ($s < 0)
                $sign = -1;
            else
                $sign = 0;

            $seconds = $this->submitted->format("U") - 1348963200;
            $this->hotscore =  round($order + $sign * $seconds / 172800, 7);
        }

        return $this->hotscore;
    }

    function SetPermissions(){

        if($_SESSION['user']->id == $this->ownerId)
        {
            $this->isOwner = true;
            $this->editable = ($this->submitted->modify('+30 minutes') > new DateTime()) ? true : false;
        }
    }

    public static function GetById($id)
    {
        global $SITE;

        $SITE['runtime']['connection']->QueryString = "SELECT `ideaId`, `userId`,`title`,`summary`,`description`,`upvotes`,`downvotes`,`submitted`,`promoted`,`deleted` FROM Idea WHERE `ideaId` = ?";

        $SITE['runtime']['connection']->addInParam('i', $id);

        $result = new Idea();

        $SITE['runtime']['connection']->addOutParam($result->id);
        $SITE['runtime']['connection']->addOutParam($result->ownerId);
        $SITE['runtime']['connection']->addOutParam($result->title);
        $SITE['runtime']['connection']->addOutParam($result->summary);
        $SITE['runtime']['connection']->addOutParam($result->description);
        $SITE['runtime']['connection']->addOutParam($result->upvotes);
        $SITE['runtime']['connection']->addOutParam($result->downvotes);
        $SITE['runtime']['connection']->addOutParam($submitted);
        $SITE['runtime']['connection']->addOutParam($promoted);
        $SITE['runtime']['connection']->addOutParam($deleted);

        $SITE['runtime']['connection']->Go();
        $SITE['runtime']['connection']->fetch();

        $result->submitted = new DateTime($submitted);
        $result->promoted = (bool)$promoted;
        $result->deleted = (bool)$deleted;
        $result->SetPermissions();

        $SITE['runtime']['connection']->close();
        return $result;
    }


    public static function getList($_promoted = false)
    {
        global $SITE;

        $result = array();
        $SITE['runtime']['connection']->QueryString = "SELECT Idea.ideaId, Idea.userId, Idea.title, Idea.summary, Idea.description, Idea.upvotes, Idea.downvotes, Idea.submitted, Idea.promoted, Idea.deleted, Votesq.value FROM Idea LEFT JOIN (SELECT * FROM Vote WHERE Vote.userId = ?  ) as Votesq ON Idea.IdeaId = Votesq.IdeaId WHERE Idea.deleted = 0 AND Idea.promoted = ? ORDER BY Idea.submitted DESC";
        $SITE['runtime']['connection']->addInParam('i', $_SESSION['user']->id);
        $SITE['runtime']['connection']->addInParam('i', $_promoted);

        $SITE['runtime']['connection']->addOutParam($ideaid);
        $SITE['runtime']['connection']->addOutParam($userid);
        $SITE['runtime']['connection']->addOutParam($title);
        $SITE['runtime']['connection']->addOutParam($summary);
        $SITE['runtime']['connection']->addOutParam($description);
        $SITE['runtime']['connection']->addOutParam($upvotes);
        $SITE['runtime']['connection']->addOutParam($downvotes);
        $SITE['runtime']['connection']->addOutParam($submitted);
        $SITE['runtime']['connection']->addOutParam($promoted);
        $SITE['runtime']['connection']->addOutParam($deleted);
        $SITE['runtime']['connection']->addOutParam($vote);

        $SITE['runtime']['connection']->prepare();
        $SITE['runtime']['connection']->execute();

        while($SITE['runtime']['connection']->fetch())
        {
            $temp = new Idea();
            $temp->id = $ideaid;
            $temp->ownerId = $userid;
            $temp->title = $title;
            $temp->summary = $summary;
            $temp->description = $description;
            $temp->upvotes = $upvotes;
            $temp->downvotes = $downvotes;
            $temp->submitted = new DateTime($submitted);
            $temp->promoted = (bool)$promoted;
            $temp->deleted = (bool)$deleted;
            $temp->vote = $vote;
            $temp->SetPermissions();

            $result[] = $temp;
        }
        $SITE['runtime']['connection']->close();
        return $result;
    }
}