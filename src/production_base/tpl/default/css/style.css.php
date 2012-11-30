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
header("Content-Type: text/css");
?>


@font-face {
 font-family: 'Imprima' ;
 src: local('Imprima'), local('Imprima-Regular'), url(<? echo $sTemplate->getTemplateRoot(); ?>css/fonts/Imprima-Regular.ttf) format("truetype");
}

@font-face {
  font-family: 'Cantata One';
  font-style: normal;
  font-weight: 400;
  src: local('Cantata One'), local('CantataOne-Regular'), url(<? echo $sTemplate->getTemplateRoot(); ?>css/fonts/CantataOne-Regular.ttf) format("truetype");
}


html, body, pre {
  padding: 0px;
  margin: 0px;
  font-family: "Imprima";
  color: #484848;
}

html, body {
    height: 100%;
}

html {
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/background.png');
  background-repeat: repeat;
}

ul, li {
  padding: 0px;
  margin: 0px;
  list-style-type: none;
}

body {
  height: 100%;
}

a {
  text-decoration: none;
  cursor: hand;
  cursor: pointer;
}

#header {
  box-shadow: 3px 0 6px 3px #DDDDDD;
  -moz-box-shadow: 3px 0 6px 3px #DDDDDD;
  -webkit-box-shadow: 3px 0 6px 3px #DDDDDD;
  -o-box-shadow: 3px 0 6px 3px #DDDDDD;
  position: relative;
  height: 130px;
  width: 100%;
}

#header_blue {
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/header_background.png');
  height: 54px;
  width: 100%;
  background-repeat: repeat-x;
}

#header_white {
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/header_navigation_background.png');
  height: 76px;
  width: 100%;
  background-repeat: repeat-x;
  position: relative;
}

#header_content {
  position: absolute;
  width: 1200px;
  left: 50%;
  margin-left: -600px;
  top: 0px;
  height: 130px;
}

#header_logo {
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/header_logo.png');
  height: 18px;
  width: 226px;
  position: relative;
  left: 30px;
  top: 20px;
}

#header_navigation {
  width: 980px;
  position: relative;
  left: 105px;
  top: 60px;
}

#wrapper {
  width: 100%;
  min-height: 100%;
  position: relative;
}

.navi_point {
   float:left;
  height: 61px;
  margin-right: 49px;
  padding-left:20px;
  padding-right:20px;
  position: relative;
  min-width:44px;

}
.navi_point.trend{
width:111px;}

.navi_point.neu{
width:45px;
}

.navi_point:last-child{
  margin-right: 0px;
  padding-right: 0px;
}

.navi_point a {
  color: #8E8E8E;
  font-size: 22px;
  font-family:"Cantata One";
  display:block;


}

.navi_point a:hover {
  color: #3275b6;

}

#content {
  position: relative;
  width: 950px;
  left: 50%;
  margin-left: -475px;
  padding-bottom:180px;
  padding-top: 15px;
}

#content_wide {
  position: relative;
  width: 1200px;
  left: 50%;
  margin-left: -600px;
  padding-bottom: 180px;
  clear: both;
  padding-top: 15px;
}

.thin {
  width: 950px;
  margin-left: 125px;
  position: relative;
}

#navi_search {
  padding-left:5px;
  width: 478px;
  border: 1px solid #D2D2D2;
  color: #898989;
  height: 19px;
  font-family: 'Imprima', sans-serif;
  letter-spacing: 0.3px;
  height:24px;
  font-size:16px;
}

#footer {
  background: #3275B7;
  height: 128px;
  width: 100%;
  background-repeat: repeat-x;
  margin-top: -128px;
  position:relative;
  clear:both;

  background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzMzODFjZCIgc3RvcC1vcGFjaXR5PSIwLjkiLz4KICAgIDxzdG9wIG9mZnNldD0iMTAwJSIgc3RvcC1jb2xvcj0iIzMyNzViNyIgc3RvcC1vcGFjaXR5PSIwLjkiLz4KICA8L2xpbmVhckdyYWRpZW50PgogIDxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9InVybCgjZ3JhZC11Y2dnLWdlbmVyYXRlZCkiIC8+Cjwvc3ZnPg==);
background: -moz-linear-gradient(top,  rgba(51,129,205,0.9) 0%, rgba(50,117,183,0.9) 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(51,129,205,0.9)), color-stop(100%,rgba(50,117,183,0.9)));
background: -webkit-linear-gradient(top,  rgba(51,129,205,0.9) 0%,rgba(50,117,183,0.9) 100%);
background: -o-linear-gradient(top,  rgba(51,129,205,0.9) 0%,rgba(50,117,183,0.9) 100%);
background: -ms-linear-gradient(top,  rgba(51,129,205,0.9) 0%,rgba(50,117,183,0.9) 100%);
background: linear-gradient(to bottom,  rgba(51,129,205,0.9) 0%,rgba(50,117,183,0.9) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e63381cd', endColorstr='#e63275b7',GradientType=0 );
}

#footer_content {
  width: 950px;
  left: 50%;
  margin-left: -475px;
  position: relative;
}

#footer_logo {
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/header_logo.png');
  height: 18px;
  width: 213px;
  position: relative;
  top: 42px;
}

#footer_copyright {
  position: relative;
  font-family: Tahoma, Geneva, sans-serif;
  top: 60px;
  color: #87CBFF;
  font-size: 13px;
  width:65%;
}

#footer_copyright a{
  font-family: Tahoma, Geneva, sans-serif;
color:#87cbff;
}

.filter {
  width: 910px;
  border: 1px solid #C7A900;
  border-radius: 20px;
  -moz-border-radius: 20px;
  -webkit-border-radius: 20px;
  background: #FDF4B7;
  color: #7B6913;
  margin-top: 20px;
  position: relative;
  font-size: 22px;
  padding: 10px;
  padding-right: 20px;
  padding-left: 20px;
  font-family:"Cantata One";
  clear:both;
}

.filter .remove {
  position: relative;
  font-size: 12px;
  color: #FF5300;
  float: right;
  margin-top: 5px;
}

.filter .remove a {
  color: #FF5300;
  font-family: Tahoma, Geneva, sans-serif;
}

.filter .remove span {
  float: left;
}

.remove_icon {
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/remove_icon.png');
  height: 9px;
  width: 9px;
  position: relative;
  float: right;
  margin-left: 5px;
  margin-top: 3px;
}


.question {
  width: 950px;
  border: 1px solid #B5B5B5;
  border-radius: 20px;
  -webkit-border-radius: 20px;
  -moz-border-radius: 20px;
  padding-bottom:25px;
  background: #FFFFFF;
  margin-top: 20px;
  position: relative;
  clear:both;
  top:-1px;
}

.stats {
  width: 100px;
  height: 90px;
  position: relative;
  top: 25px;
}

.stats .points {
  color: #004A80;
  font-size: 22px;
  position: relative;
  right: 8px;
  text-align: center;
  margin-top: 5px;
  font-family:"Cantata One", serif;
}

.stats.question_stats .question_points_text{
  color: #99b6cc;
}

.question_tabs .tab_active a{
  color: #222222;
}


.stats.argument_stats{
position:absolute;
}


.stats .points_text {
  color: #99B6CC;
  font-size: 11px;
  position: relative;
  right: 8px;
  text-align: center;
  font-family: Tahoma, Geneva, sans-serif;
}

.question_stats {
  float: left;
  margin-right: 30px;
}

.question_points {
}

.question_points_text {
}

.vote_up {
  width: 20px;
  height: 21px;
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/vote_up.png');
}

.vote_dn {
  width: 20px;
  height: 21px;
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/vote_dn.png');
}

.vote_up_inactive {
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/vote_up_inactive.png');
}

.vote_dn_inactive {
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/vote_dn_inactive.png');
}

.question_vote_up {
  position: absolute;
  top: 0px;
  right: 2px;
  cursor: hand;
  cursor: pointer;
}

.question_vote_dn {
  position: absolute;
  top: 36px;
  right: 2px;
  cursor: hand;
  cursor: pointer;
}

.question_title {
  color: #004A80;
  font-size: 20px;
  position: relative;
  float:left;
  width: 700px;
  top: 12px;
}

.question_title p {
  margin: none;
  width: 700px;
  vertical-align: top;
  display: block;
  margin-top:9px;
}

.question_details{
  float: left;
  margin-bottom: 30px;
  margin-left: 130px;
  position: relative;
  width: 800px;;
}

.question_title a {
  color: #004A80;
  font-family:"Cantata One", sans-serif;
  font-size: 22px;
}

.author {
  color: #8E8E8E;
  font-size: 12px;
  position: absolute;
  right: 20px;
  bottom: 20px;
  font-family: Tahoma, Geneva, sans-serif;
 }

.author a {
  color: #FF5300;
}

.question_author {
}

.question_author a {
}

.question_options {
  position: absolute;
  right: 20px;
  color: #B5B5B5;
  font-size: 12px;
  width: 70px;
  padding-left: 6px;
  padding-top: 3px;
  height: 18px;
  text-align: right;
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/arrows/dropdown-arrow.png') no-repeat 63px center;
  border-left: 1px solid #CCCCCC;
  border-right: 1px solid #CCCCCC;
  border-bottom: 1px solid #CCCCCC;
  border-bottom-right-radius: 5px;
  border-bottom-left-radius: 5px;
  top:0;
  font-family:Tahoma, Geneva, sans-serif;
}

.question_options .hidden {
  display: none;
  text-align: left;
  line-height: 23px;
  font-size: 12px;
  color: #004A80;
  padding-left: 6px;


}

.question_options:hover .hidden {
  display: block;
}

.question_options:hover {
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/arrows/dropup-arrow.png') no-repeat 142px 7px #EDEDED;

  height: 110px;
  width: 150px;
}

.question_options .up_arrow {
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/arrows/dropup-arrow.png') no-repeat;
  display: none;
}

.question_options:hover .up_arrow {
  display: inline;
}

.question_options:hover .dn_arrow {
  display: none;
}

.question_options .options_text{
text-align:right;
padding-right:18px;
}

.dn_arrow {
  padding-left: 5px;
  padding-right: 7px;
  height: 6px;
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/arrows/dn_arrow.png') no-repeat;
  position: relative;
  top: 6px;
  margin-left: 5px;
  display: inline;
}

.up_arrow {
  padding-left: 5px;
  padding-right: 7px;
  height: 6px;
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/arrows/up_arrow.png') no-repeat;
  position: relative;
  top: 5px;
  margin-left: 5px;
  display: inline;
}

.pagination_questions {
  width: 550px;
  left: 400px;
  margin-top: 29px;
}

.pagination {
  height: 28px;
  position: relative;
  text-align: right;
}

.pagination span {
  float: right;
}

.pagination_icon div {
  text-align: center;
  width: 26px;
  height: 23px;
  padding-top: 3px;
}

.pagination_icon {
  border: 1px solid #B5B5B5;
  border-radius: 5px;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  background: #FFFFFF;
  color: #F15003;
  margin-left: 10px;
}

.pagination_icon_active {
  background: #F15003;
  color: #FFFFFF;
}

.pagination_prev {
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/pagination_prev.png') no-repeat;
  width: 10px;
  height: 14px;
  margin-top: 7px;
}

.pagination_next {
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/pagination_next.png') no-repeat;
  width: 10px;
  height: 14px;
  margin-top: 7px;
  margin-left: 10px;
}

.pagination_x_of_y {
  font-size: 12px;
  color: #7D7D7D;
  padding-top: 7px;
  width: 90px;
  float: right;
  font-family:Tahoma, Geneva, sans-serif;
}

.headline {
  font-size: 40px;
  color: #004a80;
  font-family:"Cantata One", Tahome;
}

.icon_twitter {
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/icon_twitter.png') no-repeat;

}

.icon_fb {
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/icon_fb.png') no-repeat;
}

.icon_spam {
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/icon_spam.png') no-repeat;

}
.icon_short_url{
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/icon_short_url.png') no-repeat;
}


.icon_twitter ,.icon_fb, .icon_spam,.short_url{
  height: 18px;
  float: left;
  margin-right: 5px;
  border-radius:3px;
  -moz-border-radius:3px;
  -webkit-border-radius:3px;
  -o-border-radius:3px;
  margin-top:3px;
  font-family: Tahoma, Geneva, sans-serif;
  font-size: 13px;
}

.hidden a{
color:#004A80;
}




.question_tabs {
  width: 950px;
  margin-top: 20px;
  height: 26px;
  padding-left: 25px;
  position: relative;
  z-index: 2;
  font-size: 16px;
}

.question_tabs a {
  color: #7A7A7A;
}
.tab.tab_active{
color:#333;
}
.question_tabs .tab {
  float: left;
  padding-top: 3px;
  padding-bottom: 3px;
  padding-left: 7px;
  padding-right: 7px;
  margin-right: 10px;

  border-top: 1px solid transparent;
  border-left: 1px solid transparent;
  border-right: 1px solid transparent;
}

.question_tabs .tab_active {
  border-top: 1px solid #B5B5B5;
  border-left: 1px solid #B5B5B5;
  border-right: 1px solid #B5B5B5;
  border-bottom:1px solid #FFF;
  border-top-right-radius: 10px;
  border-top-left-radius: 10px;
  background: #FFFFFF;
}

.question_no_margin {
  margin-top: 0px;
  z-index: 1;
}

.vote_distribution {
  width: 950px;
  height: 40px;
  position: relative;

  margin-top: 47px;
  margin-bottom: 30px;
}

.question_vote_count{
   left: 50%;
   margin-left: -38px;
   position: absolute;
   top: -32px;
   border:1px solid #b5b5b5;
   padding:3px 8px;
   background:#fcffd2;
   border-radius:5px;
   -moz-border-radius:5px;
   -wekit-border-radius:5px;
   -o-border-radius:5px;
   font-family:Tahoma, Geneva, sans-serif;
   font-size:12px;
   box-shadow: 6px 5px 9px -9px black, 5px 6px 9px -9px #999;
   display:none;
}


.question_vote_count .arrow:after {
    -moz-transform: rotate(45deg);
  transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
    box-shadow: 6px 5px 9px -9px black, 5px 6px 9px -9px #ccc;
    content: "";
    height: 25px;
    left: 20px;
    position: absolute;
    top: -26px;
    width: 25px;
}
.question_vote_count .arrow:after {
    background: none repeat scroll 0 0 #fcffd2;
    border: 1px solid #b5b5b5;
}

.arrow {
    bottom: -16px;
    height: 16px;
    left: 50%;
    margin-left: -35px;
    overflow: hidden;
    position: absolute;
    width: 70px;
}



.checkin_pro_confirmed {
  width: 126px;
  height: 46px;

  float: left;
  position: relative;
  cursor: hand;
  cursor: pointer;
}

.checkin_pro_confirmed p,
.checkin_con_confirmed p {
  margin: 0;
  display: table-cell;
  vertical-align: middle;
  height: 46px;
}



.checkin_icon {
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/checkin_confirm.png') no-repeat;
  width: 41px;
  height: 38px;
  float: left;
  margin-right: 10px;
}

.checkin_con_confirmed {
  width: 126px;
  height: 46px;

  float: right;
  position: relative;
  cursor: hand;
  cursor: pointer;
}

.pro_perc {
  float: left;
  color: #000000;
  font-size: 22px;
  margin-top: 8px;
  margin-left: 20px;
  font-family:"Cantata One";
}

.con_perc {
  float: right;
  color: #000000;
  font-size: 22px;
  margin-top: 8px;
  margin-right: 20px;
  font-family:"Cantata One";
}

.distribution {
  width: 370px;
  height: 30px;
  border: 0px solid #E8E8E8;
  border-radius: 15px;
  -moz-border-radius: 15px;
  -webkit-border-radius: 15px;
  box-shadow: 0 -1px 4px 2px #A0A0A0;
  -moz-box-shadow: 0 -1px 4px 2px #A0A0A0;
  -webkit-box-shadow: 0 -1px 4px 2px #A0A0A0;
  position: absolute;
  left: 50%;
  margin-left: -185px;
  top: 7px;
  overflow: hidden;
}

.distribution_pro {
  position: absolute;
  top: -1px;
  left: -1px;
  height: 32px;

  background: #65a9d7;
  background: -webkit-gradient(linear, left top, left bottom, from(#65a9d7), to(#0048a5));
  background: -webkit-linear-gradient(top, #65a9d7, #0048a5);
  background: -moz-linear-gradient(top, #65a9d7, #0048a5);
  background: -ms-linear-gradient(top, #65a9d7, #0048a5);
  background: -o-linear-gradient(top, #65a9d7, #0048a5);
  box-shadow: 0 2px 5px #000000 inset;
  -moz-box-shadow: 0 2px 5px #000000 inset;
  -webkit-box-shadow: 0 2px 5px #000000 inset;
  -ms-box-shadow: 0 2px 5px #000000 inset;
  -o-box-shadow: 0 2px 5px #000000 inset;

  border-radius:15px;
  -moz-border-radius:15px;
  -o-border-radius:15px;
  -webkit-border-radius:15px;

  width:372px!important;

}

.distribution_con {
  position: absolute;
  top: -1px;
  right: -2px;
  height: 32px;

  background: #ff5d00;
  background: -webkit-gradient(linear, left top, left bottom, from(#f8b100), to(#ff5d00));
  background: -webkit-linear-gradient(top, #f8b100, #ff5d00);
  background: -moz-linear-gradient(top, #f8b100, #ff5d00);
  background: -ms-linear-gradient(top, #f8b100, #ff5d00);
  background: -o-linear-gradient(top, #f8b100, #ff5d00);

   box-shadow: -1px 3px 5px #211107 inset;
   -moz-box-shadow: -1px 3px 5px #211107 inset;
   -ms-box-shadow: -1px 3px 5px #211107 inset;
   -o-box-shadow: -1px 3px 5px #211107 inset;
   -webkit-box-shadow: -1px 3px 5px #211107 inset;

   border-radius:15px 15px 15px 15px;
  -moz-border-radius:15px 15px 15px 15px;
  -o-border-radius:15px 15px 15px 0px;
  -webkit-border-radius:15px 15px 15px 15px;
}

.argument_vote_up {
  position: absolute;
  top: 0px;
  right: 10px;
  cursor: hand;
  cursor: pointer;
}

.argument_vote_dn {
  position: absolute;
  top: 36px;
  right: 10px;
  cursor: hand;
  cursor: pointer;
}

.arguments_pro {
  width: 600px;
  position: relative;
  float: left;
}

.arguments_con {
  width: 600px;
  position: relative;
  float: right;
}

.argument_wrapper {
  width: 600px;
  margin-top: 20px;
  position: relative;
}

.argument {
  width: 440px;
  border: 1px solid #B5B5B5;
  border-radius: 20px;
  -moz-border-radius: 20px;
  -webkit-border-radius: 20px;
  min-height: 80px;
  background: #FFFFFF;
  position: relative;
  padding-bottom: 30px;
  overflow: hidden;
}

.argument_pro {
  margin-left: 125px;
}

.argument_con {
  margin-left: 35px;
}

.argument_pro_no_counter {
  margin-left: 80px;
}

.argument_con_no_counter {
  margin-left: 80px;
}

.clear {
  clear: both;
}

.arguments {
  position: relative;
  width: 1200px;
}

.arguments:after{
    background:#6ba3cc;
    content: "";
    height: 100%;
    left: 50%;
    position: absolute;
    top: 0;
    width: 1px;
  background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzZiYTNjYyIgc3RvcC1vcGFjaXR5PSIwIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjYlIiBzdG9wLWNvbG9yPSIjNmJhM2NjIiBzdG9wLW9wYWNpdHk9IjEiLz4KICAgIDxzdG9wIG9mZnNldD0iOTMlIiBzdG9wLWNvbG9yPSIjNmJhM2NjIiBzdG9wLW9wYWNpdHk9IjEiLz4KICAgIDxzdG9wIG9mZnNldD0iMTAwJSIgc3RvcC1jb2xvcj0iIzZiYTNjYyIgc3RvcC1vcGFjaXR5PSIwIi8+CiAgPC9saW5lYXJHcmFkaWVudD4KICA8cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMSIgaGVpZ2h0PSIxIiBmaWxsPSJ1cmwoI2dyYWQtdWNnZy1nZW5lcmF0ZWQpIiAvPgo8L3N2Zz4=);
background: -moz-linear-gradient(top,  rgba(107,163,204,0) 0%, rgba(107,163,204,1) 6%, rgba(107,163,204,1) 93%, rgba(107,163,204,0) 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(107,163,204,0)), color-stop(6%,rgba(107,163,204,1)), color-stop(93%,rgba(107,163,204,1)), color-stop(100%,rgba(107,163,204,0)));
background: -webkit-linear-gradient(top,  rgba(107,163,204,0) 0%,rgba(107,163,204,1) 6%,rgba(107,163,204,1) 93%,rgba(107,163,204,0) 100%);
background: -o-linear-gradient(top,  rgba(107,163,204,0) 0%,rgba(107,163,204,1) 6%,rgba(107,163,204,1) 93%,rgba(107,163,204,0) 100%);
background: -ms-linear-gradient(top,  rgba(107,163,204,0) 0%,rgba(107,163,204,1) 6%,rgba(107,163,204,1) 93%,rgba(107,163,204,0) 100%);
background: linear-gradient(to bottom,  rgba(107,163,204,0) 0%,rgba(107,163,204,1) 6%,rgba(107,163,204,1) 93%,rgba(107,163,204,0) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#006ba3cc', endColorstr='#006ba3cc',GradientType=0 );

}

.argument_headline {
  position: relative;
  color: #004a80;
  font-size: 20px;
  margin-left: 110px;
  margin-top: 20px;
  font-family:"Cantata One";
  font-size: 20px;
}

.argument_headline a {
  color: #004a80;
}

.argument_abstract {
  font-size: 16px;
  margin-left: 110px;
  margin-right: 20px;
  margin-top: 15px;
  margin-bottom:15px;
}

.argument_abstract .read_more{
color:#FF6A22;
font-size:16px;
}

.argument_details {
  color: #000000;
  font-size: 16px;
  margin-left: 110px;
  margin-right: 20px;
  margin-top: 15px;
  padding-bottom:15px;
}

.counter_argument_box {
  position: relative;
  height: 40px;
  width: 120px;
  border: 1px solid #B5B5B5;
  border-radius: 15px;
  -moz-border-radius: 15px;
  -webkit-border-radius: 15px;
  background: #FFFFFF;
}

.counter_argument_box_pro {
  position: absolute;
  top: 50%;
  margin-top: -20px;
  left: -16px;
}

.counter_argument_box_con {
  position: absolute;
  top: 50%;
  margin-top: -20px;
  right: -16px;
}

.count {
  font-size: 24px;
  color: #004a80;
  margin-top: 7px;
  margin-left: 15px;
  position: relative;
}

.count_text {
  color: #707070;
  font-size: 12px;
  position: absolute;
  right: 13px;
  top: 5px;
  width: 70px;
  font-family: Tahoma, Geneva, sans-serif;
}

.plus_sign {
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/plus_sign.png') no-repeat;
  height: 18px;
  width: 18px;
  position: absolute;
}

.counter_argument_box_pro .plus_sign {
  left: -9px;
  top: 10px;
}

.counter_argument_box_con .plus_sign {
  right: -9px;
  top: 10px;
}

.line {
  width: 30px;
  height: 1px;
  border-top:1px solid #b5b5b5;
  position: absolute;
}

.counter_argument_box_pro .line {
  left: 120px;
  top: 20px;
}

.counter_argument_box_con .line {
  left: -30px;
  top: 20px;
}

.argument_pro_bar {
  position: absolute;
  right: 0px;
  width: 10px;
  background: #0066b8;
  top: 0px;
  bottom: 0px;
}

.argument_con_bar {
  position: absolute;
  left: 0px;
  width: 10px;
  background: #ff7000;
  top: 0px;
  bottom: 0px;
}

.tab_arg_pro a {
  color: #0066b8;
}

.tab_arg_con a {
  color: #ff7000;
}

.argument_container {
  width: 600px;
  left: 50%;
  margin-left: -300px;
  position: relative;
}

.argument_container .argument_wrapper {
  margin-top:60px;
}

.argument_container .button_new_counter_argument {
  margin-top:60px;
}

.argument_container_full {
  width: 700px;
  left: 50%;
  margin-left: -350px;
  position: relative;
}

.argument_container_full .argument_full {
  margin-top:60px;
}

.argument_container:after {
    background:#135889;
    content: "";
    height: 100%;
    left: 50%;
    position: absolute;
    top: 0;
    width: 1px;
  z-index:-10;
  margin-top:-76px;
}




.argument_extended_no_tabs {
  margin-top: 20px;
}

.argument_extended {
  width: 950px;
  border: 1px solid #B5B5B5;
  border-radius: 20px;
  -moz-border-radius: 20px;
  -webkit-border-radius: 20px;
  min-height: 100px;
  background: #FFFFFF;
  position: relative;
  overflow: hidden;
}


.argument_title {
  color: #004A80;
  font-size: 22px;
  position: relative;
  width: 700px;
  margin-top: 25px;
  left: 100px;
}
.argument_extended .argument_title{
left:0px;
}


.argument_title a {
  color: #004A80;
  font-family:"Cantata One";
}

.argument_abstract_extended {
  font-size: 16px;
  margin-left: 130px;
  margin-right: 20px;
  margin-top: 15px;
  margin-bottom: 35px;
}

.argument_details_extended {
  color: #000000;
  font-size: 16px;
  margin-left: 130px;
  margin-right: 20px;
  margin-top: 15px;
  margin-bottom: 45px;
}

.button_argument {
  width: 440px;
  padding-top: 50px;
  color: #707070;
  font-size: 22px;
  margin-top: 20px;
  background: #FFF;
  border-radius: 15px 15px 10px 10px;
  -moz-border-radius: 15px 15px 10px 10px;
  -webkit-border-radius: 15px 15px 10px 10px;
  text-align: center;
  cursor: hand;
  cursor: pointer;


background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2ZmZmZmZiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNmZmZmZmYiIHN0b3Atb3BhY2l0eT0iMCIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
background: -moz-linear-gradient(top,  rgba(255,255,255,1) 0%, rgba(255,255,255,0) 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,1)), color-stop(100%,rgba(255,255,255,0)));
background: -webkit-linear-gradient(top,  rgba(255,255,255,1) 0%,rgba(255,255,255,0) 100%);
background: -o-linear-gradient(top,  rgba(255,255,255,1) 0%,rgba(255,255,255,0) 100%);
background: -ms-linear-gradient(top,  rgba(255,255,255,1) 0%,rgba(255,255,255,0) 100%);
background: linear-gradient(to bottom,  rgba(255,255,255,1) 0%,rgba(255,255,255,0) 100%);


 box-shadow: 0 -4px 4px 0 #999999;
 -moz-box-shadow: 0 -4px 4px 0 #999999;
 -webkit-box-shadow: 0 -4px 4px 0 #999999;
 -o-box-shadow: 0 -4px 4px 0 #999999;

}


.button_argument span{
font-family:"Cantata One";
width:100%;
height:40px;
padding-top:35px;
background:url(<? echo $sTemplate->getTemplateRoot(); ?>img/assets/plus.png) no-repeat center top;
}

.button_new_question {
  float: left;
  margin-top: 29px;
}

.button_new_counter_argument {
  margin-left: 80px;
}

.button_new_argument_pro {
  margin-left: 125px;
}

.button_new_argument_con {
  margin-left: 35px;
}

.new_argument {
  width: 600px;
  margin-left: 175px;
}

.new_question {
  width: 600px;
  margin-left: 175px;
}

.profile {
  width: 600px;
  margin-left: 175px;
}

.row {
  position: relative;
  margin-top: 60px;
}

.new_question .row{
clear:both;
}

#new_counter_argument .row{
margin-top:10px;
margin-bottom:10px;
}

#new_counter_argument{
position:relative;
margin-top:20px;
}


.new_argument .row{
clear:both;}

.row_submit {
  height: 27px;
  text-align: right;
}

.row.row_submit{
margin-top:60px;
}

.new_argument .label {
  width: 70px;
  float: left;
  position: relative;
  font-weight: bold;
  font-size: 16px;
  color: #000000;
  font-family:'Imprima', sans-serif;
  margin-right:20px;
  margin-top:6px;
}

.new_argument .input {
  width: 500px;
  float:left;
  position: relative;
  margin-left: 10px;
}

.new_argument textarea {
  width: 500px;
  min-width:500px;
  max-width:500px;
  border: 1px solid #b5b5b5;
  border-radius:5px;
  -moz-border-radius:5px;
  -webkit-border-radius:5px;
  box-shadow:0px 2px 2px #DDD inset;
  font-family:'Imprima', sans-serif;
  font-size: 16px;
}

#new_argument_headline {
  height: 25px;
  max-height:25px;
  min-height:25px;
  padding-top:5px;
}

#new_argument_abstract {
  height: 150px;
}

#new_argument_details {
  height: 250px;
}

.new_question .label {
  width: 90px;
  float: left;
  position: relative;
  font-size: 16px;
  color: #000000;
  font-family: Imprima, Tahoma, Geneva, sans-serif;
  line-height:20px;

}



.new_question .input {
  width: 510px;
  position: relative;
  margin-left: 90px;
}

.new_question textarea {
   border: 1px solid #B5B5B5;
   border-radius: 5px 5px 5px 5px;
   box-shadow: 0 2px 3px 1px #DDDDDD inset;
   width: 498px;
   max-width:498px;
   min-width:498px;
   padding:5px;
   font-family: 'Imprima', sans-serif;
   font-size: 16px;
}

#new_question_headline {
  height: 20px;
}

#new_question_tags {
  height: 50px;
}

#new_question_details {
  height: 250px;
}

.button_orange {

font-family: 'Imprima', sans-serif;
letter-spacing: -0.5px;
font-size:16px;
padding:7px 14px;
background:#ee600d;
border-top :1px solid #edb14a;
border-bottom :1px solid #9c4822;
border-left: 1px solid #da9650;
border-right:1px solid #af5b0c;
color:#FFF;
 text-shadow: 0 -1px #B64F1B;
background: #f6a015; /* Old browsers */
background: -moz-linear-gradient(top,  #f6a015 0%, #f17b10 60%, #e6500b 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f6a015), color-stop(60%,#f17b10), color-stop(100%,#e6500b)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #f6a015 0%,#f17b10 60%,#e6500b 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #f6a015 0%,#f17b10 60%,#e6500b 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #f6a015 0%,#f17b10 60%,#e6500b 100%); /* IE10+ */
background: linear-gradient(to bottom,  #f6a015 0%,#f17b10 60%,#e6500b 100%); /* W3C */

border-radius:5px;
-moz-border-radius:5px;
-webkit-border-radius:5px;
-o-border-radius:5px;
box-shadow: 1px 1px #fce0af inset,0px 0px 3px #999;
-moz-box-shadow: 1px 1px #fce0af inset,0px 0px 3px #999;
-webkit-box-shadow: 1px 1px #fce0af inset,0px 0px 3px #999;
-o-box-shadow: 1px 1px #fce0af inset,0px 0px 3px #999;

}
.button_orange:before{
  -moz-transform: rotate(-33deg);
  transform: rotate(-33deg);

    border-radius: 2px 2px 2px 2px;
    content: "";
    display: block;
    height: 2px;
    margin-left: -17px;
    margin-top: -7px;
    position: absolute;
    width: 3px;

    background: #fde6c1; /* Old browsers */
background: -moz-linear-gradient(top,  #fde6c1 0%, #fdeed6 50%, #ffffff 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fde6c1), color-stop(50%,#ffffff), color-stop(100%,#fde7c5)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #fde6c1 0%,#fdeed6 50%,#fde7c5 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #fde6c1 0%,#fdeed6 50%,#fde7c5 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #fde6c1 0%,#fdeed6 50%,#fde7c5 100%); /* IE10+ */
background: linear-gradient(to bottom,  #fde6c1 0%,#fdeed6 50%,#fde7c5 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fde6c1', endColorstr='#fde7c5',GradientType=0 ); /* IE6-9 */

}

.button_blue{
font-family: 'Imprima', sans-serif;
letter-spacing: -0.5px;
font-size:16px;
padding:7px 14px;
background:#ee600d;
border-top :1px solid #3aa4d3;
border-bottom :1px solid #1c4276;
border-left: 1px solid #0072c0;
border-right:1px solid #00538b;
color:#FFF;
text-shadow: 0 -1px #012f6c;

 background: #0070be; /* Old browsers */
background: -moz-linear-gradient(top,  #008ed1 0%, #003883 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#008ed1), color-stop(100%,#003883)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #008ed1 0%,#003883 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #008ed1 0%,#003883 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #008ed1 0%,#003883 100%); /* IE10+ */
background: linear-gradient(to bottom,  #008ed1 0%,#003883 100%); /* W3C */


border-radius:5px;
-moz-border-radius:5px;
-webkit-border-radius:5px;
-o-border-radius:5px;
box-shadow: 1px 1px #a8d9f0 inset,0px 0px 3px #999;
-moz-box-shadow: 1px 1px #a8d9f0 inset,0px 0px 3px #999;
-webkit-box-shadow: 1px 1px #a8d9f0 inset,0px 0px 3px #999;
-o-box-shadow: 1px 1px #a8d9f0 inset,0px 0px 3px #999;

}

.button_blue:before{
  -moz-transform: rotate(-33deg);
  transform: rotate(-33deg);

    border-radius: 2px 2px 2px 2px;
    content: "";
    display: block;
    height: 2px;
    margin-left: -17px;
    margin-top: -7px;
    position: absolute;
    width: 3px;

  background: #fde6c1; /* Old browsers */
background: -moz-linear-gradient(top,  #fde6c1 0%, #fdeed6 50%, #ffffff 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fde6c1), color-stop(50%,#ffffff), color-stop(100%,#fde7c5)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #fde6c1 0%,#fdeed6 50%,#fde7c5 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #fde6c1 0%,#fdeed6 50%,#fde7c5 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #fde6c1 0%,#fdeed6 50%,#fde7c5 100%); /* IE10+ */
background: linear-gradient(to bottom,  #fde6c1 0%,#fdeed6 50%,#fde7c5 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fde6c1', endColorstr='#fde7c5',GradientType=0 ); /* IE6-9 */
}





.button_orange:hover,
.button_blue:hover{
opacity:0.8;
cursor: pointer;
}

.signup {
  background: url("<? echo $sTemplate->getTemplateRoot(); ?>img/backgrounds/register_bg.png") no-repeat scroll center 31px transparent;
    float: left;
    padding-bottom: 40px;
    padding-right: 50px;
    width: 400px;
}

.login {
  float: right;
  width: 400px;
  padding-top: 18px;
}

.login .headline {
  font-size: 22px;
}

.signup .label,
.login .label {
  width: 130px;
  float: left;
  position: relative;
  font-size: 16px;
  font-family: Imprima, Tahoma, Geneva, sans-serif;
}

.signup .input,
.login .input {
  width: 270px;
  position: relative;
  margin-left: 130px;
}

.signup input,
.login input {
    border: 1px solid #B5B5B5;
    border-radius: 3px 3px 3px 3px;
    box-shadow: 0 2px 2px 1px #DDDDDD inset;
    height: 26px;
    padding-left: 3px;
    width: 265px;
    font-family:"Imprima", sans-serif;
    font-size: 16px;
}

.header_signup {
  width: 175px;
  height: 20px;
  top: 15px;
  right: 0px;
  color: #87cbff;
  font-size: 16px;
  position: absolute;

}

.header_signup a {
   color: #7EC2F7;
   text-shadow: 0 -1px #011A2D;
   font-size: 18px;
}

.header_menu {
  position: absolute;
  color: transparent;
  font-size: 12px;
  width: 150px;
  height: 44px;
  text-align: right;
  top: 10px;
  right: 0px;
}

.header_menu .username {
  color: #87cbff;
  height: 34px;
  width: 150px;
  padding-top: 10px;
  text-align: center;
  position: relative;
  font-family: Imprima, Tahoma, Geneva, sans-serif;
  font-size:15px;
  text-transform:capitalize;
}

.header_menu:hover .username {
margin-left: 120px;
background: #3275b7;
background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzQxODhjOCIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiMzMjc1YjciIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
background: -moz-linear-gradient(top,  #4188c8 0%, #3275b7 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#4188c8), color-stop(100%,#3275b7));
background: -webkit-linear-gradient(top,  #4188c8 0%,#3275b7 100%);
background: -o-linear-gradient(top,  #4188c8 0%,#3275b7 100%);
background: -ms-linear-gradient(top,  #4188c8 0%,#3275b7 100%);
background: linear-gradient(to bottom,  #4188c8 0%,#3275b7 100%);
  border-top-right-radius: 10px;
  border-top-left-radius: 10px;
*filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#4188c8', endColorstr='#3275b7',GradientType=0 );



}

.header_menu .hidden a {
  color: #FFFFFF;
  display:block;
  width:100%;
}

.header_menu .hidden {
  display: none;
  text-align: left;
  line-height: 40px;
  font-size: 16px;
  color: #FFFFFF;
  width: 230px;
  float:right;
  background: #3275b7;

  border-bottom-right-radius: 10px;
  border-bottom-left-radius: 10px;
  border-top-left-radius: 10px;
}

.header_menu:hover .hidden {
  display: block;
}

.header_menu:hover {
  height: 160px;
  width: 270px;
}

.header_menu .up_arrow {
  display: none;
}

.header_menu:hover .up_arrow {
  display: inline;
}

.header_menu:hover .dn_arrow {
  display: none;
}

.icon_new_question {
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/icon_new_question.png') no-repeat;
  width: 26px;
  height: 31px;
  float: left;
  margin-right: 14px;
  margin-left: 10px;
  margin-top: 9px;
}

.icon_manage_profile {
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/icon_manage_profile.png') no-repeat;
  width: 24px;
  height: 29px;
  float: left;
  margin-right: 16px;
  margin-left: 10px;
  margin-top: 11px;
}

.icon_my_profile {
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/icon_my_profile.png') no-repeat;
  width: 23px;
  height: 27px;
  float: left;
  margin-right: 17px;
  margin-left: 10px;
  margin-top: 11px;
}

.icon_logout {
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/icon_logout.png') no-repeat;
  width: 18px;
  height: 30px;
  float: left;
  margin-right: 22px;
  margin-left: 10px;
  margin-top: 9px;
}

#header_menu_wrapper {
  position: absolute;
  top: 0px;
  height: 160px;
  left: 50%;
  z-index: 5;
  margin-left: 600px;
}

.signup_date {
  position: absolute;
  right: 0px;
  bottom: 0px;
  font-size: 16px;
  color: #949595;
  font-family:"Imprima", sans-serif;
}

.seperator {
  height: 1px;
  background: #A1A1A1;
}

.profile_score_questions {
  float: left;
  width: 280px;
  margin-left:30px;
}.profile_score_arguments {
  float: right;
  width: 280px;
}

.profile_score_questions .score,
.profile_score_arguments .score {
  font-size: 40px;
  color: #707070;
  float: left;
  font-family: Cantata One, Tahoma, Geneva, sans-serif;
}

.profile_score_questions .score_text,
.profile_score_arguments .score_text {
  height: 48px;
  display: table-cell;
  vertical-align: middle;
  font-size: 19px;
  color: #000000;
  padding-left: 20px;
  font-family:"Imprima", sans-serif;
  text-shadow:0px 1px #fff;

}

.tags {
  position: relative;
  width:60%;
  height:30px;
  overflow:hidden;
}

.tags ul{
margin:0;
overflow:hidden;

}

.tag {
  display: inline-block;
  margin: 5px 5px;
  height: 20px;
  font-family: Tahoma, Geneva, sans-serif;
}

.tag:first-child {
  margin-left: 0px;
}

.tag a{
  padding: 4px 10px;
  border-radius: 6px;
  -moz-border-radius: 6px;
  -webkit-border-radius: 6px;
  background: #FFFFFF;
  border: 1px solid #F9B497;
  color: #858585;
  font-size: 14px;
  margin-top: 2px;
  line-height: 20px;
}
.tag a:hover {
  background: #fdf5f0;
}


ul.user_profile_list {
  list-style: none;
  margin: 0px;
  padding: 0px;
}

ul.user_profile_list li {
  display: list-item;
  clear: both;
  line-height: 42px;
}

ul.user_profile_list li {
  border-bottom: 1px solid #0d5399;
  border-top: 1px solid #4990d6;
}

ul.user_profile_list li:last-child {
  border-bottom :none;
  border-radius :0px 0px 10px 10px;
}

ul.user_profile_list li:first-child {
  border-top: none;
  border-radius: 10px 0px 0px 0px;
}
ul.user_profile_list li:hover {
  background: #458bd1;
}


/* Check in pro button*/
.checkin_pro{
float:left;
font-family: 'Imprima', sans-serif;
letter-spacing: -0.5px;
font-size:16px;
padding:7px 14px;
background:#ee600d;
border-top :1px solid #3aa4d3;
border-bottom :1px solid #1c4276;
border-left: 1px solid #0072c0;
border-right:1px solid #00538b;
color:#FFF;
text-shadow: 0 -1px #012f6c;

background: #0070be; /* Old browsers */
background: -moz-linear-gradient(top,  #008ed1 0%, #003883 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#008ed1), color-stop(100%,#003883)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #008ed1 0%,#003883 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #008ed1 0%,#003883 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #008ed1 0%,#003883 100%); /* IE10+ */
background: linear-gradient(to bottom,  #008ed1 0%,#003883 100%); /* W3C */


border-radius:5px 0px 0px 5px;
-moz-border-radius:5px 0px 0px 5px;
-webkit-border-radius:5px 0px 0px 5px;
-o-border-radius:5px 0px 0px 5px;
box-shadow: 1px 1px #a8d9f0 inset,0px 0px 3px #999;
-moz-box-shadow: 1px 1px #a8d9f0 inset,0px 0px 3px #999;
-webkit-box-shadow: 1px 1px #a8d9f0 inset,0px 0px 3px #999;
-o-box-shadow: 1px 1px #a8d9f0 inset,0px 0px 3px #999;
position:relative;
margin-right:30px;
 height: 37px;
}

.checkin_pro:before{
  -moz-transform: rotate(-33deg);
  transform: rotate(-33deg);

    border-radius: 2px 2px 2px 2px;
    content: "";
    display: block;
    height: 2px;
    margin-left: -17px;
    margin-top: -7px;
    position: absolute;
    width: 3px;

background: #fde6c1; /* Old browsers */
background: -moz-linear-gradient(top,  #fde6c1 0%, #fdeed6 50%, #ffffff 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fde6c1), color-stop(50%,#ffffff), color-stop(100%,#fde7c5)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #fde6c1 0%,#fdeed6 50%,#fde7c5 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #fde6c1 0%,#fdeed6 50%,#fde7c5 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #fde6c1 0%,#fdeed6 50%,#fde7c5 100%); /* IE10+ */
background: linear-gradient(to bottom,  #fde6c1 0%,#fdeed6 50%,#fde7c5 100%); /* W3C */



}


.checkin_pro:after{
    content: '';
    height: 37px;
    position: absolute;
    right: -19px;
    top: -1px;
    width: 20px;
  background: url("<? echo $sTemplate->getTemplateRoot(); ?>img/arrows/arrow_blue.png") no-repeat scroll 0 0 transparent;

}


.checkin_con{
float:right;
font-family: 'Imprima', sans-serif;
letter-spacing: -0.5px;
font-size:16px;
padding:7px 14px 7px 7px;
background:#ee600d;
border-top :1px solid #edb14a;
border-bottom :1px solid #9c4822;
border-left: 1px solid #da9650;
border-right:1px solid #af5b0c;
color:#FFF;
height: 37px;
text-shadow: 0 -1px #B64F1B;
background: #f6a015; /* Old browsers */
background: -moz-linear-gradient(top,  #f6a015 0%, #f17b10 60%, #e6500b 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f6a015), color-stop(60%,#f17b10), color-stop(100%,#e6500b)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #f6a015 0%,#f17b10 60%,#e6500b 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #f6a015 0%,#f17b10 60%,#e6500b 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #f6a015 0%,#f17b10 60%,#e6500b 100%); /* IE10+ */
background: linear-gradient(to bottom,  #f6a015 0%,#f17b10 60%,#e6500b 100%); /* W3C */

border-radius:0px 5px 5px 0px;
-moz-border-radius:0px 5px 5px 0px;
-webkit-border-radius:0px 5px 5px 0px;
-o-border-radius:0px 5px 5px 0px;
box-shadow: 1px 1px #fce0af inset,0px 0px 3px #999;
-moz-box-shadow: 1px 1px #fce0af inset,0px 0px 3px #999;
-webkit-box-shadow: 1px 1px #fce0af inset,0px 0px 3px #999;
-o-box-shadow: 1px 1px #fce0af inset,0px 0px 3px #999;
position:relative;
margin-left:30px;

}
.checkin_con:before{
   content: " ";
    height: 38px;
    left: -17px;
    position: absolute;
    top: -2px;
    width: 20px;
  background: url("<? echo $sTemplate->getTemplateRoot(); ?>img/arrows/arrow_orange.png") no-repeat scroll 0 0 transparent;

}
.checkin_con:hover,.checkin_pro:hover{
cursor:pointer;
}


.clear_form_button{
float:left;
margin-left:90px;
}
.clear_argument_form{
margin-left:100px;
float:left;
}

.writing_tips{
   margin-left: 282px;
   width: 700px;
   margin-top:50px;
}

.writing_tips h3{
    color: #004A80;
    height: 29px;
    left: -64px;
    line-height: 29px;
    padding-left: 43px;
    position: relative;
background:url(<? echo $sTemplate->getTemplateRoot(); ?>img/assets/info_tip.png) no-repeat left center;

}

.writing_tips ul.writing_tips_list li{
list-style:decimal;
margin:10px 0px 10px;
font-family:"Imprima", sans-serif;
}

.current_page{
background:url(<? echo $sTemplate->getTemplateRoot(); ?>img/assets/selected_page.png) no-repeat center bottom;

}

.question_tabs a{
font-family:"Imprima", serif;
}

#footer_socials{
float:right;
}

#footer_socials li{
list-style:none;
margin:3px;
display: inline-block;
}
#footer_socials ul li a{

width:32px;
height:32px;
display:block;
}

#footer_socials .footer_twitter{
background:url(<? echo $sTemplate->getTemplateRoot(); ?>img/socials/twitter.png) no-repeat center top;
}
#footer_socials .footer_twitter:hover{
background:url(<? echo $sTemplate->getTemplateRoot(); ?>img/socials/twitter.png) no-repeat center bottom;
}

#footer_socials .footer_facebook{
background:url(<? echo $sTemplate->getTemplateRoot(); ?>img/socials/facebook.png) no-repeat center top;
}

#footer_socials .footer_facebook:hover{
background:url(<? echo $sTemplate->getTemplateRoot(); ?>img/socials/facebook.png)no-repeat center bottom;
}

#user_tips{
width:600px;
margin-left:175px;
}

#user_tips h3{
margin-top:35px;
color:#004a80;
font-family:"Cantata One", sans-serif
font-size:20px;
}


#user_tips li p.recent_question,
#user_tips li p.recent_argument{
color:#f26522;
font-size:15px;
margin-bottom:0px;
}

#user_tips li p.question_posted,
#user_tips li p.argument_posted {
  color:#707070;
  font-size:15px;
  margin-top:0px;
  font-size:12px;
}

.recent_questions li {
  background:url(<? echo $sTemplate->getTemplateRoot(); ?>img/assets/question.png) no-repeat left top;
  padding-left:40px;
}

.recent_arguments li {
  background:url(<? echo $sTemplate->getTemplateRoot(); ?>img/assets/argument.png) no-repeat left top;
  padding-left:40px;
}

#user_tips li p.recent_argument {
  border-bottom:1px solid #d0d0d0;
  padding-bottom:5px;
}

#user_tips li p.argument_posted {
  padding-top:5px;
}


.recent_arguments li a {
  color:#f26522;
}


.characters_left,
.characters_written {
  float:right;
  margin-right:5px;
  margin-bottom:20px;
  font-size:12px;
  margin-top:5px;
  color:#999;
  font-family:Tahoma, Geneva, sans-serif;
}


.ui-dialog{
border:4px solid #CCC;
box-shadow: 6px 8px 5px #999;
-moz-box-shadow: 6px 8px 5px #999;
-webkit-box-shadow: 6px 8px 5px #999;
border-radius:7px;
-moz-border-radius:7px;
-webkit-border-radius:7px;
padding:15px;
}
.ui-dialog-titlebar { display:none; }


.ui-dialog .ui-dialog-buttonpane{
border:0px;
}

.ui-widget-content {
  background: url(<? echo $sTemplate->getTemplateRoot(); ?>img/assets/alert_info.png) no-repeat 40px 40px #FFF;
  font-family: "Imprima", sans-serif;
  padding-left: 75px;
  padding-top: 33px;
  padding-right: 75px;

}
.ui-widget-overlay{
opacity:0.2;
}
.ui-dialog .ui-dialog-buttonpane button{
margin:0 auto;
}
.ui-dialog .ui-dialog-buttonpane{
text-align:center!important;}

.argument_pro_bar{
border-radius: 0px 10px 10px 0px;
top:2px;
bottom:2px;
}

.argument_con_bar{
border-radius: 10px 0px 0px 10px;
top:2px;
bottom:2px;

}
div.clearfix{
clear:both;
}

.short_url {
  color: #87CBFF;
}

.argument_full {
  width: 700px;
  border: 1px solid #B5B5B5;
  border-radius: 20px;
  -moz-border-radius: 20px;
  -webkit-border-radius: 20px;
  min-height: 100px;
  background: #FFFFFF;
  position: relative;
  overflow: hidden;
}

.argument_full .argument_title {
  margin-left: 100px;
  left: 0px;
}

.counter_argument_box_full {
  position: relative;
  height: 40px;
  width: 120px;
  border: 1px solid #B5B5B5;
  border-radius: 15px;
  -moz-border-radius: 15px;
  -webkit-border-radius: 15px;
  background: #FFFFFF;
  left: 50%;
  margin-left: -60px;
}

.counter_argument_box_full_pro .plus_sign {
  left: -9px;
  top: 10px;
}

.counter_argument_box_full_con .plus_sign {
  right: -9px;
  top: 10px;
}

.counter_argument_box_full_line {
  left: 50%;
  margin-left: -1px;
  width: 1px;
  height: 30px;
  position: relative;
  background: #B5B5B5;
}

.counter_argument_box:hover {
  background-color: #EEEEEE;
}

.argument_abstract .read_more:hover{
  text-decoration:underline;
}

.question_num_arguments {
  position: absolute;
  right: 20px;
  top: 18px;
  text-align: right;
  padding-top: 6px;
  height: 25px;
  width: 50px;
  color: #004A80;
}

.icon_num_arguments {
  position: absolute;
  left: 0px;
  top: 0px;
  width: 31px;
  height: 31px;
  background: url('<? echo $sTemplate->getTemplateRoot(); ?>img/icon_num_arguments.png');
}
