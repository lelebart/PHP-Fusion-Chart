+------------------------------------------------------+
| Type: ...... BBcode
| Name: ...... Chart
| Version: ... 1.00
| Author: .... Valerio Vendrame (lelebart)
| Released: .. Nov, 21st 2011
| Download: .. http://php-fusion.it
+------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+------------------------------------------------------+

	/************************************************\
	
		Table of Contents
		- Description
		- Installation
		- Usage
		- Notes
		
	\************************************************/

+-------------+
| DESCRIPTION |
+-------------+

With this BBcode you can create charts using the Google Chart Image API.


+--------------+
| INSTALLATION |
+--------------+

1. Upload all files and folders to your ftp root;
2. Go to Admin -> System Administration -> BBCodes and 
3. just enable "Chart" BBCode, that's it!


+-------+
| USAGE |
+-------+

Chart BBcode becomes with an innovative way to manage multiple parmaters, the available ones are:
  * data       =  empty by default, needed to build the chart: numeric datas must be separated by comma
  * colors     =  empty by default, optional to pimp bars, lines or slices: colors must be in written in the hex rappresentation, and must be separated by comma
  * size       =  '400x200' by default, could be a number or a pair, joint by a 'x' symbol {width}x{height}: values cannot be greater than 1000
  * bgcolor    =  'ffffff' by default, could be a hex color or a string in the format allowed by Google
  * title      =  empty by default, type the otpional title: carriage return with '--'
  * labels     =  empty by default, labels for each data
  * advanced   =  empty by default, the space for creative usage, feel free to use every parameters Google accepts: write them as a GET query
  * type       =  'pie' by default, mnemonic name (line, xyline, sparkline, meter, scatter, venn, pie and pie2d) or directly Google's one

The following are all valid usages of the Chart BBcode:

[chart data='69,18,2,11' labels="PHP,JavaScript,XHTML,CSS" colors='058DC7,50B432,ED561B,EDEF00' advanced='chts=3d3d3d,18,l' bgcolor=bg,s,fafafa|c,s,f3f3f3 size=600x300]** PHP-Fusion chart bbcode, for PHP >= 5.3 ** --using Google Chart Image API[/chart]

[chart data='20,30,50' bgcolor=000][/chart]

[chart size=100 data=100]alone[/chart]

[chart]30,30,30,10[/chart]

[chart]60,30,10
Grain, Eggs, Oil[/chart]

[chart]33,33,33
Prosecco, Select, Seltz
Spritz[/chart]


+-------+
| NOTES |
+-------+

IMPORTANT: A version of PHP major or equal to 5.3 is required to work.
Please refer the official page on Google for advanced use: http://code.google.com/intl/it-IT/apis/chart/image/docs/making_charts.html