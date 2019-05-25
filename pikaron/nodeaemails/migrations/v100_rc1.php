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

class v100_rc1 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return !empty($this->config['nodeaemails_version']);
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\v320');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('nodeaemails_version', '1.0.0 rc1')),
			array('config.add', array('nodeaemails_apikey', '')),
		);
	}
}
