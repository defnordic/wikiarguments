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

class TemplateMgr
{
    function TemplateMgr()
    {
        $this->lang = "";
    }

    /*
    * Get Localiazion from database
    */
    public function getLocale($lang = "")
    {
        if(!in_array($lang, getAvailableLanguages())) $lang = DEFAULT_LANG;
        if($this->lang == $lang)
        {
            return;
        }

        global $sDB;
        $this->lang = $lang;

        if(LANG_USE_CACHE && file_exists($this->getTemplateRootAbs()."lang_".$lang.".php"))
        {
            $langCache = file_get_contents($this->getTemplateRootAbs()."lang_".$lang.".php");
            if(strlen($langCache) > 3)
            {
                $langCache = unserialize(substr($langCache, 3));
                if(is_array($langCache))
                {
                    foreach($langCache as $key => $val)
                    {
                        $this->LANG_SET[$key] = $val;
                    }
                    return;
                }
            }
        }

        // load global language variables e.g. "de" for "deDE"
        $res = $sDB->exec("SELECT * FROM `localization` WHERE `loc_language` = '".mysql_real_escape_string(substr($lang, 0, 2))."';");
        while($row = mysql_fetch_object($res))
        {
            $this->LANG_SET[$row->loc_key] = $row->loc_val;
        }

        // load country specific overrides
        $res = $sDB->exec("SELECT * FROM `localization` WHERE `loc_language` = '".mysql_real_escape_string($lang)."';");
        while($row = mysql_fetch_object($res))
        {
            $this->LANG_SET[$row->loc_key] = $row->loc_val;
        }
    }

    /*
    * get Root Directory
    */
    public function getRoot()
    {
        return SITE_ROOT;
    }

    /*
    * get AJAX URL
    */
    public function getAjaxURL()
    {
        return AJAX_URL;
    }

    public function getShortUrlBase()
    {
        return SHORTURL_BASE;
    }

    /*
    * get Template Root Directory
    */
    public function getTemplateRoot()
    {
        return TEMPLATE_ROOT;
    }

    /*
    * get Template Include Path
    */
    public function getTemplateRootAbs()
    {
        return TEMPLATE_ROOT_ABS;
    }

    public function getStringNumber($key, $search = false, $replace = false, $number = -1)
    {
        switch(i($number))
        {
            case 0:
            {
                $key .= "_NULL";
            }break;
            case 1:
            {
                $key .= "_ONE";
            }break;
            case 2:
            {
                $key .= "_TWO";
            }break;
            default:
            {

            }break;
        }

        return $this->getString($key, $search, $replace);
    }

    /*
    * get Language Variable
    * replace $search with $replace before returning
    */
    public function getString($key, $search = false, $replace = false)
    {
        global $sUser;

        $keys = Array();

        if(POSTS_ANON)
        {
            array_push($keys, $key."_ANON");
        }
        array_push($keys, $key);

        // return the first hit in the localization table
        foreach($keys as $k => $v)
        {
            if(@$this->LANG_SET[$v])
            {
                if(is_array($search))
                {
                    return str_replace($search, $replace, $this->LANG_SET[$v]);
                }
                return $this->LANG_SET[$v];
            }
        }

        global $sLog;
        $sLog->logMessage(LOG_TYPE_LANG, $key);
        return "LANG_VAR_DOES_NOT_EXIST";
    }

    public function isCurrentPage($page)
    {
        global $sPage;
        if($sPage)
        {
            return $sPage->pageTitle() == $page;
        }
        return $sRequest->getString("pageTitle") == $page;
    }

    /*
    * Main Template Loop
    */
    public function run()
    {
        global $sDB, $sUser, $sRequest, $sPage;

        if(!$sPage)
        {
            return;
        }

        $functionsFile = $this->getTemplateRootAbs()."functions.php";
        if(file_exists($functionsFile))
        {
            include($functionsFile);
        }

        $templatefile = $this->getTemplateRootAbs().$sPage->templateFile();

        if(file_exists($templatefile))
        {
            include($templatefile);
        }else
        {
            exception("Incfile: ".$templatefile." does not exist");
        }
    }

    public function getLang()
    {
        return $this->lang;
    }

    public function getLangBase()
    {
        return substr($this->lang, 0, 2);
    }

    public function getCountry()
    {
        return substr($this->lang, 2);
    }

    public function getProfileLink($userId)
    {
        return $this->getRoot()."user/".$userId."/";
    }

    public function error($error)
    {
        global $sSession;

        $sSession->setVal('error', $error);
        $sSession->serialize();
        header("Location: ".$this->getRoot());
        exit;
    }

    private $LANG_SET;
    private $lang;
}
?>
