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

class SqlMgr
{
    function SqlMgr()
    {
        $this->link = NULL;
        $this->res = NULL;
        $this->slowQuerys = Array();

        $this->init();
    }

    /*
     * connect to mysql database
    */
    function init()
    {
        $this->link = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
        if (!$this->link) {
            die("SQL Error : " . mysql_error());
        }
        if(mysql_select_db(MYSQL_NAME, $this->link) == false)
        {
            die ("SQL Error : " . mysql_error());
        }
        $this->curDB = MYSQL_NAME;
        $this->exec('set character set utf8;');
    }

    /*
     * close mysql link
    */
    function destroy()
    {
        mysql_close($this->link);
    }

    /*
    * Check Query String for possible injections
    */
    public function check_injections($qry)
    {
        //remove all escaped escape characters
        $withoutquotewords = str_replace("\\\\", "", $qry);
        $withoutquotewords = preg_replace("/\\\\[\W\w]/", "", $withoutquotewords);
        // remove all quoted strings
        $withoutquotewords = preg_replace("/'([^']*)'/", "", $withoutquotewords);
        $withoutquotewords = preg_replace("/\"([^']*)\"/", "", $withoutquotewords);
        //scan the mysql commands for badwords
        foreach($this->blacklist as $blacklisted)
        {
            if(stristr($withoutquotewords, $blacklisted))
            {
                try
                {
                    global $sLog;
                    $sLog->logMessage(LOG_TYPE_SQL, "SQL_INJECTION: ".$qry);
                }catch(Exception $e)
                {
                }
                return false;
            }
        }

        return false;
    }

    /*
     * execute mysql query
    */
    function exec($qry)
    {
        $tm = new Timer();
        $tm->start();
        if($this->check_injections($qry)) return NULL;
        $this->res = mysql_query($qry);
        if($this->res == NULL)
        {
            try
            {
                global $sLog;
                $sLog->logMessage(LOG_TYPE_SQL, "SQL_ERROR[".mysql_error()."]: ".$qry);
            }catch(Exception $e)
            {
            }
            return false;
        }

        $tm->stop();
        if($tm->getTimeElapsedMs() > DEBUG_TIMING_SLOW_QUERY_TIME)
        {
            $slow_query = new SlowQuery($qry, $tm);
            array_push($this->slowQuerys, $slow_query);
        }

        return $this->res;
    }

    /*
    * select query wrapper
    * @table: table to be queried
    * @whichData: fieldnames e.g. array('field1', 'field2')
    * @whereData: where clause as assoc array: array('field1' => 'val1', 'field2' => 'val2')
    * @orderData: order data as assoc array: array('field1' => 'DESC', 'field2' => 'ASC');
    * @offset: Offset for Limit
    * @limit: Number of Rows to be queried
    */
    public function select($table, $whichData, $whereData, $orderData = '', $offset = 0, $limit = 0)
    {
        if(!is_array($whereData)) return NULL; //only arrays allowed for whereData
        $which = $where = $order = '';
        if(is_array($whichData))
        {
            foreach($whichData as $key => $val)
            {
                $which .= '`'.$val.'`'.',';
            }
            $which = rtrim($which, ',');
        }else {
            $which = $whichData;
        }

        foreach($whereData as $key => $val)
        {
            $where .= ' `'.$key.'`='.(is_int($val) ? i($val) : '\''.a($val).'\'').' AND';
        }
        if(strlen($where) > 0) $where = substr($where, 0, -4); //strip ' AND' at the end

        if(is_array($orderData))
        {
            $order = ' ORDER BY ';
            foreach($orderData as $key => $val)
            {
                $order .= '`'.$key.'`'.' '.$val.',';
            }
            $order = rtrim($order, ',');
        }else if($orderData != '')
        {
            $order = ' ORDER BY `'.$orderData.'`';
        }

        $qry = 'SELECT '.$which.' FROM `'.$table.'` WHERE '.$where.$order.(($maxLimit > 0) ? ' LIMIT '.$maxLimit : '');
        return $this->exec($qry);
    }

    /*
    * update query wrapper
    * @table: table to be updated
    * @updateFields: fields to be updated e.g. array('field1' => 'val1', 'field2' => 'val2')
    * @conditions: conditions as string e.g. "field1 = 2 AND field3 > 0"
    */
    public function update($table, $updateData, $conditions = '', $limit = 0)
    {
            $upcmd = "UPDATE `".$table."` SET ";
            if(is_array($updateData))
            {
                foreach($updateData as $col=>$val)
                {
                    $upcmd .= is_int($val) ? '`'.$col."`=".$val."," : '`'.$col."`='".a($val)."',";
                }
                $upcmd = rtrim($upcmd, ',');
            }
            else
            {
                $upcmd .= $updatefields;
            }

            if($conditions != '') $upcmd .= " WHERE ".$conditions;
            return $this->exec($upcmd);
        }

    /*
     * return last Mysql Query result
    */
    function getLastResult()
    {
        return $this->res;
    }

    function &getSlowQuerys()
    {
        return $this->slowQuerys;
    }

    private $link;
    private $res;
    private $curDB;
    private $blacklist = array('union', '/*', '#', '--', 'concat', 'drop', 'outfile', 'dumpfile', 'load_file');
    private $slowQuerys;
}

class SlowQuery
{
    public function SlowQuery($qry, $tm)
    {
        $this->qry = $qry;
        $this->tm = $tm;
        $this->timeElapsedMs = $tm->getTimeElapsedMs();
    }

    public $qry;
    public $tm;
    public $timeElapsedMs;
}
?>
