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

class SessionMgr
{
    public function SessionMgr()
    {
        $this->m_hasCalledSetVal = false;
        $this->m_sessionInitialized = false;

        $this->init();
    }

    /*
    * Init Session Mgr
    */
    public function init()
    {
        global $sDB;
        global $sMD;

        // check for session key
        if(@$_COOKIE["wikiargument_session"])
        {
            $this->m_sessionID = mysql_real_escape_string($_COOKIE["wikiargument_session"]);
        }else
        {
            $this->m_sessionID = md5('DATA'.mt_rand().time().$_SERVER['REMOTE_ADDR'].'SID'.mt_rand());
            setcookie("wikiargument_session", $this->m_sessionID, time() + 60*60*24*30, "/");
        }

        // try memcached
        $this->m_sessionData = $sMD->get('session', '', $this->m_sessionID);
        if($this->m_sessionData != false && is_array($this->m_sessionData))
        {
        }else // memcached miss, try mysql
        {
            $res = $sDB->exec("SELECT * FROM `sessions` WHERE `sessionId` = '".mysql_real_escape_string($this->m_sessionID)."' LIMIT 1;");
            if(mysql_num_rows($res))
            {
                $row = mysql_fetch_object($res);
                $this->m_sessionData = unserialize($row->sessionData);
                $sMD->set('session', '', $this->m_sessionID, $this->m_sessionData);
            }else
            {
                $this->m_sessionData = Array();
                $this->m_sessionData['storageData'] = Array();
                $this->m_sessionData['storageData']['lastSQLSync'] = 0;
                $this->m_sessionData['data'] = Array();
                $this->m_sessionData['data']['lastAction'] = time();
            }
        }

        $this->m_sessionInitialized = true;
    }

    /*
    * Serialize Session Mgr
    * writes to sql if either forced or sync interval expired
    */
    public function serialize($forceSQLSync = true)
    {
        $this->m_sessionData['data']['lastAction'] = time();
        if(!$this->m_hasCalledSetVal) return;
        global $sDB;
        global $sMD;

        if($forceSQLSync || abs($this->m_sessionData['storageData']['lastSQLSync'] - time()) > SESSION_SYNC_INTERVAL)
        {
            $this->m_sessionData['storageData']['lastSQLSync'] = time();

            $sDB->exec("INSERT INTO `sessions` (`sessionId`, `sessionData`, `sessionDate`)
                        VALUES ('".mysql_real_escape_string($this->m_sessionID)."', '".mysql_real_escape_string(serialize($this->m_sessionData))."', '".time()."')
                        ON DUPLICATE KEY UPDATE sessionData = '".mysql_real_escape_string(serialize($this->m_sessionData))."', sessionDate = '".time()."';");
        }
        $sMD->set('session', '', $this->m_sessionID, $this->m_sessionData);
    }

    /*
    * read from Session Object
    */
    public function getVal($key)
    {
        if(!$this->m_sessionInitialized) $this->init();
        return @$this->m_sessionData['data'][$key];
    }

    /*
    * write to Session Object
    */
    public function setVal($key, $val)
    {
        if(!$this->m_sessionInitialized) $this->init();
        $this->m_sessionData['data'][$key] = $val;
        $this->m_hasCalledSetVal = true;
    }

    /*
    * get Session ID
    */
    public function getId()
    {
        return $this->m_sessionID;
    }

    public function getData()
    {
        return $this->m_sessionData;
    }

    private $m_sessionData;
    private $m_sessionID;
    private $m_hasCalledSetVal;
    private $m_sessionInitialized;
}
?>
