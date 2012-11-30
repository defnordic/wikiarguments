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

class QueryMgr
{
    function QueryMgr()
    {
        $this->userCache = Array();
    }

    /*
    * Get User Object
    */
    function getUser($query, $forceNoCache = false)
    {
        global $sDB;
        $userId = 0;
        $user   = new User();
        parse_str($query);

        if(@$userName)
        {
            $res = $sDB->exec("SELECT `userId` FROM `users` WHERE `userName` = '".mysql_real_escape_string($userName)."' LIMIT 1;");
            if(mysql_num_rows($res))
            {
                $row = mysql_fetch_object($res);
                $userId = $row->userId;
            }
        }
        if(@$userEmail)
        {
            $res = $sDB->exec("SELECT `userId` FROM `users` WHERE `email` = '".mysql_real_escape_string($userEmail)."' LIMIT 1;");
            if(mysql_num_rows($res))
            {
                $row = mysql_fetch_object($res);
                $userId = $row->userId;
            }
        }

        if($userId)
        {
            foreach($this->userCache as $k => $v)
            {
                if($v->getUserId() == $userId)
                {
                    global $sStatistics;
                    $sStatistics->queryCacheHit();
                    return $v;
                }
            }
            if($user->load($userId))
            {
                array_push($this->userCache, $user);
                global $sStatistics;
                $sStatistics->queryCacheMiss();
                return $user;
            }
        }
        return false;
    }

    /*
    * get Current User
    * returns a user object which is either the currently logged in user or a blank user
    */
    function getCurrentUser()
    {
        global $sSession, $sDB;
        $user = new User();
        $user_id = $sSession->getVal('userId');
        if($user_id && $user_id != 0 && $user_id != "")
        {
            if($sSession->getVal('stayLoggedIn') || $sSession->getVal('lastAction') > (time() - 3600))
            {
                $user->load($user_id);
                if($user->isLoggedIn() && $sSession->getVal('lastAction') < (time() - 600) && !$sSession->getVal('admin_su'))
                {
                    $sDB->exec("UPDATE `users` SET `user_last_action` = '".time()."' WHERE `userId` = '".mysql_real_escape_string($user_id)."' LIMIT 1;");
                    $sSession->setVal('lastAction', time());
                }else if($sSession->getVal('admin_su'))
                {
                    $sSession->setVal('lastAction', time());
                }
            }else
            {
                $sSession->setVal('user_id', 0);
            }
        }

        return $user;
    }

    /*
    * get Username by user_id
    */
    function getUsernameById($userId)
    {
        global $sDB;
        $res = $sDB->exec("SELECT `userName` FROM `users` WHERE `userId` = '".mysql_real_escape_string($userId)."' LIMIT 1;");
        if(mysql_num_rows($res) == 1)
        {
            $row = mysql_fetch_object($res);
            return $row->userName;
        }
        return "";
    }

    public function getArgumentById($argumentId)
    {
        global $sDB;

        $res = $sDB->exec("SELECT * FROM `arguments` WHERE `argumentId` = '".i($argumentId)."' LIMIT 1;");
        while($row = mysql_fetch_object($res))
        {
            $a = new Argument($argumentId, $row);
            return $a;
        }

        return false;
    }

    public function getAuthorById($questionId, $argumentId)
    {
        global $sDB;

        $res;

        if($argumentId)
        {
            $res = $sDB->exec("SELECT `userId` FROM `arguments` WHERE `questionId` = '".i($questionId)."' AND
                                                                      `argumentId` = '".i($argumentId)."' LIMIT 1;");
        }else
        {
            $res = $sDB->exec("SELECT `userId` FROM `questions` WHERE `questionId` = '".i($questionId)."' LIMIT 1;");
        }

        while($row = mysql_fetch_object($res))
        {
            return $row->userId;
        }

        return -1;
    }

    public function getCurrentTags()
    {
        global $sRequest;

        $tags = $sRequest->getString("tags");
        $tags = explode("-", $tags);

        return $tags;
    }

    public function getQuestionById($questionId)
    {
        global $sDB;

        $res = $sDB->exec("SELECT * FROM `questions` WHERE `questionId` = '".i($questionId)."' LIMIT 1;");
        while($row = mysql_fetch_object($res))
        {
            $q = new Question($questionId, $row);
            return $q;
        }

        return false;
    }

    private $userCache;
}
?>