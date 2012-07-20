<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Type: BBcode
| Name: Chart
| Version: 1.00
| Author: Valerio Vendrame (lelebart)
+--------------------------------------------------------+
| Filename: chart.php
| Author: Valerio Vendrame (lelebart)
+--------------------------------------------------------+
| Language: English (EN, US)
| Author / Transaltor: Valerio Vendrame (lelebart)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
$locale['bb_chart'] = "Chart";
$locale['bb_chart_description'] = "Make a chart using Google Chart API.";
$locale['bb_chart_usage'] = "[chart {arguments}](title)[/chart] or [chart]datas (labels (title))[/chart]";

/*** Valid usage of the bbcode ***

[chart data='69,18,2,11' labels="PHP,JavaScript,XHTML,CSS" colors='058DC7,50B432,ED561B,EDEF00' advanced='chts=3d3d3d,18,l' bgcolor=bg,s,fafafa|c,s,f3f3f3 size=600x300]** PHP-Fusion chart bbcode, for PHP >= 5.3 ** --using Google Chart Image API[/chart]

[chart data='20,30,50' bgcolor=000][/chart]

[chart size=100 data=100]alone[/chart]

[chart]30,30,30,10[/chart]

[chart]60,30,10
Grain, Eggs, Oil[/chart]

[chart]33,33,33
Prosecco, Select, Seltz
Spritz[/chart]

**********************************/
?>
