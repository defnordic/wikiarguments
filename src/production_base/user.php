<?
/********************************************************************************
 * The contents of this file are subject to the Common Public Attribution License
 * Version 1.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at
 * http://www.wikiarguments.net/license/. The License is based on the Mozilla
 * Public License Version 1.1 but Sections 14 and 15 have been added to cover
 * use of software over a computer network and provide for limited attribution
 * for the Original Developer. In addition, Exhibit A has been modified to be
 * consistent with Exhibit B.
 *
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 *
 * The Original Code is Wikiarguments. The Original Developer is the Initial
 * Developer and is Wikiarguments GbR. All portions of the code written by
 * Wikiarguments GbR are Copyright (c) 2012. All Rights Reserved.
 * Contributor(s):
 *     Andreas Wierz (andreas.wierz@gmail.com).
 *
 * Attribution Information
 * Attribution Phrase (not exceeding 10 words): Powered by Wikiarguments
 * Attribution URL: http://www.wikiarguments.net
 *
 * This display should be, at a minimum, the Attribution Phrase displayed in the
 * footer of the page and linked to the Attribution URL. The link to the Attribution
 * URL must not contain any form of 'nofollow' attribute.
 *
 * Display of Attribution Information is required in Larger Works which are
 * defined in the CPAL as a work which combines Covered Code or portions
 * thereof with code not governed by the terms of the CPAL.
 *******************************************************************************/

class User
{
    public function User()
    {
        $this->isLoggedIn   = false;
        $this->userId       = 0;
        $this->voteData     = 0;
    }

    public function create($username, $email, $password, $sendConfirmation = true, $group = USER_GROUP_DEFAULT_SIGNUP)
    {
        global $sDB, $sTemplate;

        $salt         = salt();
        $passwordHash = crypt($password, '$6$rounds=5000$'.$salt.'$');
        $dateAdded    = time();

        $sDB->exec("INSERT INTO `users` (`userId`, `userName`, `email`, `group`, `password`, `salt`, `dateAdded`) VALUES
                                        (NULL, '".mysql_real_escape_string($username)."', '".mysql_real_escape_string($email)."', '".i($group)."', '".mysql_real_escape_string($passwordHash)."', '".mysql_real_escape_string($salt)."', '".i($dateAdded)."');");

        if(mysql_affected_rows())
        {
            $this->userId    = mysql_insert_id();
            $this->userName  = $username;
            $this->email     = $email;
            $this->password  = $passwordHash;
            $this->salt      = $salt;
            $this->dateAdded = $dateAdded;
            $this->group     = $group;

            if($sendConfirmation)
            {
                $confirmationCode = md5(time());
                $confirmationLink = $sTemplate->getRoot()."confirmation.php?userId=".$this->userId."&confirmationCode=".$confirmationCode;

                $this->addConfirmationCode("CONFIRMATION_TYPE_EMAIL", $confirmationCode);

                $subject = $sTemplate->getString("SIGNUP_CONFIRMATION_EMAIL_SUBJECT");
                $message = $sTemplate->getString("SIGNUP_CONFIRMATION_EMAIL_BODY",
                                                 Array("[USERNAME]", "[PASSWORD]", "[CONFIRMATION_LINK]"),
                                                 Array($this->userName, $password, $confirmationLink));

                $mail = new HTMLMail($this->email, $this->email, SENDMAIL_FROM_NAME, SENDMAIL_FROM);
                $mail->buildMessage($subject, $message);
                $mail->sendmail();
            }

            return true;
        }else
        {
            return false;
        }
    }

    public function load($userId)
    {
        global $sDB, $sSession;

        $res = $sDB->exec("SELECT * FROM `users` WHERE `userId` = '".i($userId)."' LIMIT 1;");
        if(!mysql_num_rows($res))
        {
            return false;
        }
        $row = mysql_fetch_object($res);

        $this->userId           = $userId;
        $this->userName         = $row->userName;
        $this->email            = $row->email;
        $this->password         = $row->password;
        $this->salt             = $row->salt;
        $this->dateAdded        = $row->dateAdded;
        $this->scoreQuestions   = $row->scoreQuestions;
        $this->scoreArguments   = $row->scoreArguments;
        $this->group            = $row->group;

        if($userId == $sSession->getVal('userId'))
        {
            $this->isLoggedIn = true;
        }

        return true;
    }

    public function login($password, $forceLogin = false)
    {
        global $sSession;

        if(!$this->userId)
        {
            return false;
        }

        $passwordHash = crypt($password, '$6$rounds=5000$'.$this->salt.'$');

        if($passwordHash == $this->password || $forceLogin)
        {
            $this->isLoggedIn = true;
            $sSession->setVal('userId', $this->userId);

            return true;
        }

        return false;
    }

    public function isLoggedIn()
    {
        return $this->isLoggedIn;
    }

    public function getSignupDate()
    {
        return date("d.m.Y", $this->dateAdded);
    }

    public function getUserName()
    {
        if(POSTS_ANON)
        {
            return "XXXXX";
        }
        return $this->userName;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getFactionByQuestionId($questionId)
    {
        global $sDB;

        $res = $sDB->exec("SELECT * FROM `user_factions` WHERE `userId` = '".i($this->getUserId())."' AND `questionId` = '".i($questionId)."' LIMIT 1;");
        while($row = mysql_fetch_object($res))
        {
            return $row->state;
        }

        return FACTION_NONE;
    }

    public function setFactionByQuestionId($questionId, $faction)
    {
        global $sDB, $sStatistics;

        if($this->getFactionByQuestionId($questionId) == $faction)
        {
            return;
        }

        $sDB->exec("DELETE FROM `user_factions` WHERE `userId` = '".$this->getUserId()."' AND `questionId` = '".i($questionId)."';");

        $res = $sDB->exec("SELECT * FROM `user_votes` WHERE `userId` = '".i($this->getUserId())."' AND `questionId` = '".i($questionId)."' AND `argumentId` != 0;");
        while($row = mysql_fetch_object($res))
        {
            $sStatistics->vote($questionId, $row->argumentId, VOTE_NONE, $this, true);
        }

        if($faction == FACTION_NONE)
        {
            return;
        }

        $sDB->exec("INSERT INTO `user_factions` (`factionId`, `userId`, `questionId`, `state`) VALUES
                                                (NULL, '".i($this->getUserId())."', '".i($questionId)."', '".i($faction)."');");
    }

    public function getScoreQuestions()
    {
        return $this->scoreQuestions;
    }

    public function getScoreArguments()
    {
        return $this->scoreArguments;
    }

    public function getVoteState($questionId, $argumentId)
    {
        global $sDB;
        if(!$this->userId)
        {
            return VOTE_NONE;
        }

        if(!$this->voteData)
        {
            $this->voteData = Array();

            $res = $sDB->exec("SELECT * FROM `user_votes` WHERE `userId` = '".i($this->userId)."';");
            while($row = mysql_fetch_object($res))
            {
                if(!@is_array($this->voteData[$row->questionId]))
                {
                    $this->voteData[$row->questionId] = Array();
                }
                $this->voteData[$row->questionId][$row->argumentId] = $row->vote;
            }
        }

        if(@is_array($this->voteData[$questionId]))
        {
            if(@$this->voteData[$questionId][$argumentId])
            {
                return $this->voteData[$questionId][$argumentId];
            }
        }

        return VOTE_NONE;
    }

    public function recentQuestions($limit = 3)
    {
        global $sDB;

        $ret = Array();

        $res = $sDB->exec("SELECT * FROM `questions` WHERE `userId` = '".i($this->userId)."' LIMIT ".i($limit).";");
        while($row = mysql_fetch_object($res))
        {
            $q = new Question($row->questionId, $row);
            array_push($ret, $q);
        }

        return $ret;
    }

    public function recentArguments($limit = 3)
    {
        global $sDB;

        $ret = Array();

        $res = $sDB->exec("SELECT * FROM `arguments` WHERE `userId` = '".i($this->userId)."' LIMIT ".i($limit).";");
        while($row = mysql_fetch_object($res))
        {
            $a = new Argument($row->argumentId, $row);
            array_push($ret, $a);
        }

        return $ret;
    }

    public function setPassword($old, $new, $forceUpdate = false)
    {
        global $sDB;

        $passwordHash    = crypt($old, '$6$rounds=5000$'.$this->salt.'$');
        $passwordHashNew = crypt($new, '$6$rounds=5000$'.$this->salt.'$');

        if($passwordHash == $this->password || $forceUpdate)
        {
            $this->password = $passwordHashNew;

            $sDB->exec("UPDATE `users` SET `password` = '".mysql_real_escape_string($passwordHashNew)."' WHERE `userId` = '".i($this->userId)."' LIMIT 1;");

            return true;
        }

        return false;
    }

    public function setUserGroup($group)
    {
        global $sDB;

        $sDB->exec("UPDATE `users` SET `group` = '".i($group)."' WHERE `userId` = '".i($this->userId)."' LIMIT 1;");
        return true;
    }

    public function group()
    {
        return $this->group;
    }

    public function url()
    {
        global $sTemplate;

        return $sTemplate->getProfileLink($this->userId);
    }

    public function shortUrl()
    {
        global $sTemplate;

        $id = new BaseConvert($this->userId);

        return $sTemplate->getShortUrlBase()."u".$id->val();
    }

    public function addConfirmationCode($type, $code)
    {
        global $sDB;

        $sDB->exec("DELETE FROM `confirmation_codes` WHERE `userId` = '".i($this->userId)."' AND `type` = '".mysql_real_escape_string($type)."' LIMIT 1;");
        $sDB->exec("INSERT INTO `confirmation_codes` (`confirmationId`, `userId`, `type`, `code`, `dateAdded`)
                    VALUES (NULL, '".i($this->userId)."', '".mysql_real_escape_string($type)."', '".mysql_real_escape_string($code)."', '".time()."');");
    }

    public function reqPass()
    {
        global $sTemplate;

        $confirmationCode = md5(time());
        $confirmationLink = $sTemplate->getRoot()."confirmation.php?userId=".$this->userId."&confirmationCode=".$confirmationCode;
        $confirmationLink = "<a href = '".$confirmationLink."'>".$confirmationLink."</a>";

        $this->addConfirmationCode("CONFIRMATION_TYPE_PASS_REQUEST", $confirmationCode);

        $subject = $sTemplate->getString("ACCOUNT_FORGOT_PASSWORD_EMAIL_HEADER_STEP1");
        $message = $sTemplate->getString("ACCOUNT_FORGOT_PASSWORD_EMAIL_BODY_STEP1",
                                         Array("[NEW_PASS_CONFIRM_LINK]"),
                                         Array($confirmationLink));

        $mail = new HTMLMail($this->email, $this->email, SENDMAIL_FROM_NAME, SENDMAIL_FROM);
        $mail->buildMessage($subject, $message);
        $mail->sendmail();
    }

    public function reqPassStep2()
    {
        global $sDB, $sTemplate;

        $password = generatePassword();
        $this->setPassword('', $password, true);

        $subject = $sTemplate->getString("ACCOUNT_FORGOT_PASSWORD_EMAIL_HEADER_STEP2");
        $message = $sTemplate->getString("ACCOUNT_FORGOT_PASSWORD_EMAIL_BODY_STEP2",
                                         Array('[PASSWORD]'),
                                         Array($password));

        $mail = new HTMLMail($this->email, $this->email, SENDMAIL_FROM_NAME, SENDMAIL_FROM);
        $mail->buildMessage($subject, $message);
        $mail->sendmail();
    }

    private $isLoggedIn;
    private $userId;
    private $userName;
    private $email;
    private $password;
    private $salt;
    private $dateAdded;
    private $group;

    private $voteData;
    private $scoreQuestions;
    private $scoreArguments;
};
?>