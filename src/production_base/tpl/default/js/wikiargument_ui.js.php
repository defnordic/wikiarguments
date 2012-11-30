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
$(document).ready(function(){
$("#new_argument_headline").bind("keyup", function(){

$("#argument_headline_chars_left").text(<? echo MAX_ARGUMENT_CHR_LENGTH;?>-$(this).val().length);
});


$("#new_argument_abstract").bind("keyup", function(){

$("#argument_headline_abs_chars_left").text(<? echo MAX_ARGUMENT_ABS_CHR_LENGTH;?>-$(this).val().length);
});

$("#new_argument_details").bind("keyup", function(){
$("#argument_details_chars_written").text($(this).val().length);
});


$(".clear_argument_form").bind("click", function(){
$("#argument_headline_chars_left").text(<? echo MAX_ARGUMENT_CHR_LENGTH;?>);
$("#argument_headline_abs_chars_left").text(<? echo MAX_ARGUMENT_ABS_CHR_LENGTH;?>);
$("#argument_details_chars_written").text("0");
$('.new_argument textarea').val('');
});


if($(".vote_distribution").length>0){

    $(".distribution").bind("mouseenter",function(){
        $(".question_vote_count").show();
    });

    $(".distribution").bind("mouseleave",function(){
        $(".question_vote_count").hide();
    });

}

if($("#form_new_question").length>0){

$("#new_question_title").bind("keyup", function(){

$("#new_question_title_chars_left").text(<? echo MAX_QUESTION_CHR_LENGTH;?>-$(this).val().length);
});

$("#new_question_details").bind("keyup", function(){
$("#new_question_details_chars_left").text($(this).val().length);
});
}

});

