<?php

/* mlmmj/php-admin:
 * Copyright (C) 2004 Christoph Thiel <ct at kki dot org>
 *
 * mlmmj/php-perl:
 * Copyright (C) 2004 Morten K. Poulsen <morten at afdelingp.dk>
 * Copyright (C) 2004 Christian Laursen <christian@pil.dk>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */

require(dirname(dirname(__FILE__))."/conf/config.php");
require(dirname(__FILE__)."/class.rFastTemplate.php");

$tpl = new rFastTemplate($templatedir);

$tpl->define(array("main" => "index.html"));

$lists = "";

// get top directories (domains)
$domains = array_diff(scandir($topdir), array('..', '.'));

// get second level dirs (lists)
foreach ($domains as $domain) {
    // top-level domain dir
    $domaindir = $topdir . '/' . $domain;

    if (is_dir($domaindir))
    {
        $lists .= "<h2>$domain</h2>\n<ul>";

        foreach (array_diff(scandir($domaindir), array('..', '.')) as $list)
        {
            $listurl = urlencode($domain . '/' . $list);

            $lists .= "\n\t<li><strong>" . htmlentities($list) . ':</strong>&nbsp;&nbsp;'
                   . '<a href="edit.php?list=' . $listurl
                   . '">config</a> - <a href="subscribers.php?list='
                   . $listurl . '">subscribers</a>' . "\n</li>";
        }

	$lists .= "\n</ul>";
    }
}

$tpl->assign(array("LISTS" => $lists));


$tpl->parse("MAIN","main");
$tpl->FastPrint("MAIN");

?>
