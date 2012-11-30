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

class PageCounterArgumentFull extends Page
{
    public function PageCounterArgumentFull($row)
    {
        global $sDB, $sRequest, $sStatistics, $sTemplate;
        parent::Page($row);

        $questionTitle  = $sRequest->getString("title");
        $this->question = false;
        $this->view     = VIEW_ARGUMENT;
        $argumentTitle  = $sRequest->getString("counterArgument");
        $this->argument = false;

        if($sRequest->getInt("vote_select"))
        {
            $vote       = $sRequest->getInt("vote");
            $questionId = $sRequest->getInt("questionId");
            $argumentId = $sRequest->getInt("argumentId");
            $sStatistics->vote($questionId, $argumentId, $vote);
        }

        $res = $sDB->exec("SELECT * FROM `questions` WHERE `url` = '".mysql_real_escape_string($questionTitle)."' LIMIT 1;");
        while($row = mysql_fetch_object($res))
        {
            $this->question = new Question($row->questionId, $row);
        }

        if(!$this->question)
        {
            $sTemplate->error($sTemplate->getString("ERROR_INVALID_ARGUMENT"));
        }

        foreach($this->question->arguments() as $k => $v)
        {
            foreach($v->arguments() as $k1 => $v1)
            {
                if($v1->urlPlain() == $argumentTitle)
                {
                    $this->argument = $v1;
                    break;
                }
            }
            if($this->argument)
            {
                break;
            }
        }

        if(!$this->argument)
        {
            $sTemplate->error($sTemplate->getString("ERROR_INVALID_ARGUMENT"));
        }

        $this->setShortUrl($this->argument->shortUrl());
    }

    public function getQuestion()
    {
        return $this->question;
    }

    public function getView()
    {
        return $this->view;
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

    public function title()
    {
        global $sTemplate;
        return $sTemplate->getString("HTML_META_TITLE_ARGUMENT",
                                     Array("[ARGUMENT]"),
                                     Array($this->argument->headline()));
    }

    private $question;
    private $argument;
    private $view;
};
?>