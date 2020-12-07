<?php
$request = request();
$pathinfo = $request->getPathInfo();

if (strpos($pathinfo, '/admin') === 0)
{
?>
@include('admin')
<?php
}
else
{
?>
@include('shop')
<?php
}
?>
