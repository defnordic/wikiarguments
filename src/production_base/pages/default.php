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

class PageDefault extends Page
{
    public function PageDefault($row)
    {
        global $sDB, $sRequest, $sStatistics;
        parent::Page($row);

        $this->page     = $sRequest->getInt("page");
        $this->numPages = -1;
        $this->tags     = Array();
        $this->sort     = SORT_TRENDING;

        if(in_array($sRequest->getInt("sort"), Array(SORT_TRENDING, SORT_TOP, SORT_NEWEST)))
        {
            $this->sort = $sRequest->getInt("sort");
        }

        $tags = $sRequest->getStringPlain("tags");
        if($tags != "")
        {
            $tags2 = explode(" ", $tags);
            foreach($tags2 as $k => $v)
            {
                array_push($this->tags, $v);
            }
        }

        if($sRequest->getInt("vote_select"))
        {
            $vote       = $sRequest->getInt("vote");
            $questionId = $sRequest->getInt("questionId");
            $argumentId = $sRequest->getInt("argumentId");
            $sStatistics->vote($questionId, $argumentId, $vote);
        }

        $this->questions = Array();
        $res = $sDB->exec($this->buildQuery());
        while($row = mysql_fetch_object($res))
        {
            $q = new Question($row->questionId, $row);
            array_push($this->questions, $q);
        }
    }

    public function title()
    {
        global $sTemplate;

        switch($this->sort)
        {
            case SORT_TRENDING:
            {
                return $sTemplate->getString("HTML_META_TITLE_TRENDING");
            }break;
            case SORT_TOP:
            {
                return $sTemplate->getString("HTML_META_TITLE_TOP");
            }break;
            case SORT_NEWEST:
            {
                return $sTemplate->getString("HTML_META_TITLE_NEWEST");
            }break;
        }

        return $sTemplate->getString("HTML_META_TITLE");
    }

    public function getQuestions()
    {
        return $this->questions;
    }

    public function numPages()
    {
        global $sDB;

        if($this->numPages == -1)
        {
            $res = $sDB->exec($this->buildQuery(true));
            $row = mysql_fetch_object($res);

            $this->numPages = ceil($row->cnt / QUESTIONS_PER_PAGE);
        }


        return $this->numPages;
    }

    private function buildQuery($cnt = false)
    {
        global $sDB;

        $qry = "SELECT ";
        if($cnt)
        {
            $qry .= "count(*) as `cnt`";
        }else
        {
            $qry .= "*";
        }

        $qry .= " FROM `questions`";

        if(count($this->tags))
        {
            $idString  = "";
            $tagString = "";
            foreach($this->tags as $k => $v)
            {
                $tagString .= ", '".mysql_real_escape_string($v)."'";
            }
            $tagString = substr($tagString, 2);

            $res = $sDB->exec("SELECT count(*) as `cnt`, `questionId` FROM `tags` WHERE `tag` IN (".$tagString.") GROUP BY `questionId`;");
            while($row = mysql_fetch_object($res))
            {
                if($row->cnt >= $cnt)
                {
                    $idString .= ", ".$row->questionId;
                }
            }

            if(strlen($idString))
            {
                $idString = substr($idString, 2);
            }else
            {
                $idString = "0";
            }

            $qry .= " WHERE `questionId` IN (".$idString.")";
        }

        switch($this->sort)
        {
            case SORT_TRENDING:
            {
                $qry .= " ORDER BY `scoreTrending` DESC";
            }break;
            case SORT_TOP:
            {
                $qry .= " ORDER BY `scoreTop` DESC";
            }break;
            case SORT_NEWEST:
            {
                $qry .= " ORDER BY `dateAdded` DESC";
            }break;
        }

        if($cnt)
        {

        }else
        {
            $qry .= " LIMIT ".(i($this->page) * QUESTIONS_PER_PAGE).",".QUESTIONS_PER_PAGE.";";
        }

        return $qry;
    }

    public function getSort()
    {
        return $this->sort;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function getTagsString()
    {
        $tags = "";
        foreach($this->tags as $k => $v)
        {
            $tags .= " ".htmlspecialchars($v);
        }

        if(strlen($tags))
        {
            $tags = substr($tags, 1);
        }

        return $tags;
    }

    public function basePath()
    {
        global $sTemplate;

        $path = $sTemplate->getRoot()."tags/trending/";
        if($this->sort == SORT_NEWEST)
        {
            $path = $sTemplate->getRoot()."tags/newest/";
        }else if($this->sort == SORT_TOP)
        {
            $path = $sTemplate->getRoot()."tags/top/";
        }

        if($this->tags)
        {
            foreach($this->tags as $k => $v)
            {
                $path .= ($k != 0 ? "-" : "").$v;
            }

            $path .= "/";
        }

        return $path;
    }

    public function basePathNoFilter()
    {
        global $sTemplate;

        if($this->sort == SORT_NEWEST)
        {
            return $sTemplate->getRoot()."tags/newest/";
        }else if($this->sort == SORT_TOP)
        {
            return $sTemplate->getRoot()."tags/top/";
        }

        return $sTemplate->getRoot();
    }

    public function getPage()
    {
        return $this->page;
    }

    private $tags;
    private $type;
    private $questions;
    private $numPages;
    private $page;
    private $sort;
};
?>