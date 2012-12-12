<?php

	namespace Fuel\Tasks;
	
	class Datascrape
	{
		
		private static $current_max_count = 1;
		
		
		public function run()
		{
			ini_set('user_agent', 'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-GB; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11');
			//ini_set('output_buffering','0');
			
			$mtime = microtime(); 
			$mtime = explode(" ",$mtime); 
			$mtime = $mtime[1] + $mtime[0]; 
			$starttime = $mtime;
			
			$sessionCount = 0;
			
			
			ob_end_flush();
			
			$surname = Datascrape::get_new_surname();
			
			
			$proxy_count = \Model_Proxy::find()->where('fail_count', '<', static::$current_max_count);
			
			while ($proxy_count->count() == 0)
			{
				static::$current_max_count++;
				echo "Proxy Count Now: ".static::$current_max_count;
				@ob_flush();
				$proxy_count = \Model_Proxy::find()->where('fail_count', '<', static::$current_max_count);
			}
			
			while ($surname && $proxy_count->count()>0) {
				
				$town = Datascrape::get_next_search($surname['last_town']);
				
				$html = Datascrape::get_html_dom($surname['surname'], $town['town']);
							
				if (!is_object($html))
				{
					echo "No Content\n";
					print $html;
				} 
				else 
				{
					$pagesArray = $html->find(".pages a");
					
					if (count($pagesArray) > 0) {
						$totalPages = $pagesArray[count($pagesArray)-2];
	
						$totalPageNumbers = (int)$totalPages->plaintext;
					} else {
						$totalPageNumbers = 1;
					}
					
					echo $surname['surname']."'s in ".$town['town']."\n";
					@ob_flush();
					
					$results = Array();
					$runningCount = 0;
					
					$got_error = FALSE;
					for ($i = 1; $i <= $totalPageNumbers; $i++) {
						$proxy_count = \Model_Proxy::find()->where('fail_count', '<', static::$current_max_count);
						if ($i > 1) {
							$html = Datascrape::get_html_dom($surname['surname'], $town['town'], $i);
						}
						
						if (!is_object($html))
						{
							$got_error = TRUE;
						}
						else
						{
						
							foreach ($html->find(".searchResult") AS $e) {
		
								$name = explode(" ", Datascrape::cleanString(@$e->find("h2",0)->plaintext));
		
								$singleResult['surname'] = array_shift($name);
								$singleResult['forename'] = implode(" ", $name);
		
								$address = explode("<br />", Datascrape::cleanString(@$e->find(".address",0)->innertext));
		
								$singleResult['add1'] = (isset($address[0])) ? $address[0] : "";
								$singleResult['add2'] = (isset($address[1])) ? $address[1] : "";
								$singleResult['postcode'] = (isset($address[2])) ? Datascrape::cleanString($address[2], TRUE) : '';
		
								$tmpTel = @Datascrape::cleanString($e->find(".telephoneNumber",0)->plaintext, TRUE);
		
								$singleResult['telephone'] = (substr($tmpTel, 0, 1) == 0) ? substr($tmpTel, 1) : $tmpTel;
		
								$results[] = $singleResult;
								echo ".";
								@ob_flush();
							}
				
						}
						
						echo "\n";
						@ob_flush();
						
					}
					
					
					// Loop through all results and add to database
					foreach ($results AS $result)
					{
						
						if (!Datascrape::is_dupe($result['forename'],$result['telephone']))
						{
							$sessionCount++;
							$new = new \Model_Selfgeneration();
							$new->fname = $result['forename'];
							$new->sname = $result['surname'];
							$new->add1 = $result['add1'];
							$new->add2 = $result['add2'];
							$new->postcode = $result['postcode'];
							$new->telephone = $result['telephone'];
							$new->save();
						}
					
					}
					
					if (!$got_error)
					{
						$update_surname = \Model_Surname::find($surname['id']);
						$update_surname->last_town = $town['id'];
						$update_surname->save();
					}
					
				}
			
			
				$mtime = microtime(); 
				$mtime = explode(" ",$mtime); 
				$mtime = $mtime[1] + $mtime[0]; 
				$endtime = $mtime; 
				$totaltime = ($endtime - $starttime);
				
				$timeMins = ($totaltime/60);
			
				$total = \Model_Selfgeneration::find()->count();
				echo number_format($sessionCount,0)." This Session. ".number_format($total,0)." To Date.\n".number_format((int)ceil(($sessionCount / $timeMins)),0)." Per Minute. ".number_format(((int)ceil(($sessionCount / $timeMins))*60),0)." Per Hour. ".number_format((((int)ceil(($sessionCount / $timeMins))*60)*24),0)." Per Day.";
				
				echo "\n\n";
				@ob_flush();
				
				$surname = Datascrape::get_new_surname();
				$proxy_count = \Model_Proxy::find()->where('fail_count', '<', '6');
			}
						
		}
		
		
		
		public function send_push_message($message)
		{
		/*
			$payload = array(
				'aps' => array(
					'alert' => $message,
					'sound' => 'default',
				),
			);
			
			$session = curl_init('https://go.urbanairship.com/api/push/broadcast/'); 
			curl_setopt($session, CURLOPT_USERPWD, 'GpZjIhawQzKqPls_0tkVWg:NjFiOL2sR56rZNYPTVPrKg'); 
			curl_setopt($session, CURLOPT_POST, True); 
			curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($payload)); 
			curl_setopt($session, CURLOPT_HEADER, False); 
			curl_setopt($session, CURLOPT_RETURNTRANSFER, True); 
			curl_setopt($session, CURLOPT_HTTPHEADER, array('Content-Type:application/json')); 
			$content = curl_exec($session); 
			*/
			
		}
		
		
		
		private function is_dupe($firstname, $telephone)
		{
			$check = \Model_Selfgeneration::find()->where('telephone', $telephone)->where('fname', $firstname);
			return ( ($check->count()) > 0) ? true : false;
		}
		
		
		private function get_html_dom($surname, $town, $page_number=1)
		{
			date_default_timezone_set('Europe/London');
			$html = null;
			
			while (!is_object($html))
			{
				
				$proxy_query = \Model_Proxy::find()->where('fail_count', '<', static::$current_max_count)->order_by('use_count','asc')->limit(1);
				
				while ($proxy_query->count() == 0)
				{
					static::$current_max_count++;
					echo "Proxy Count Now: ".static::$current_max_count;
					@ob_flush();
					$proxy_query = \Model_Proxy::find()->where('fail_count', '<', static::$current_max_count);
				}
				
				if ($proxy_query->count() > 0)
				{
					$count = $proxy_query->count();
					
					
					if ($count < 50 AND static::$current_max_count == 1)
					{
						$previous_alerts = \Model_Adam_Announcement::find()->where('campaign', 'NULL')->where('alert_type', 'PROXY-50');
					
						if ($previous_alerts->count() == 0)
						{
							Datascrape::send_push_message("Just so you know, there are less than 50 fresh proxies available to use!");
							
							$adam_announcement = \Model_Adam_Announcement::forge(array(
								'campaign' => "NULL",
								'alert_type' => "PROXY-50",
								'remove_date' => date("Y-m-d H:i:s",strtotime("+15 minutes")),
							));
							$adam_announcement->save();
						
						}
					}
					
					
					$proxy = $proxy_query->get_one();
					echo "Trying Proxy (from ".$count.") - " . $proxy->host.":".$proxy->port;
					$html = \Simple_Html_Dom\helper::file_get_html(
						'http://www.118.com/people-search.mvc?Supplied=true&Name='.$surname.'&Location='.$town.'&pageSize=50&pageNumber='.$page_number, 
						false,
						stream_context_create(
							array(
								'http' => array(
									'proxy' => $proxy->host.":".$proxy->port,
									'request_fulluri' => true,
									'timeout' => 10,
									'method' => "GET",
									'header' => "Accept-language: en\r\n" .
							                    "Cookie: foo=bar\r\n" .
							                    "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.13 (KHTML, like Gecko) Chrome/9.0.597.107 Safari/534.13\r\n",
								),
							)
						)
					);
				
					if (!is_object($html))
					{
						$proxy->use_count = $proxy->use_count + 1;
						$proxy->fail_count = $proxy->fail_count + 1;
						$proxy->save();
						echo " - Failed\n";
						@ob_flush();
					}
					else
					{	
						$proxy->use_count = $proxy->use_count + 1;
						$proxy->save();
						echo " - Passed\n";
					}
				
					
				}
				else
				{
					$html = "NOPROXY";
				}
			
			}
			
			return $html;
			
			
		}
		
		
		private function get_next_search($last_search)
		{
			$town = \Model_Town::find()->where('id', '>', $last_search)->order_by('id','asc')->limit(1)->get_one();
			return $town;
		}
		
		private function get_new_surname()
		{
			$surnames = \Model_Surname::find()->where('completed', 0)->get();
			
			if (count($surnames) == 0)
			{
				return false;
			}
			else
			{
				$rand_surname = array();
				foreach ($surnames AS $surname)
				{
					$rand_surname[] = $surname;
				}
				
				return $rand_surname[rand(0,(count($rand_surname)-1))];
			}
		}
		
		
		private function cleanString($string, $andSpace = FALSE)
		{
			$string = str_replace(Array("/t","/n","                  "), Array("","",""), $string);
			if ($andSpace) $string = str_replace(" ","",$string);
			return $string;
		}
		
		
	}