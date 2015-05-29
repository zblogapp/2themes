<?php
#注册插件
RegisterPlugin('2themes', 'ActivePlugin_2themes');

function ActivePlugin_2themes() {
	Add_Filter_Plugin('Filter_Plugin_Admin_ThemeMng_SubMenu', 'Admin_ThemeMng_SubMenu_2themes');
	Add_Filter_Plugin('Filter_Plugin_Index_Begin', 'index_begin_2themes');

}

function Admin_ThemeMng_SubMenu_2themes() {
	global $zbp;
	?>
<script type="text/javascript">
$(document).ready(function() {
	$(".theme-name").each(function() {
		var me = $(this),
			img = $("<img>"),
			a = $("<a>");

		img.attr("src", bloghost + "zb_system/image/admin/brick.png")
		   .attr("title", "将该主题设置为手机版主题")
		   .attr("alt", "将该主题设置为手机版主题");

		a.attr("href", bloghost + "zb_users/plugin/2themes/save.php?action=change_theme&theme=" + me.find("strong").text())
		 .attr("target", "_blank")
		 .attr("title", "将该主题设置为手机版主题")
		 .css("float", "right")
		 .css("display", "inline-block")
		 .addClass("button")
		 .append(img)
		 .appendTo(me);

	});

	$("[data-themeid='<?php echo $zbp->Config('2themes')->theme?>']")
		.css("background", '#FFB3A7');
});
</script>
<?php
}

function InstallPlugin_2themes() {

	global $zbp;
	$zbp->Config('2themes')->version = '0.8';
	if (!$zbp->Config('2themes')->HasKey('theme')) {
		$zbp->Config('2themes')->theme = $zbp->theme;
		$zbp->Config('2themes')->css = $zbp->style;
	}
	$zbp->SaveConfig('2themes');

}

function UninstallPlugin_2themes() {

}

function index_begin_2themes() {

	$regex = '/android|adr|iphone|ipad|windows\sphone|kindle|gt\-p|gt\-n|rim\stablet|opera|meego/i';

	//UC浏览器是傻逼！
	$mobile = false;
	if (GetVars('alwaystheme', 'COOKIE') == 'mobile') {
		$mobile = true;
	}

	if (preg_match($regex, GetVars('HTTP_USER_AGENT', 'SERVER'))) {
		$mobile = true;
	}

	if (GetVars('alwaystheme', 'COOKIE') == 'pc') {
		$mobile = false;
	}

	if ($mobile) {
		global $zbp;
		changetheme_2themes($zbp->Config('2themes')->theme, $zbp->Config('2themes')->css);
	}
}

function changetheme_2themes($theme, $css) {

	global $zbp;
	global $usersdir;

	/*
	$app = new App;
	if ($theme == '') exit;
	if (!is_dir($dir)) exit;
	if(!$app->LoadInfoByXml('theme', $theme)) exit;
	 */

	$dir = $usersdir . 'theme/' . $theme;

	$zbp->Config('system')->ZC_BLOG_THEME = $theme;
	$zbp->option['ZC_BLOG_THEME'] = $theme;
	$zbp->activeapps[0] = $theme;

	$zbp->Config('system')->ZC_BLOG_CSS = $css;
	$zbp->option['ZC_BLOG_CSS'] = $css;

	if (is_readable($filename = $dir . '/include.php')) {
		require $filename;
		if (isset($GLOBALS['plugins'][$theme])) {
			$func_name = $GLOBALS['plugins'][$theme];
			if (function_exists($func_name)) {
				$func_name();
			}

		}
	}

	$zbp->LoadTemplate();
	$zbp->MakeTemplatetags();
	$zbp->template = $zbp->PrepareTemplate();

}