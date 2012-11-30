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

class Question
{
    public function Question($questionId, $row = false)
    {
        global $sDB, $sQuery, $sRequest, $sUser, $sStatistics;

        if(!$row)
        {
            $res = $sDB->exec("SELECT * FROM `questions` WHERE `questionId` = '".i($questionId)."' LIMIT 1;");
            $row = mysql_fetch_object($res);
        }

        $this->questionId     = $row->questionId;
        $this->title          = $row->title;
        $this->url            = $row->url;
        $this->details        = $row->details;
        $this->dateAdded      = $row->dateAdded;
        $this->userId         = $row->userId;
        $this->username       = $sQuery->getUsernameById($row->userId);
        $this->score          = $row->score;
        $this->scoreTrending  = $row->scoreTrending;
        $this->scoreTop       = $row->scoreTop;
        $this->additionalData = unserialize($row->additionalData);
        $this->timeSince      = timeSinceString($row->dateAdded);

        $this->arguments = -1;
        $this->tags      = -1;
    }

    public function questionId()
    {
        return $this->questionId;
    }

    public function title()
    {
        return htmlspecialchars($this->title);
    }

    public function details()
    {
        return nl2br(htmlspecialchars($this->details));
    }

    public function dateAdded()
    {
        return $this->dateAdded;
    }

    public function author()
    {
        return htmlspecialchars($this->username);
    }

    public function authorLink()
    {
        global $sTemplate;
        return "<a href = '".$sTemplate->getProfileLink($this->userId)."'>".$this->username."</a>";
    }

    public function authorId()
    {
        return $this->userId;
    }

    public function score()
    {
        return $this->score;
    }

    public function timeSince()
    {
        return $this->timeSince;
    }

    public function url()
    {
        global $sTemplate;
        return $sTemplate->getRoot().$this->url."/";
    }

    public function urlDetails()
    {
        return $this->url()."details/";
    }

    public function urlNewArgument($pro = true)
    {
        if($pro)
        {
            return $this->url()."p/new-argument/";
        }else
        {
            return $this->url()."c/new-argument/";
        }
    }

    public function shortUrl()
    {
        global $sTemplate;

        $id = new BaseConvert($this->questionId());

        return $sTemplate->getShortUrlBase()."q".$id->val();
    }

    public function shortUrlDetails()
    {
        global $sTemplate;

        $id = new BaseConvert($this->questionId());

        return $sTemplate->getShortUrlBase()."d".$id->val();
    }

    public function tags($noQuestion = true)
    {
        global $sDB;

        if($noQuestion)
        {
            return $this->additionalData->tags;
        }

        if($this->tags == -1)
        {
            $this->tags = Array();

            $res = $sDB->exec("SELECT * FROM `tags` WHERE `questionId` = '".i($this->questionId())."';");

            while($row = mysql_fetch_object($res))
            {
                array_push($this->tags, strtolower($row->tag));
            }
        }

        return $this->tags;
    }

    public function arguments($filter = FILTER_NONE, $sort = SORT_SCORE)
    {
        global $sDB;

        if($this->arguments == -1)
        {
            $this->arguments = Array();

            $res = $sDB->exec("SELECT * FROM `arguments` WHERE `questionId` = '".i($this->questionId)."' ORDER BY `parentId` ASC;");
            while($row = mysql_fetch_object($res))
            {
                if($row->parentId)
                {
                    foreach($this->arguments as $k => $v)
                    {
                        if($v->argumentId() == $row->parentId)
                        {
                            $a = new Argument($row->argumentId, $row, $v);
                            $v->addArgument($a);
                        }
                    }
                }else
                {

                    $a = new Argument($row->argumentId, $row);
                    array_push($this->arguments, $a);
                }
            }
        }

        $ret = Array();

        if($filter == FILTER_PRO)
        {
            foreach($this->arguments as $k => $v)
            {
                if($v->type() == ARGUMENT_PRO)
                {
                    array_push($ret, $v);
                }
            }
        }else if($filter == FILTER_CON)
        {
            foreach($this->arguments as $k => $v)
            {
                if($v->type() == ARGUMENT_CON)
                {
                    array_push($ret, $v);
                }
            }
        }else
        {
            $ret = $this->arguments;
        }

        if($sort == SORT_SCORE)
        {
            array_sortObjDesc($ret, "score");
        }

        return $ret;
    }

    public function percPro()
    {
        return $this->additionalData->percPro;
    }

    public function percCon()
    {
        return $this->additionalData->percCon;
    }

    public function numCheckIns()
    {
        return $this->additionalData->numCheckIns;
    }

    public function numArguments()
    {
        $num = count($this->arguments());

        foreach($this->arguments() as $k => $v)
        {
            $num += $v->numArguments();
        }

        return $num;
    }

    private $questionId;
    private $title;
    private $details;
    private $dateAdded;
    private $userId;
    private $username;
    private $score;
    private $timeSince;
    private $additionalData;

    private $percPro;
    private $percCon;
    private $numCheckIns;

    private $arguments;
    private $tags;
};
?>
