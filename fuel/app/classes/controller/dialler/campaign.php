<?php
class Controller_Dialler_Campaign extends Controller_BaseHybrid 
{

	public function action_index()
	{
		$data['dialler_campaigns'] = Model_Dialler_Campaign::find('all');
		$this->template->title = "Dialler_campaigns";
		$this->template->content = View::forge('dialler/campaign/index', $data);

	}

	public function action_view($id = null)
	{
		$data['dialler_campaign'] = Model_Dialler_Campaign::find($id);

		is_null($id) and Response::redirect('Dialler_Campaign');

		$this->template->title = "Dialler_campaign";
		$this->template->content = View::forge('dialler/campaign/view', $data);

	}
	
	public function action_allcalls()
	{
		date_default_timezone_set('Europe/London');
		
		$this->template->title = "View Campaign Calls";
		$this->template->content = View::forge('dialler/campaign/calls');
	}
	
	public function get_liveview($campaign)
	{
		date_default_timezone_set('Europe/London');
		
		$time_limit = $this->param('showtime');
		
		
		$stats = \Model_Dialler_Campaign_Call::find()->where('campaign', $campaign);
				
		if (!is_null($time_limit))
		{
			$time_strings = Array(
				'10m' => '10 minutes ago',
				'30m' => '30 minutes ago',
				'1h' => '1 hour ago',
				'2h' => '2 hours ago',
				'6h' => '6 hours ago',
				'12h' => '12 hours ago',
				'1d' => '1 day ago',
				'1w' => '1 week ago',
			);
		
			$stats = $stats->where('date', '>=', date("Y-m-d H:i:s", strtotime($time_strings[$time_limit])));
		}
		else
		{
			$stats = $stats->where('date', '>=', date("Y-m-d 08:50:00"))->where('date', '<=', date("Y-m-d 20:10:00"));
		}
		
		$stats = $stats->order_by('date','asc')->get();
		
		
		
		$calls = array(
			'label' => "Calls Made",
			'data' => array(),
		);
		$answers = array(
			'label' => "Calls Answered",
			'data' => array(),
		);
		foreach ($stats AS $stat)
		{
			$calls['data'][] = array(
				(int)strtotime($stat->date) * 1000,
				(int)$stat->calls_made
			);
			
			$answers['data'][] = array(
				(int)strtotime($stat->date) * 1000,
				(int)$stat->calls_answered
			);
		}
		
		$this->response(array(
			'calls_made' => $calls,
			'calls_answered' => $answers,
		));
		
	}
	
	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Dialler_Campaign::validate('create');
			
			if ($val->run())
			{
				$dialler_campaign = Model_Dialler_Campaign::forge(array(
					'campaign_title' => Input::post('campaign_title'),
					'campaign_name' => Input::post('campaign_name'),
					'campaign_description' => Input::post('campaign_description'),
					'call_center_id' => Input::post('call_center_id'),
				));

				if ($dialler_campaign and $dialler_campaign->save())
				{
					Session::set_flash('success', 'Added dialler_campaign #'.$dialler_campaign->id.'.');

					Response::redirect('dialler/campaign');
				}

				else
				{
					Session::set_flash('error', 'Could not save dialler_campaign.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}
		
		
		$this->template->set_global('call_centers', Arr::assoc_to_keyval(Model_Call_Center::find('all'), 'id', 'title'), false);

		$this->template->title = "Dialler_Campaigns";
		$this->template->content = View::forge('dialler/campaign/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Dialler_Campaign');

		$dialler_campaign = Model_Dialler_Campaign::find($id);

		$val = Model_Dialler_Campaign::validate('edit');

		if ($val->run())
		{
			$dialler_campaign->campaign_title = Input::post('campaign_title');
			$dialler_campaign->campaign_name = Input::post('campaign_name');
			$dialler_campaign->campaign_description = Input::post('campaign_description');
			$dialler_campaign->call_center_id = Input::post('call_center_id');

			if ($dialler_campaign->save())
			{
				Session::set_flash('success', 'Updated dialler_campaign #' . $id);

				Response::redirect('dialler/campaign');
			}

			else
			{
				Session::set_flash('error', 'Could not update dialler_campaign #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$dialler_campaign->campaign_title = $val->validated('campaign_title');
				$dialler_campaign->campaign_name = $val->validated('campaign_name');
				$dialler_campaign->campaign_description = $val->validated('campaign_description');
				$dialler_campaign->call_center_id = $val->validated('call_center_id');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('dialler_campaign', $dialler_campaign, false);
		}

		$this->template->set_global('call_centers', Arr::assoc_to_keyval(Model_Call_Center::find('all'), 'id', 'title'), false);
		
		$this->template->title = "Dialler_campaigns";
		$this->template->content = View::forge('dialler/campaign/edit');

	}

	public function action_delete($id = null)
	{
		if ($dialler_campaign = Model_Dialler_Campaign::find($id))
		{
			$dialler_campaign->delete();

			Session::set_flash('success', 'Deleted dialler_campaign #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete dialler_campaign #'.$id);
		}

		Response::redirect('dialler/campaign');

	}


}