<?php

namespace GAB;

class Messages
{
	
	protected static $_imap_connections = array();
	
	
	
	
	
	
	/**
	 * Returns a unified count of unread e-mails.
	 * 
	 * @access public
	 * @static
	 * @return void
	 */
	public static function imap_count_unread()
	{
		$total_messages = 0;
		
		foreach (static::$_imap_connections AS $connection)
		{
			$imap_object    = imap_check($connection);
			$total_messages = $total_messages + (int)$imap_object->Nmsgs;
			
		}
		
		return $total_messages;
		
	}
	
	/**
	 * Create or return a connection to an imap server.
	 * 
	 * @access public
	 * @static
	 * @param mixed $id
	 * @return void
	 */
	public static function imap_connection($id)
	{
		
		if (!isset(static::$_imap_connections[$id]))
		{
			static::$_imap_connections[$id] = imap_open("{imap.1and1.co.uk:143/imap}INBOX", "support@gregsonandbrooke.co.uk", "arBgjGjkS2010");
		}
		
		return static::$_imap_connections[$id];
		
	}
	
}