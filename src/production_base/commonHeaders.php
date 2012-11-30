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

include("./etc/config.php");
include("./etc/constants.php");
include("./etc/opcodes.php");
include("./etc/common.php");
include("./functions.php");
include("./sqlMgr.php");
include("./memcachedMgr.php");
include("./templateMgr.php");
include("./queryMgr.php");
include("./statisticsMgr.php");
include("./permissionsMgr.php");
include("./user.php");
include("./sessionMgr.php");
include("./logMgr.php");
include("./notificationMgr.php");
include("./debugTiming.php");
include("./debug.php");
include("./question.php");
include("./argument.php");
include("./mail.php");

// packet handlers
include("./packets/general.php");

// page modules
include("./pages/page.php");
include("./pages/default.php");
include("./pages/question.php");
include("./pages/argument.php");
include("./pages/counterArgument.php");
include("./pages/counterArgumentFull.php");
include("./pages/newArgument.php");
include("./pages/newCounterArgument.php");
include("./pages/newQuestion.php");
include("./pages/signup.php");
include("./pages/logout.php");
include("./pages/error.php");
include("./pages/profile.php");
include("./pages/manageProfile.php");
include("./pages/imprint.php");

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

$sPermissions = new PermissionsMgr();

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
