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

global $sTemplate, $sUser, $sDB, $sPacket, $sPage, $sPermissions;

$page       = "";
$language   = $sTemplate->getLangBase();
?>
<? include($sTemplate->getTemplateRootAbs()."header.php"); ?>

<div id = "content_wide">
  <div class = "thin">
<?
drawArgumentBoxExtended($sPage->getQuestion(), $sPage->getView(), $sPage->basePath(), $sPage->getArgument());
?>
  </div>

  <div class = 'argument_container'>
<?
echo drawCounterArguments($sPage->getArgument(), $sPage->basePath());
?>

<?
$onClick = "";
if(!$sUser->isLoggedIn())
{
    $onClick = "wikiarguments.raiseError(\"".$sTemplate->getString("NOTICE_NEW_ARGUMENT_NOT_LOGGED_IN")."\"); return false;";
}else if($sPermissions->getPermission($sUser, ACTION_NEW_COUNTER_ARGUMENT) == PERMISSION_DISALLOWED)
{
    $onClick = "wikiarguments.raiseError(\"".$sTemplate->getString("NOTICE_NEW_COUNTER_ARGUMENT_NO_PERMISSION")."\"); return false;";
}
?>
    <a class="add-new-argument" href = "<? echo $sPage->getArgument()->urlNewCounterArgument($sPage->basePath()); ?>" onclick = '<? echo $onClick; ?>'>
      <div class = "button_argument button_new_counter_argument">
        <span><? echo $sTemplate->getString("NEW_COUNTER_ARGUMENT"); ?></span>
      </div>
    </a>
  </div>

</div>

<? include($sTemplate->getTemplateRootAbs()."footer.php"); ?>
