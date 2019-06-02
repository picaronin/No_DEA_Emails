<?php
/**
 *
 * No DEA Emails extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 Picaron
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace pikaron\nodeaemails\event;

/**
 * Event listener
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var \phpbb\language\language */
	protected $language;

	/**
	 * Listener constructor.
	 *
	* @param \phpbb\language\language			$language
	 *
	 * @return void
	 */
	public function __construct
	(
		\phpbb\language\language $language
	)
	{
		$this->language				= $language;
	}

	/**
	* Validate No DEA Emails
	*
	* @param \phpbb\event\data $event The event object
	* @return void
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'						=> 'user_setup',
			'core.ucp_register_data_after'			=> 'ucp_user_email_data',
			'core.ucp_profile_reg_details_validate'	=> 'ucp_user_email_data',
		);
	}

	/**
	 * Load language files.
	 *
	 * @param object $event
	 *
	 * @return void
	 */
	public function user_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name'	=> 'pikaron/nodeaemails',
			'lang_set'	=> 'nodeaemails'
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * Load data event.
	 *
	 * @param object $event
	 *
	 * @return void
	 */
	public function ucp_user_email_data($event)
	{
		// Store the error and input event data
		$error = $event['error'];
		$email = $event['data'];
		$url = 'https://api.disposable-email-detector.com/api/dea/v1/check/' . $email['email'];

		if (ini_get('allow_url_fopen'))
		{
			// If there is no response, the extension not work = Disabled.
			if ($check_email = @file_get_contents($url))
			{
				$dataemail = json_decode($check_email, true);

				if (isset($dataemail['result']['isDisposable']) && $dataemail['result']['isDisposable'] == '1')
				{
					$error[] = $this->language->lang('NO_DEA_EMAILS_FOUND', $email['email']);
				}
			}
		}
		else
		{
			// If 'curl' not enabled, the extension not work = Disabled.
			if (extension_loaded('curl'))
			{
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
				$check_email = curl_exec($ch);
				curl_close($ch);

				// If there is no response, the extension not work = Disabled.
				if ($check_email)
				{
					$dataemail = json_decode($check_email, true);

					if (isset($dataemail['result']['isDisposable']) && $dataemail['result']['isDisposable'] == '1')
					{
						$error[] = $this->language->lang('NO_DEA_EMAILS_FOUND', $email['email']);
					}
				}
			}
		}

		// Update error event data
		$event['error'] = $error;
	}
}
