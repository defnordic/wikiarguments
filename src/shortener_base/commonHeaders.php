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

include("../production_base/etc/config.php");
include("../production_base/etc/constants.php");
include("../production_base/etc/opcodes.php");
include("../production_base/etc/common.php");
include("../production_base/functions.php");
include("../production_base/sqlMgr.php");
include("../production_base/memcachedMgr.php");
include("../production_base/templateMgr.php");
include("../production_base/queryMgr.php");
include("../production_base/statisticsMgr.php");
include("../production_base/user.php");
include("../production_base/sessionMgr.php");
include("../production_base/logMgr.php");
include("../production_base/notificationMgr.php");
include("../production_base/debugTiming.php");
include("../production_base/debug.php");
include("../production_base/question.php");
include("../production_base/argument.php");

mt_srand(time());

$sRequest     = new Request();

$sTimer       = new DebugTiming();
$sTimer->start('init');

$sDebug       = new Debug();

$sLog         = new LogMgr();

$sNotify      = new NotificationMgr();

$sDB          = new SqlMgr();

$sMD          = new MemcachedMgr();

$sQuery       = new QueryMgr();

$sSession     = new SessionMgr();

$sTemplate    = new TemplateMgr();
$sTemplate->getLocale();

$sStatistics  = new StatisticsMgr();

$sUser        = $sQuery->getCurrentUser();

/*if($sUser->getUserLevel >= USER_LEVEL_ADMIN)
{
    error_reporting(E_ALL ^ E_NOTICE);
}*/

$sTimer->stop('init');
?>
