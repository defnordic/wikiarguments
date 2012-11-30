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

/*
* Debugging class for tracking of timing behavior.
*/
class DebugTiming
{
    public function DebugTiming()
    {
        $this->timers      = Array();
        $this->start('global');
    }

    public function start($name)
    {
        if(@!$this->timers[$name])
        {
            $this->timers[$name] = new Timer();
        }

        if($this->timers[$name]->isRunning())
        {
            return false;
        }

        $this->timers[$name]->start();

        return true;
    }

    public function stop($name)
    {
        if(!$this->timers[$name] || !$this->timers[$name]->isRunning())
        {
            return false;
        }

        $this->timers[$name]->stop();
    }

    public function getTimersRaw()
    {
        return $this->timers;
    }

    public function getGlobalRuntime()
    {
        $tm = $this->getTimerByName('global');

        return $tm["time"];
    }

    public function getRuntimeByName($name)
    {
        $tm = $this->getTimerByName($name);

        return $tm["time"];
    }

    public function getTimerByName($name)
    {
        if($name == 'global')
        {
            $this->stop('global');
        }

        $tm = Array();
        $tm["name"]      = $name;
        $tm["time"]      = 0;
        $tm["isRunning"] = -1;

        if(!$this->timers[$name])
        {
            return false;
        }

        $tm["time"]      = $this->timers[$name]->getTimeElapsedMs();
        $tm["isRunning"] = $this->timers[$name]->isRunning() ? 1 : 0;

        if($name == 'global')
        {
            $this->start('global');
        }

        return $tm;
    }

    public function getTimingData()
    {
        $ret = Array();

        $this->stop('global');

        foreach($this->timers as $k => $v)
        {
            $tm = Array();
            $tm["name"]      = $k;
            $tm["time"]      = $v->getTimeElapsedMs();
            $tm["isRunning"] = $v->isRunning() ? 1 : 0;

            array_push($ret, $tm);
        }

        $this->start('global');

        return $ret;
    }

    public function logPerformance($annotation, $requestObj)
    {
        global $sLog;
        $sLog->logMessage(LOG_TYPE_PERFORMANCE,         $this->performanceString($annotation, $requestObj));
        $sLog->logMessage(LOG_TYPE_PERFORMANCE_VERBOSE, $this->performanceStringVerbose($annotation, $requestObj));
    }

    public function performanceString($annotation, $requestObj, $isFinal = true)
    {
        global $sUser, $sTimer, $sDB, $sMD, $sStatistics;

        $slowQuerys = $sDB->getSlowQuerys();

        $msg = $annotation."\n";

        $msg .= sprintf("%20s %d\n", "userId:",             $sUser->getUserId());
        $msg .= sprintf("%20s %d\n", "timeTotal:",          $sTimer->getGlobalRuntime());
        $msg .= sprintf("%20s %d\n", "queryCacheHits:",     $sStatistics->queryCacheHits());
        $msg .= sprintf("%20s %d\n", "queryCacheMisses:",   $sStatistics->queryCacheMisses());
        $msg .= sprintf("%20s %d\n", "memcachedQuerys:",    $sMD->getNumQuerys());
        $msg .= sprintf("%20s %d\n", "memcachedMisses:",    $sMD->getNumMisses());
        $msg .= sprintf("%20s %d\n", "slowQuerys:",         count($slowQuerys));

        $msg .= "---------------TIMERS---------------\n";
        foreach($sTimer->getTimingData() as $k => $v)
        {
            $msg .= sprintf("%20s: %10d\n", $v["name"], $v["time"]);
        }

        $msg .= "---------------REQUEST_OBJECT---------------\n";
        $msg .= serialize($requestObj)."\n";

        if($isFinal)
        {
            $msg .= "------------------------------\n";
        }

        return $msg;
    }

    public function performanceStringVerbose($annotation, $requestObj, $isFinal = true)
    {
        global $sDB;
        $slowQuerys = $sDB->getSlowQuerys();
        $msg        = $this->performanceString($annotation, $requestObj, false);

        $msg .= "---------------SLOW_QUERYS---------------\n";
        foreach($slowQuerys as $k => $q)
        {
            $msg .= serialize($q)."\n";
        }

        /*$msg .= "---------------BACKTRACE---------------\n";

        $msg .= $this->buildBacktrace();*/

        if($isFinal)
        {
            $msg .= "------------------------------\n";
        }

        return $msg;
    }

    public function buildBacktrace()
    {
        $backtrace = debug_backtrace();

        foreach ($backtrace as $bt)
        {
            $args = '';
            foreach ($bt['args'] as $a)
            {
                if (!empty($args))
                {
                    $args .= ', ';
                }
                switch (gettype($a))
                {
                    case 'integer':
                    case 'double':
                    {
                        $args .= $a;
                    }break;
                    case 'string':
                    {
                        $a = substr($a, 0, 64).((strlen($a) > 64) ? '...' : '');
                        $args .= "\"$a\"";
                    }break;
                    case 'array':
                    {
                        $args .= 'Array('.count($a).')';
                    }break;
                    case 'object':
                    {
                        $args .= 'Object('.get_class($a).')';
                    }break;
                    case 'resource':
                    {
                        $args .= 'Resource('.strstr($a, '#').')';
                    }break;
                    case 'boolean':
                    {
                        $args .= $a ? 'True' : 'False';
                    }break;
                    case 'NULL':
                    {
                        $args .= 'Null';
                    }break;
                    default:
                    {
                        $args .= 'Unknown';
                    }
                }
            }

            $line = sprintf("%s%s%s(%s)", $bt['class'], $bt['type'], $bt['function'], $args);
            $line = str_pad($line, 100, " ", STR_PAD_RIGHT)." | ";
            $line .= sprintf("%s:%d\n", $bt['file'], $bt['line']);

            $output .= $line;
        }
        return $output;
    }

    private $timers;
};
?>