<?php
/**
 * Administration panel - Rights editor
 *
 * @package Cotonti
 * @version 0.7.0
 * @author Neocrome, Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2009
 * @license BSD
 */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('users', 'a');
$usr['isadmin'] &= cot_auth('admin', 'a', 'A');
cot_block($usr['isadmin']);

$t = new XTemplate(cot_skinfile('admin.rights'));

$g = cot_import('g', 'G', 'INT');
$advanced = cot_import('advanced', 'G', 'BOL');

$L['adm_code']['admin'] = $L['Administration'];
$L['adm_code']['comments'] = $L['Comments'];
$L['adm_code']['forums'] = $L['Forums'];
$L['adm_code']['index'] = $L['Home'];
$L['adm_code']['message'] = $L['Messages'];
$L['adm_code']['page'] = $L['Pages'];
$L['adm_code']['pfs'] = $L['PFS'];
$L['adm_code']['plug'] = $L['Plugins'];
$L['adm_code']['pm'] = $L['Private_Messages'];
$L['adm_code']['polls'] = $L['Polls'];
$L['adm_code']['ratings'] = $L['Ratings'];
$L['adm_code']['users'] = $L['Users'];

/* === Hook === */
foreach (cot_getextplugins('admin.rights.first') as $pl)
{
	include $pl;
}
/* ===== */

if ($a == 'update')
{
	$ncopyrightsconf = cot_import('ncopyrightsconf', 'P', 'BOL');
	$ncopyrightsfrom = cot_import('ncopyrightsfrom', 'P', 'INT');

	/* === Hook === */
	foreach (cot_getextplugins('admin.rights.update') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if ($ncopyrightsconf && !empty($cot_groups[$ncopyrightsfrom]['title']) && $g > 5)
	{
		$cot_db->delete($db_auth, "auth_groupid=$g");
		cot_auth_add_group($g, $ncopyrightsfrom);
		cot_auth_clear('all');

		cot_message('Added');
	}
	elseif (is_array($_POST['auth']))
	{
		$mask = array();
		$auth = cot_import('auth', 'P', 'ARR');

		$cot_db->update($db_auth, array('auth_rights' => 0), "auth_groupid=$g");

		foreach ($auth as $k => $v)
		{
			foreach ($v as $i => $j)
			{
				if (is_array($j))
				{
					$mask = 0;
					foreach ($j as $l => $m)
					{
						$mask += cot_auth_getvalue($l);
					}
					$cot_db->update($db_auth, array('auth_rights' => $mask),
						"auth_groupid=? AND auth_code=? AND auth_option=?", array($g, $k, $i));
				}
			}
		}

		cot_auth_reorder();
		cot_auth_clear('all');

		cot_message('Updated');
	}
}

$jj = 1;

/* === Hook for the plugins === */
foreach (cot_getextplugins('admin.rights.main') as $pl)
{
	include $pl;
}
/* ===== */

$adminpath[] = ($advanced) ? array(cot_url('admin', 'm=rights&g='.$g.'&advanced=1'), $L['Rights']." / ".htmlspecialchars($cot_groups[$g]['title'])." (".$L['More'].")") : array(cot_url('admin', "m=rights&g=".$g), $L['Rights']." / ".htmlspecialchars($cot_groups[$g]['title']));

$adv_columns = ($advanced) ? 8 : 4;

// Common tags
$t->assign(array(
	'ADMIN_RIGHTS_FORM_URL' => cot_url('admin', 'm=rights&a=update&g='.$g.$adv_for_url),
	'ADMIN_RIGHTS_ADVANCED_URL' => cot_url('admin', 'm=rights&g='.$g.'&advanced=1'),
	'ADMIN_RIGHTS_SELECTBOX_GROUPS' => cot_selectbox_groups(4, 'ncopyrightsfrom', array('5', $g)),
	'ADMIN_RIGHTS_ADV_COLUMNS' => $adv_columns,
	'ADMIN_RIGHTS_4ADV_COLUMNS' => 4 + $adv_columns
));

// Preload module langfiles
foreach ($cot_modules as $code => $mod)
{
	if (file_exists(cot_langfile($code, 'module')))
	{
		cot_require_lang($code, 'module');
	}
}

// The core and modules top-level
$sql = $cot_db->query("SELECT a.*, u.user_name FROM $db_core AS c
LEFT JOIN $db_auth AS a ON c.ct_code=a.auth_code
LEFT JOIN $db_users AS u ON u.user_id=a.auth_setbyuserid
WHERE auth_groupid='$g' AND auth_option = 'a'
ORDER BY auth_code ASC");
while ($row = $sql->fetch())
{
	if ($row['auth_code'] == 'admin' || $row['auth_code'] == 'index')
	{
		$link = cot_url($row['auth_code']);
	}
	elseif ($row['auth_code'] == 'message')
	{
		$link = '#';
	}
	else
	{
		$link = cot_url('admin', "m=".$row['auth_code']);
	}

	$title = $L['adm_code'][$row['auth_code']];
	$title = empty($title) ? $L[$row['auth_code'] . '_title'] : $title;
	cot_rights_parseline($row, $title, $link);
}
$sql->closeCursor();
$t->assign('RIGHTS_SECTION_TITLE', $L['Core'] . ' &amp; ' . $L['Modules']);
$t->parse('MAIN.RIGHTS_SECTION');


// Structure permissions
$sql = $cot_db->query("SELECT a.*, u.user_name, s.structure_path FROM $db_auth as a
	LEFT JOIN $db_users AS u ON u.user_id=a.auth_setbyuserid
	LEFT JOIN $db_structure AS s ON s.structure_code=a.auth_option
	WHERE auth_groupid='$g' AND auth_code='page' AND auth_option != 'a'
	ORDER BY structure_path ASC");
while ($row = $sql->fetch())
{
	$link = cot_url('admin', 'm=page');
	$title = $cot_cat[$row['auth_option']]['tpath'];
	cot_rights_parseline($row, $title, $link);
}
$sql->closeCursor();
$t->assign('RIGHTS_SECTION_TITLE', $L['Structure']);
$t->parse('MAIN.RIGHTS_SECTION');

// Module items permissions are pluggable
/* === Hook for the plugins === */
foreach (cot_getextplugins('admin.rights.modules') as $pl)
{
	include $pl;
}
/* ===== */

// Plugin permissions
$sql = $cot_db->query("SELECT a.*, u.user_name FROM $db_auth as a
	LEFT JOIN $db_users AS u ON u.user_id=a.auth_setbyuserid
	WHERE auth_groupid='$g' AND auth_code='plug'
	ORDER BY auth_option ASC");
while ($row = $sql->fetch())
{
	$link = cot_url('admin', 'm=plug&a=details&pl='.$row['auth_option']);
	$title = $L['Plugin'].' : '.$row['auth_option'];
	cot_rights_parseline($row, $title, $link);
}
$sql->closeCursor();
$t->assign('RIGHTS_SECTION_TITLE', $L['Plugins']);
$t->parse('MAIN.RIGHTS_SECTION');

/* === Hook for the plugins === */
foreach (cot_getextplugins('admin.rights.end') as $pl)
{
	include $pl;
}
/* ===== */

$adv_for_url = ($advanced) ? '&advanced=1' : '';

cot_display_messages($t);

/* === Hook === */
foreach (cot_getextplugins('admin.rights.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
if (COT_AJAX)
{
	$t->out('MAIN');
}
else
{
	$adminmain = $t->text('MAIN');
}

$t->parse('RIGHTS_HELP');
$adminhelp = $t->text('RIGHTS_HELP');

function cot_rights_parseline($row, $title, $link)
{
	global $L, $advanced, $t, $out;

	$mn['R'] = 1;
	$mn['W'] = 2;

	$mn['1'] = 4;

	if ($advanced)
	{
		$mn['2'] = 8;
		$mn['3'] = 16;
		$mn['4'] = 32;
		$mn['5'] = 64;
	}
	else
	{
		$rv['2'] = 8;
		$rv['3'] = 16;
		$rv['4'] = 32;
		$rv['5'] = 64;
	}
	$mn['A'] = 128;

	foreach ($mn as $code => $value)
	{
		$state[$code] = (($row['auth_rights'] & $value) == $value) ? TRUE : FALSE;
		$locked[$code] = (($row['auth_rights_lock'] & $value) == $value) ? TRUE : FALSE;
		$out['tpl_rights_parseline_locked'] = $locked[$code];
		$out['tpl_rights_parseline_state'] = $state[$code];

		$t->assign(array(
			'ADMIN_RIGHTS_ROW_ITEMS_NAME' => 'auth['.$row['auth_code'].']['.$row['auth_option'].']['.$code.']',
			'ADMIN_RIGHTS_ROW_ITEMS_CHECKED' => ($state[$code]) ? " checked=\"checked\"" : '',
			'ADMIN_RIGHTS_ROW_ITEMS_DISABLED' => ($locked[$code]) ? " disabled=\"disabled\"" : ''
		));
		$t->parse('MAIN.RIGHTS_SECTION.RIGHTS_ROW.RIGHTS_ROW_ITEMS');
	}

	if (!$advanced)
	{
		$preserve = '';
		foreach ($rv as $code => $value)
		{
			if (($row['auth_rights'] & $value) == $value)
			{
				$preserve .= '<input type="hidden" name="auth['.$row['auth_code'].']['.$row['auth_option'].']['.$code.']" value="1" />';
			}
		}
		$t->assign('ADMIN_RIGHTS_ROW_PRESERVE', $preserve);
	}

	$t->assign(array(
		'ADMIN_RIGHTS_ROW_AUTH_CODE' => $row['auth_code'],
		'ADMIN_RIGHTS_ROW_TITLE' => $title,
		'ADMIN_RIGHTS_ROW_LINK' => $link,
		'ADMIN_RIGHTS_ROW_RIGHTSBYITEM' => cot_url('admin', 'm=rightsbyitem&ic='.$row['auth_code'].'&io='.$row['auth_option']),
		'ADMIN_RIGHTS_ROW_USER' => cot_build_user($row['auth_setbyuserid'], htmlspecialchars($row['user_name'])),
	));
	$t->parse('MAIN.RIGHTS_SECTION.RIGHTS_ROW');
}

?>