<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action = 'root';
if (!$zbp->CheckRights($action)) {$zbp->ShowError(6);die();}
if (!$zbp->CheckPlugin('2themes')) {$zbp->ShowError(48);die();}

$blogtitle = '2themes';
require $blogpath . 'zb_system/admin/admin_header.php';
require $blogpath . 'zb_system/admin/admin_top.php';
?>
<div id="divMain">
  <div class="divHeader"><?php echo $blogtitle;?></div>
  <div class="SubMenu">
  </div>
  <div id="divMain2">
	<br/>
	<h2>如何使用？</h2>
	<ol>
		<li>打开主题管理</li>
		<li><img src="guide.png" alt="点击右上角" title="点击右上角" /><br/>如图所示，点击待切换的主题的右上角的按钮即可。</li>
	</ol>

	<br/>
	<br/>
	<h2>如何让手机用户切换到电脑版，或电脑用户切换到手机版？</h2>
	<p>加入以下代码：</p>
	<code>
	&lt;a href=&quot;javascript:; onclick=&quot;document.cookie='alwaystheme=mobile;';location.reload();&quot;&gt;手机版&lt;/a&gt;
	&lt;a href=&quot;javascript:; onclick=&quot;document.cookie='alwaystheme=pc;';location.reload();&quot;&gt;电脑版&lt;/a&gt;
	</code>

  </div>
</div>

<?php
require $blogpath . 'zb_system/admin/admin_footer.php';
RunTime();
?>