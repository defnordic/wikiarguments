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

global $sTemplate, $sUser, $sDB, $sPacket, $sPage;

$page       = "";
$language   = $sTemplate->getLangBase();
?>
<? include($sTemplate->getTemplateRootAbs()."header.php"); ?>

<div id = "content">

<?
if(count($sPage->getTags()) > 0)
{
?>

<div class = "filter">
  <? echo $sTemplate->getString("TAGS_FILTER", Array("[TAGS]"), Array($sPage->getTagsString())); ?>
  <div class = "remove">
    <a href = '<? echo $sPage->basePathNoFilter(); ?>'>
      <span><? echo $sTemplate->getString("TAGS_FILTER_REMOVE"); ?></span>
      <div class = "remove_icon"></div>
    </a>
  </div>
</div>

<?
}
?>

<? foreach($sPage->getQuestions() as $k => $v)
{
    drawQuestionBox($v);
}
?>

<? if(!$sUser->isLoggedIn()) { ?>
<a href = '<? echo $sTemplate->getRoot(); ?>new-question/' onclick = "wikiarguments.raiseError('<? echo $sTemplate->getString("ERROR_NOT_LOGGED_IN") ?>'); return false;">
  <button class = 'button_orange button_new_question'><? echo $sTemplate->getString("NEW_QUESTION"); ?></button>
</a>
<? }else { ?>
<a href = '<? echo $sTemplate->getRoot(); ?>new-question/'>
  <div class = 'button_orange button_new_question'><? echo $sTemplate->getString("NEW_QUESTION"); ?></div>
</a>
<? } ?>

<?
if(count($sPage->getTags()) > 0)
{
    drawPagination($sPage->getPage(), $sPage->numPages(), 5, $sPage->basePath(), "pagination_questions");
}else
{
    drawPagination($sPage->getPage(), $sPage->numPages(), 5, $sPage->basePathNoFilter(), "pagination_questions");
}
?>

</div>

<? include($sTemplate->getTemplateRootAbs()."footer.php"); ?>
