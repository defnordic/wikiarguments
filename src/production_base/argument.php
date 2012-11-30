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

class Argument
{
    public function Argument($argumentId, $row = false, $parent = false)
    {
        global $sDB, $sQuery;

        if(!$row)
        {
            $res = $sDB->exec("SELECT * FROM `arguments` WHERE `argumentId` = '".i($argumentId)."' LIMIT 1;");
            $row = mysql_fetch_object($res);
        }

        if(!$row)
        {
            $this->argumentId = -1;
            return;
        }

        $this->argumentId   = $argumentId;
        $this->questionId   = $row->questionId;
        $this->parentId     = $row->parentId;
        $this->parent       = $parent;
        $this->userId       = $row->userId;
        $this->username     = $sQuery->getUsernameById($row->userId);
        $this->headline     = $row->headline;
        $this->abstract     = $row->abstract;
        $this->details      = $row->details;
        $this->dateAdded    = $row->dateAdded;
        $this->type         = $row->type;
        $this->score        = $row->score;
        $this->url          = $row->url;
        $this->timeSince    = timeSinceString($row->dateAdded);

        $this->arguments    = Array();
    }

    public function argumentId()
    {
        return $this->argumentId;
    }

    public function questionId()
    {
        return $this->questionId;
    }

    public function parentId()
    {
        return $this->parentId;
    }

    public function parent()
    {
        global $sQuery;

        if(!$this->parent && $this->parentId())
        {
            $this->parent = $sQuery->getArgumentById($this->parentId());
        }
        return $this->parent;
    }

    public function userId()
    {
        return $this->userId;
    }

    public function headline()
    {
        return htmlspecialchars($this->headline);
    }

    public function abstractText()
    {
        return nl2br(htmlspecialchars($this->abstract));
    }

    public function details()
    {
        return nl2br(htmlspecialchars($this->details));
    }

    public function dateAdded()
    {
        return $this->dateAdded;
    }

    public function arguments($sort = SORT_SCORE)
    {
        $ret = Array();

        foreach($this->arguments as $k => $v)
        {
            array_push($ret, $v);
        }

        if($sort == SORT_SCORE)
        {
            array_sortObjDesc($ret, "score");
        }

        return $ret;
    }

    public function numArguments()
    {
        return count($this->arguments);
    }

    public function addArgument(Argument $a)
    {
        array_push($this->arguments, $a);
    }

    public function type()
    {
        return $this->type;
    }

    public function score()
    {
        return $this->score;
    }

    public function url($basePath)
    {
        $url = $basePath.($this->type() == ARGUMENT_PRO ? "p" : "c")."/".$this->url."/";

        if($this->parentId())
        {
            $url = $basePath.($this->type() == ARGUMENT_PRO ? "p" : "c")."/".$this->parent()->urlPlain()."/ca/".$this->url."/";
        }

        return $url;
    }

    public function urlCounterArguments($basePath)
    {
        return $url = $this->url($basePath)."ca/";
    }

    public function urlNewCounterArgument($basePath)
    {
        $url = $basePath.($this->type() == ARGUMENT_PRO ? "p" : "c")."/".$this->url."/ca/new-argument/";

        return $url;
    }

    public function urlPlain()
    {
        return $this->url;
    }

    public function shortUrl()
    {
        global $sTemplate;

        $id = new BaseConvert($this->argumentId());

        return $sTemplate->getShortUrlBase()."a".$id->val();
    }

    public function shortUrlCA()
    {
        global $sTemplate;

        $id = new BaseConvert($this->argumentId());

        return $sTemplate->getShortUrlBase()."c".$id->val();
    }

    public function timeSince()
    {
        return $this->timeSince;
    }

    public function authorLink()
    {
        global $sTemplate;
        return "<a href = '".$sTemplate->getProfileLink($this->userId)."'>".htmlspecialchars($this->username)."</a>";
    }

    public function author()
    {
        return $this->username;
    }

    private $argumentId;
    private $questionId;
    private $parentId;
    private $parent;
    private $userId;
    private $userName;
    private $headline;
    private $abstract;
    private $details;
    private $dateAdded;
    private $type;
    private $score;
    private $url;

    private $arguments;
};
?>