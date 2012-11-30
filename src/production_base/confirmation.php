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

include("commonHeaders.php");

$userId           = $sRequest->getInt('userId');
$confirmationCode = $sRequest->getString('confirmationCode');

$user = $sQuery->getUser("userId=".$userId);
if(!$user)
{
    $sSession->setVal('error', $sTemplate->getString("NOTICE_CONFIRMATION_ERROR_INVALID_USER"));
    $sSession->serialize();

    header("Location: ".$sTemplate->getRoot());
    exit;
}

$res = $sDB->exec("SELECT * FROM `confirmation_codes` WHERE `userId` = '".i($userId)."' AND `code` = '".mysql_real_escape_string($confirmationCode)."' LIMIT 1;");

if(mysql_num_rows($res))
{
    $row = mysql_fetch_object($res);
    switch($row->type)
    {
        case 'CONFIRMATION_TYPE_EMAIL':
        {
            $sDB->exec("DELETE FROM `confirmation_codes` WHERE `confirmationId` = '".$row->confirmationId."' LIMIT 1;");

            $user->setUserGroup(USER_GROUP_DEFAULT_CONFIRMED);
            $user->login('', true);

            $sSession->setVal('notification', $sTemplate->getString("NOTICE_CONFIRMATION_SUCCESS"));
            $sSession->serialize();

            header("Location: ".$sTemplate->getRoot());
            exit;
        }break;
        case 'CONFIRMATION_TYPE_PASS_REQUEST':
        {
            $sDB->exec("DELETE FROM `confirmation_codes` WHERE `confirmationId` = '".$row->confirmationId."' LIMIT 1;");

            $user->reqPassStep2();

            $sSession->setVal('notification', $sTemplate->getString("NOTICE_PASS_REQUEST_SUCCESS"));
            $sSession->serialize();

            header("Location: ".$sTemplate->getRoot());
        }break;
        default:
        {
        }break;
    }
}
?>
