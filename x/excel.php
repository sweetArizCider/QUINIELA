<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "nombreArchivoQueDescarga.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

?>
<table>
<tbody>
<tr>
<th>qu_id</th>
<th>li_id</th>
<th>to_id</th>
<th>jo_id</th>
<th>jp_LEV</th>
</tr>

<tr>
<td>C2024_TI</td>
<td>ligamx</td>
<td>C2024</td>
<td>12</td>
<td>L</td>
</tr>

<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td>E</td>
</tr>

</tbody>
</table>