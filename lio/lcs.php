<link href="../css/style.css" rel="stylesheet" />
<html>
<body>
<form name="frmr" action="../ini/lq.htm" method="get" target="_parent"></form>
<?php
	session_start();
	session_destroy();
	/*$v = session_unregister('sGru');
	echo $v;*/
?>
<script language="javascript">
	document.frmr.submit();
</script>
</body>
</html>
