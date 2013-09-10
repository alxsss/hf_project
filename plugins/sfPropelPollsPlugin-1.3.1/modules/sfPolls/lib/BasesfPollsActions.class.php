<?php
/**
 * sfPoll base actions
 * 
 * @package plugins
 * @subpackage polls
 * @author Ton Sharp <Ton@66Ton99.org.ua>
 **/
class BasesfPollsActions extends sfActions 
{

  /**
   * Module index
   * 
   **/
  public function executeIndex()
  {
    $this->forward('sfPolls', 'list');
  }
  
  /**
   * Poll detail view
   * 
   **/
  public function executeDetail()
  {
    $poll_id = $this->getRequestParameter('id');
    $poll = sfPollPeer::retrieveByPK($poll_id);
    $this->forward404Unless($poll, $this->getContext()->getI18N()->__('Unable to retrieve poll id=') . $poll_id);
    
    // Here we check if current poll is currently published
    $this->forward404Unless($poll->getIsPublished() === true, $this->getContext()->getI18N()->__('Poll is not currently published'));
    
    // Here we check if current poll is active for voting
    if ($poll->getIsActive() === false)
    {
      $link = '@sf_propel_polls_results?id='.$poll->getId();
      if ($this->getRequestParameter('lt'))
      {
        $link .= '&lt=1';
      }
      $this->redirect($link);
    }
    
    // Here we check if a user has already voted for this poll
    // If so, we redirect him to the results view
    $user_id = sfPropelPollsToolkit::getUserPK();
    $cookie_name = 'poll'.$poll->getId();
    if (!is_null($this->getRequest()->getCookie($cookie_name)) || $poll->hasUserVoted($user_id))
    {
      $link = '@sf_propel_polls_results?id='.$poll->getId();
      if ($this->getRequestParameter('lt'))
      {
        $link .= '&lt=1';
      }
      $this->redirect($link);
    }
    $this->poll = $poll;
    $this->user_answer = $poll->getUserAnswer(sfPropelPollsToolkit::getUserPK());
    if ($this->getRequestParameter('lt'))
    {
      $this->no_neader = true;
      $this->setTemplate('_results');
      $this->setLayout(false);
    }
  }
  
  /**
   * Polls list
   * 
   **/
  public function executeList()
  {
    $c = new Criteria();
    $c->add(sfPollPeer::IS_PUBLISHED, true);
    $c->addDescendingOrderByColumn(sfPollPeer::CREATED_AT);
    $this->polls = sfPollPeer::doSelect($c);
  }
  
  /**
   * This method is executed before every action. Here we load the I18N helper
   * if it is not enabled in settings.yml. 
   * 
   */
  public function preExecute()
  {
    $loaded_helpers = sfConfig::get('sf_standard_helpers', array());
    if (!in_array('I18N', $loaded_helpers))
    {
      sfLoader::loadHelpers('I18N');
    }
    return parent::preExecute();
  }
  
  /**
   * Poll results
   * 
   **/
  public function executeResults()
  {
    $poll_id = (int)$this->getRequestParameter('id');
    $poll = sfPollPeer::retrieveByPK($poll_id);
    $this->forward404Unless($poll && $poll->getIsPublished(), $this->getContext()->getI18N()->__('Unexistant or unpublished poll #') . $poll_id);
    $this->poll = $poll;
    $this->poll_results = $poll->getResults();
    
    if ($this->getRequestParameter('lt'))
    {
      $this->no_neader = true;
      $this->setTemplate('_results');
      $this->setLayout(false);
    }
  }

  /**
   * Make a user voting for a poll
   * 
   **/
  public function executeVote()
  {
    
    $poll_id = $this->getRequestParameter('poll_id');
    $poll = sfPollPeer::retrieveByPK($poll_id);
    $answer_id = $this->getRequestParameter('answer_id');
    
    if (is_null($answer_id)) // user has forgotten to check a vote option
    {
      sfContext::getInstance()->getUser()->setFlash('notice', $this->getContext()->getI18N()->__('You must check a vote option'));
      $this->redirect('@sf_propel_polls_detail?id='.$poll->getId().'&lt=1');
    }
    
    $answer = sfPollAnswerPeer::retrieveByPK($answer_id);
    $this->forward404Unless($poll, $this->getContext()->getI18N()->__('Unable to retrieve poll id=') . $poll_id);
    $this->forward404Unless($answer, $this->getContext()->getI18N()->__('Unable to retrieve answer id=') . $answer_id);
    
    // Add vote for current user
    $user_id = sfPropelPollsToolkit::getUserPK();
    $cookie_name = 'poll'.$poll->getId();
    if (!is_null($this->getRequest()->getCookie($cookie_name)) || $poll->hasUserVoted($user_id))
    {
      sfContext::getInstance()->getUser()->setFlash('notice', $this->getContext()->getI18N()->__('You have already voted for this poll'));
      $this->redirect('@sf_propel_polls_detail?id='.$poll->getId().'&lt=1');
    }
    else
    {
      sfPollPeer::setCookie($poll->getId(), $answer->getId());
    }
    
    try
    {
      $poll->addVote($answer->getId(), $user_id);
      $message = $this->getContext()->getI18N()->__('Thanks for your vote');
    }
    catch (Exception $e)
    {
      $message = $this->getContext()->getI18N()->__('Something went wrong, we were unable to store your vote.');
      sfLogger::getInstance()->err($this->getContext()->getI18N()->__('Polling error: ') . $e->getMessage());
    }
    
    // Redirect with message
    sfContext::getInstance()->getUser()->setFlash('notice', $message);
    $this->redirect('@sf_propel_polls_results?id='.$poll->getId() . '&lt=1');
  }

}
