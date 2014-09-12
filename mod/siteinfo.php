<?php

function siteinfo_init(&$a) {

	if ($a->argv[1]=="json"){
		$register_policy = Array('REGISTER_CLOSED', 'REGISTER_APPROVE', 'REGISTER_OPEN');

		$sql_extra = '';

		$r = q("select * from channel left join account on account_id = channel_account_id where ( account_roles & 4096 ) and account_default_channel = channel_id");


		if($r) {
			$admin = array();
			foreach($r as $rr) {
				$admin[] = array( 'name' => $rr['channel_name'], 'address' => $rr['channel_address'] . '@' . get_app()->get_hostname(), 'channel' => z_root() . '/channel/' . $rr['channel_address']);
			}
		}
		else {
			$admin = false;
		}

		$visible_plugins = array();
		if(is_array($a->plugins) && count($a->plugins)) {
			$r = q("select * from addon where hidden = 0");
			if(count($r))
				foreach($r as $rr)
					$visible_plugins[] = $rr['name'];
		}

		if(@is_dir('.git') && function_exists('shell_exec'))
			$commit = trim(@shell_exec('git log -1 --format="%h"'));
		if(! isset($commit) || strlen($commit) > 16)
			$commit = '';

		$site_info = get_config('system','info');
		$site_name = get_config('system','sitename');

		$data = Array(
			'version' => RED_VERSION,
			'commit' => $commit,
			'url' => z_root(),
			'plugins' => $visible_plugins,
			'register_policy' =>  $register_policy[$a->config['system']['register_policy']],
			'diaspora_emulation' => get_config('system','diaspora_enabled'),
			'rss_connections' => get_config('system','feed_contacts'),
			'admin' => $admin,
			'site_name' => (($site_name) ? $site_name : ''),
			'platform' => RED_PLATFORM,
			'info' => (($site_info) ? $site_info : '')
		);

		json_return_and_die($data);
	}
}



function siteinfo_content(&$a) {

	if(! get_config('system','hidden_version_siteinfo')) {
		$version = sprintf( t('Version %s'), RED_VERSION );
		if(@is_dir('.git') && function_exists('shell_exec'))
			$commit = @shell_exec('git log -1 --format="%h"');
		if(! isset($commit) || strlen($commit) > 16)
			$commit = '';
	}
	else {
	        $version = $commit = '';
	}
	$visible_plugins = array();
	if(is_array($a->plugins) && count($a->plugins)) {
		$r = q("select * from addon where hidden = 0");
		if(count($r))
			foreach($r as $rr)
				$visible_plugins[] = $rr['name'];
	}

	$plugins_list = '';
	if(count($visible_plugins)) {
	        $plugins_text = t('Installed plugins/addons/apps:');
		$sorted = $visible_plugins;
		$s = '';
		sort($sorted);
		foreach($sorted as $p) {
			if(strlen($p)) {
				if(strlen($s)) $s .= ', ';
				$s .= $p;
			}
		}
		$plugins_list .= $s;
	}
	else
		$plugins_text = t('No installed plugins/addons/apps');

	$admininfo = bbcode(get_config('system','admininfo'));

	if(file_exists('doc/site_donate.html'))
		$donate .= file_get_contents('doc/site_donate.html');

	$o = replace_macros(get_markup_template('siteinfo.tpl'), array(
                '$title' => t('Red'),
		'$description' => t('This is a hub of the Red Matrix - a global cooperative network of decentralized privacy enhanced websites.'),
		'$version' => $version,
		'$commit' => $commit,
		'$web_location' => t('Running at web location') . ' ' . z_root(),
		'$visit' => t('Please visit <a href="http://getzot.com">GetZot.com</a> to learn more about the Red Matrix.'),
		'$bug_text' => t('Bug reports and issues: please visit'),
		'$bug_link_url' => 'https://github.com/friendica/red/issues',
		'$bug_link_text' => 'redmatrix issues',
		'$contact' => t('Suggestions, praise, etc. - please email "redmatrix" at librelist - dot com'),
		'$donate' => $donate,
		'$adminlabel' => t('Site Administrators'),
		'$admininfo' => $admininfo,
		'$plugins_text' => $plugins_text,
		'$plugins_list' => $plugins_list
        ));

	call_hooks('about_hook', $o); 	

	return $o;

}
