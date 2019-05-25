<?php
/**
 *
 * No DEA Emails extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 Picaron
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace pikaron\nodeaemails\migrations;

class v100_rc2 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\pikaron\nodeaemails\migrations\v100_rc1');
	}

	public function update_data()
	{
		return array(
			array('config.update', array('nodeaemails_version', '1.0.0 rc2')),
			array('config.remove', array('nodeaemails_apikey')),
			array('if', array(
				array('module.exists', array('acp', false, 'ACP_NO_DEA_EMAILS_SETTINGS')),
				array('module.remove', array('acp', false, 'ACP_NO_DEA_EMAILS_SETTINGS')),
			)),
			array('if', array(
				array('module.exists', array('acp', false, 'ACP_NO_DEA_EMAILS')),
				array('module.remove', array('acp', false, 'ACP_NO_DEA_EMAILS')),
			)),
		);
	}
}
