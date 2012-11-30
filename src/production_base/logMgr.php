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

class LogMgr
{
    public function LogMgr()
    {
        $this->init();
    }

    public function init()
    {
    }

    public function logMessage($type, $message)
    {
        $fhandle;

        $streams = Array(LOG_TYPE_SQL                   => LOG_STREAM_SQL,
                         LOG_TYPE_RIGHTS                => LOG_STREAM_RIGHTS,
                         LOG_TYPE_LANG                  => LOG_STREAM_LANG,
                         LOG_TYPE_SPAM                  => LOG_STREAM_SPAM,
                         LOG_TYPE_MESSAGE_DAEMON        => LOG_STREAM_MESSAGE_DAEMON,
                         LOG_TYPE_ADMIN_PACKET          => LOG_STREAM_ADMIN_PACKET,
                         LOG_TYPE_PERFORMANCE           => LOG_STREAM_PERFORMANCE,
                         LOG_TYPE_PERFORMANCE_VERBOSE   => LOG_STREAM_PERFORMANCE_VERBOSE,
                         LOG_TYPE_DEBUG                 => LOG_STREAM_DEBUG);

        if($streams[$type])
        {
            $fhandle = fopen($streams[$type], "a");
        }

        if(in_array($type, Array(LOG_TYPE_LANG, LOG_TYPE_SPAM)))
        {
            $message = DEFAULT_LANG.": ".$message;
        }

        if($fhandle)
        {
            fwrite($fhandle, "[".date("d.M.Y h:i")."] ".$message."\n");
            fclose($fhandle);
            return true;
        }

        return false;
    }
}
?>
