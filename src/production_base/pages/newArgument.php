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

class PageNewArgument extends Page
{
    public function PageNewArgument($row)
    {
        global $sDB, $sRequest, $sTemplate;
        parent::Page($row);

        $questionTitle  = $sRequest->getString("title");
        $this->question = false;
        $this->view     = VIEW_NEW_ARGUMENT;
        $this->faction  = $sRequest->getInt("faction");
        validateFaction($this->faction);

        $res = $sDB->exec("SELECT * FROM `questions` WHERE `url` = '".mysql_real_escape_string($questionTitle)."' LIMIT 1;");
        while($row = mysql_fetch_object($res))
        {
            $this->question = new Question($row->questionId, $row);
        }

        if(!$this->question)
        {
            $sTemplate->error($sTemplate->getString("ERROR_INVALID_QUESTION"));
        }

        if($sRequest->getInt("new_argument"))
        {
            if($this->handleNewArgument())
            {
                header("Location: ".$this->redirectUrl);
                exit;
            }
        }
    }

    public function getQuestion()
    {
        return $this->question;
    }

    public function getView()
    {
        return $this->view;
    }

    public function canView()
    {
        global $sUser, $sTemplate, $sPermissions;

        if(!$this->question)
        {
            $this->setError($sTemplate->getString("ERROR_INVALID_QUESTION"));
            return false;
        }

        if(!$sUser->isLoggedIn())
        {
            $this->setError($sTemplate->getString("ERROR_NOT_LOGGED_IN"));
            return false;
        }

        if($sPermissions->getPermission($sUser, ACTION_NEW_ARGUMENT) == PERMISSION_DISALLOWED)
        {
            $this->setError($sTemplate->getString("ERROR_NO_PERMISSION"));
            return false;
        }

        return true;
    }

    public function basePath()
    {
        global $sTemplate;

        $path = $this->question->url();

        return $path;
    }

    public function getArgument()
    {
        return $this->argument;
    }

    public function handleNewArgument()
    {
        global $sRequest, $sTemplate, $sUser, $sPermissions;

        if(!$sUser->isLoggedIn() || $sPermissions->getPermission($sUser, ACTION_NEW_ARGUMENT) == PERMISSION_DISALLOWED)
        {
            return false;
        }

        $headline       = $sRequest->getStringPlain("new_argument_headline");
        $headlineParsed = preg_replace("/[^0-9a-zÄÖÜäöüáàâéèêíìîóòôúùû\[\]\{\} -]/i", "", $headline);

        $abstract = $sRequest->getStringPlain("new_argument_abstract");
        $abstract = mb_substr($abstract, 0, MAX_ARGUMENT_ABS_CHR_LENGTH, 'utf-8');

        $details  = $sRequest->getStringPlain("new_argument_details");

        if($headline != "" && $abstract && $headlineParsed != "")
        {
            return $this->store($headline, $headlineParsed, $abstract, $details);
        }

        if($headlineParsed == "")
        {
            $this->setError($sTemplate->getString("ERROR_NEW_ARGUMENT_MISSING_HEADLINE"));
        }else if ($abstract == "")
        {
            $this->setError($sTemplate->getString("ERROR_NEW_ARGUMENT_MISSING_ABSTRACT"));
        }else if ($details == "")
        {
            $this->setError($sTemplate->getString("ERROR_NEW_ARGUMENT_MISSING_DETAILS"));
        }else
        {
            $this->setError($sTemplate->getString("ERROR_NEW_ARGUMENT_TRY_AGAIN"));
        }

        return false;
    }

    private function store($headline, $headlineParsed, $abstract, $details)
    {
        global $sDB, $sUser;

        $questionId = $this->question->questionId();

        $url = url_sanitize($headlineParsed);

        $i = 0;
        while(true)
        {
            $cur = $url.($i > 0 ? '-'.$i : '');
            $res = $sDB->exec("SELECT `url` FROM `arguments` WHERE `questionId` = '".i($questionId)."' AND `parentId` = '0' AND `url` = '".mysql_real_escape_string($cur)."' LIMIT 1;");

            if(mysql_num_rows($res))
            {
                $i++;
                continue;
            }

            break;
        }

        if($i > 0)
        {
            $url .= '-'.$i;
        }

        $sDB->exec("INSERT INTO `arguments` (`argumentId`, `questionId`, `parentId`, `type`, `userId`, `url`, `headline`, `abstract`, `details`, `dateAdded`, `score`) VALUES
                                            (NULL, '".i($questionId)."', '0', '".i($this->faction)."', '".i($sUser->getUserId())."','".mysql_real_escape_string($url)."',
                                            '".mysql_real_escape_string($headline)."', '".mysql_real_escape_string($abstract)."', '".mysql_real_escape_string($details)."',
                                            '".time()."', '0');");

        $argumentId = mysql_insert_id();

        if(!$argumentId)
        {
            $this->setError($sTemplate->getString("ERROR_NEW_ARGUMENT_TRY_AGAIN"));
            return false;
        }

        $this->redirectUrl = $this->question->url();

        return $argumentId;
    }

    public function title()
    {
        global $sTemplate;
        return $sTemplate->getString("HTML_META_TITLE_NEW_ARGUMENT");
    }

    private $question;
    private $argument;
    private $view;
    private $redirectUrl;
    private $faction;
};
?>
