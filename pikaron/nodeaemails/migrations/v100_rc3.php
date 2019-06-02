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

class v100_rc3 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\pikaron\nodeaemails\migrations\v100_rc2');
	}

	public function update_data()
	{
		return array(
			array('config.update', array('nodeaemails_version', '1.0.0 rc3')),
		);
	}
}
