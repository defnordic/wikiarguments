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

include("./commonHeaders.php");
header("Content-Type: text/javascript");
?>
function _Wikiarguments()
{
};

_Wikiarguments.prototype.raiseError = function(msg, callback)
{
    this.raiseNotice(msg, callback);
};

_Wikiarguments.prototype.raiseNotice = function(msg, callback)
{

    var notice = jQuery("<div></div>");
    notice.addClass('notice');

    var title = jQuery("<div></div>");
    title.addClass('notice_title');
    title.html(msg);

    var response = jQuery("<div></div>");

    var okay = jQuery("<div></div>");
    okay.addClass("notice_okay");
    okay.bind('click', function(){ jQuery.fancynotification.close(); });

    response.append(okay);
    notice.append(title);
    notice.append(response);

    notice.dialog({bgiframe: true,
                   modal: true,
                   resizable:false,
                   draggable:false,
                   width:400,
                   buttons:
                   {
                       Close: function()
                       {
                           $(this).dialog('close');
                       }
                   },
                   create: function (event, ui)
                   {
                       $(".ui-dialog-buttonset button").attr("class","button_orange");
                   },
                  });
    return;
};

_Wikiarguments.prototype.submitArgument = function(formId)
{
    var headline = $('#new_argument_headline').val();
    var abstract = $('#new_argument_abstract').val();

    if(headline == "")
    {
        this.raiseError('<? echo $sTemplate->getString("ERROR_NEW_ARGUMENT_MISSING_HEADLINE"); ?>');
        return false;
    }else if(abstract == "")
    {
        this.raiseError('<? echo $sTemplate->getString("ERROR_NEW_ARGUMENT_MISSING_ABSTRACT"); ?>');
        return false;
    }

    $(formId).submit();
    return true;
};

_Wikiarguments.prototype.submitSearch = function(sort)
{
    var query = $('#navi_search').val();
    //query = query.replace(" ", "-");

    var root  = '<? echo $sTemplate->getRoot(); ?>';
    var url   = "";

    if(sort == <? echo SORT_TOP; ?>)
    {
        url = root + "tags/trending/" + query + "/";
    }else if(sort == <? echo SORT_NEWEST; ?>)
    {
        url = root + "tags/top/" + query + "/";
    }else
    {
        url = root + "tags/newest/" + query + "/";
    }

    window.location = url;

    return false;
};

_Wikiarguments.prototype.passRequest = function()
{
    var username = $('#login_username').val();

    if(!username)
    {
        this.raiseError('<? echo $sTemplate->getString("ERROR_PASS_REQUEST_MISSING_USERNAME"); ?>');
        return false;
    }

    $('#login_mode_passRequest').val(1);
    $('#login_mode_login').val(0);

    $('#form_login').submit();

    return false;
};