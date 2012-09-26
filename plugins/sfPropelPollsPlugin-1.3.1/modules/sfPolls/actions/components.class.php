<?php
/**
 * sfPropelPollsPlugin components
 * 
 * @package plugins
 * @subpackage polls
 * @author Ton Sharp <Ton@66Ton99.org.ua>
 */
class sfPollsComponents extends sfComponents 
{

  /**
   * Displays poll form
   * 
   * @throws sfException
   */
  public function executePoll_form()
  {
    if (!empty($this->poll_id))
    {
      $poll = sfPollPeer::retrieveByPK($this->poll_id);
      //throw new sfException('poll_id is missing');
    } else {
      $poll = sfPollPeer::retrieveLast();
    }
    if (!$poll)
    {
      return false;
      throw new sfException('Unable to retrieve poll object');
    }
    if (!$poll->getIsPublished())
    {
      return false;
      throw new sfException('This poll is not published');
    }
    if (!$poll->getIsActive())
    {
      return false;
      throw new sfException('Votes are closed on this poll');
    }
    $this->poll = $poll;
    $user_id = sfPropelPollsToolkit::getUserPK();
    $cookie_name = 'poll' . $poll->getId();
    if (!is_null($this->getRequest()->getCookie($cookie_name)) || 
        $poll->hasUserVoted($user_id))
    {
      $this->poll_results = $poll->getResults();
    }
  }

}
