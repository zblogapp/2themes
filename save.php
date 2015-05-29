<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action = 'root';
if (!$zbp->CheckRights($action)) {$zbp->ShowError(6);die();}
if (!$zbp->CheckPlugin('2themes')) {$zbp->ShowError(48);die();}

$blogtitle = '2themes';

switch (GetVars('action', 'GET')) {
	case 'change_theme':
		save_theme(GetVars('theme', 'GET'));
		change_theme_after_load();
		echo '<script>opener.location.reload();window.close();</script>';

		break;
}

function save_theme($theme_id) {

	global $zbp;
	global $usersdir;

	$app = new App;
	$dir = $usersdir . 'theme/' . $theme_id;
	if ($theme_id == '') {
		exit;
	}

	if (!$app->LoadInfoByXml('theme', $theme_id)) {
		exit;
	}

	$zbp->Config('2themes')->theme = $theme_id;
	foreach ($app->GetCssFiles() as $key => $value) {
		$value = basename($value, '.css');
		$zbp->Config('2themes')->css = $value;
		break;
	}

	$zbp->SaveConfig('2themes');
	$zbp->SetHint('good', '手机版主题切换成功');

}

function rebuild_theme() {

	global $zbp;
	$theme_id = $zbp->Config('2themes')->theme;

}

function change_theme_after_load() {

	global $zbp;
	changetheme_2themes($zbp->Config('2themes')->theme, $zbp->Config('2themes')->css);
	$zbp->BuildTemplate();

}

RunTime();
