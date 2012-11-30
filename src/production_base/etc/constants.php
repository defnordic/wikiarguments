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

define("SORT_TRENDING",                 0);
define("SORT_TOP",                      1);
define("SORT_NEWEST",                   2);

define("VIEW_DISCUSSION",               0);
define("VIEW_DETAILS",                  1);
define("VIEW_ARGUMENT",                 2);
define("VIEW_NEW_ARGUMENT",             3);
define("VIEW_NEW_COUNTER_ARGUMENT",     4);
define("VIEW_NEW_QUESTION",             5);
define("VIEW_SIGNUP",                   6);

define("BADWORD_CATEGORY_ALL",          0);
define("BADWORD_CATEGORY_USERNAME",     1);

define("FILTER_NONE",                   0);
define("FILTER_PRO",                    1);
define("FILTER_CON",                    -1);

define("ARGUMENT_INDEF",                0);
define("ARGUMENT_PRO",                  1);
define("ARGUMENT_CON",                  -1);

define("FACTION_NONE",                  0);
define("FACTION_PRO",                   1);
define("FACTION_CON",                   -1);

define("SORT_NONE",                     0);
define("SORT_SCORE",                    0);

define("VOTE_UP",                       1);
define("VOTE_DN",                       -1);
define("VOTE_NONE",                     0);

define("USER_GROUP_DEFAULT_SIGNUP",     0);
define("USER_GROUP_DEFAULT_CONFIRMED",  10);
define("USER_GROUP_PENDING",            0);
define("USER_GROUP_USER",               10);
define("USER_GROUP_ADMIN",              100);

define("ACTION_NEW_QUESTION",           "new_question");
define("ACTION_NEW_ARGUMENT",           "new_argument");
define("ACTION_NEW_COUNTER_ARGUMENT",   "new_counter_argument");
define("ACTION_LOGIN",                  "login");
define("ACTION_VOTE",                   "vote");

define("PERMISSION_ALLOWED",            1);
define("PERMISSION_DISALLOWED",         -1);
?>
