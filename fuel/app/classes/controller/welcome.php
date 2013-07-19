<?php

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 * 
 * @package  app
 * @extends  Controller
 */
class Controller_Welcome extends Controller_Base
{

	/**
	 * The basic welcome message
	 * 
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
	
		list($driver, $user_id) = Auth::get_user_id();
		$this_user = Model_User::find($user_id);
		
		$latest_news_q = Model_News::query()->where('call_center_id', $this_user->call_center_id)->or_where('call_center_id', 0)->order_by('created_at', 'DESC');
		
		if( $latest_news_q->count() > 0 ) {
			$latest_news = $latest_news_q->get();
		} else {
			$latest_news = null;
		}
		
		
		$invalid_logins_q = Model_Users_Log_Login::query()->where('user_id', $user_id)->where('status', 2)->order_by('login_time', 'DESC');
		
		if( $invalid_logins_q->count() > 0 ) {
			$invalid_logins = $invalid_logins_q->get();
		} else {
			$invalid_logins = null;
		}
		
		
	
		$this->template->title = 'Projects &raquo; Index';
		$this->template->content = View::forge('welcome/index', array('invalid_logins'=>$invalid_logins, 'latest_news' => $latest_news))->auto_filter(FALSE);
	}

	/**
	 * The 404 action for the application.
	 * 
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
		return Response::forge(ViewModel::forge('welcome/404'), 404);
	}
}
