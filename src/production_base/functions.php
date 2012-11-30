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

// sort Function for a multidimensional Array
function compare($x, $y, $key)
{
    if ( $x[$key] == $y[$key] )
        return 0;
    else if ( $x[$key] < $y[$key] )
        return 1;
    else
        return -1;
}

function compareObjAsc($x, $y, $key)
{
    if ( $x->$key == $y->$key )
        return 0;
    else if ( $x->$key < $y->$key )
        return 1;
    else
        return -1;
}

function compareObjDesc($x, $y, $key)
{
    if ( $x->$key() == $y->$key() )
        return 0;
    else if ( $x->$key() > $y->$key() )
        return 1;
    else
        return -1;
}

function array_sort(&$array, $sort_key)
{
    $size = count($array);
    sort($array);
    foreach($array as $key => $val)
    {
        if($key+1 == $size)
            return;
        while(compare($array[$key], $array[$key+1], $sort_key) == -1)
        {
            $tmp = $array[$key+1];
            $array[$key+1] = $array[$key];
            $array[$key] = $tmp;
            if($key != 0)
                $key--;
        }
    }
}

function array_sortObjAsc(&$array, $sort_key)
{
    $size = count($array);
    sort($array);
    foreach($array as $key => $val)
    {
        if($key+1 == $size)
            return;
        while(compareObjAsc($array[$key], $array[$key+1], $sort_key) == -1)
        {
            $tmp = $array[$key+1];
            $array[$key+1] = $array[$key];
            $array[$key] = $tmp;
            if($key != 0)
                $key--;
        }
    }
}

function array_sortObjDesc(&$array, $sort_key)
{
    $size = count($array);
    sort($array);
    foreach($array as $key => $val)
    {
        if($key+1 == $size)
            return;
        while(compareObjDesc($array[$key], $array[$key+1], $sort_key) == -1)
        {
            $tmp = $array[$key+1];
            $array[$key+1] = $array[$key];
            $array[$key] = $tmp;
            if($key != 0)
                $key--;
        }
    }
}

$globalMultisortVar = array();
$globalMultisortObj;
function columnSort($recs, $cols, $obj = true)
{
    global $globalMultisortVar, $globalMultisortObj;
    $globalMultisortVar = $cols;
    $globalMultisortObj = $obj;
    usort($recs, 'multiStrnatcmp');
    return($recs);
}

function multiStrnatcmp($a, $b)
{
    global $globalMultisortVar, $globalMultisortObj;
    $cols = $globalMultisortVar;
    $i = 0;
    $result = 0;
    while ($result == 0 && $i < count($cols))
    {
        if($globalMultisortObj)
        {
            $field = $cols[$i];
            $result = ($cols[$i + 1] == 'desc' ? strnatcmp($b->$field, $a->$field) : $result = strnatcmp($a->$field, $b->$field));
        }else
        {
            $result = ($cols[$i + 1] == 'desc' ? strnatcmp($b[$cols[$i]], $a[$cols[$i]]) : $result = strnatcmp($a[$cols[$i]], $b[$cols[$i]]));
        }
        $i += 2;
    }
    return $result;
}

function columnSortObject($recs, $cols)
{
    global $globalMultisortVar;
    $globalMultisortVar = $cols;
    usort($recs, 'multiStrnatcmpObject');
    return($recs);
}

function multiStrnatcmpObject($a, $b)
{
    global $globalMultisortVar;
    $cols = $globalMultisortVar;
    $i = 0;
    $result = 0;
    while ($result == 0 && $i < count($cols))
    {
        $result = ($cols[$i + 1] == 'desc' ? strnatcmp($b->$cols[$i], $a->$cols[$i]) : $result = strnatcmp($a->$cols[$i], $b->$cols[$i]));
        $i+=2;
    }
    return $result;
}

function exception($error)
{
    die($error);
}

function Array_BinarySearch($needle, $haystack, $comparator , &$probe )
{
    $high = count($haystack) - 1;
    $low = 0;

    while ($high >= $low)
    {
        $probe = floor(($high + $low) / 2);
        $comparison = $comparator($haystack[$probe], $needle);
        if ($comparison < 0)
        {
            $low = $probe + 1;
        }
        elseif ($comparison > 0)
        {
            $high = $probe - 1;
        }
        else
        {
            return true;
        }
    }
    //The loop ended without a match
    //Compensate for needle greater than highest haystack element
    if($comparator($haystack[count($haystack)-1], $needle) < 0)
    {
        $probe = count($haystack);
    }
    return false;
}
?>