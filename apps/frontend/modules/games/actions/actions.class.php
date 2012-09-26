<?php

/**
 * games actions.
 *
 * @package    hemsinif
 * @subpackage games
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class gamesActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->game_cats = GameCategoryPeer::doSelect(new Criteria());
    $this->game_list = GamePeer::doSelect(new Criteria());
  }

  public function executeCategory(sfWebRequest $request)
  {
    $this->forward404Unless($this->game_cat = GameCategoryPeer::retrieveByPk($request->getParameter('id')), sprintf('Object game does not exist (%s).', $request->getParameter('id')));
    $page=$this->getRequestParameter('page', 1);
    $this->games = GameCategoryPeer::getCategoryGames($page, $this->game_cat->getId());
  }
   public function executeShow(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated())
    {
      $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
      $this->forward404Unless($this->game = GamePeer::retrieveByPk($request->getParameter('id')), sprintf('Object game does not exist (%s).', $request->getParameter('id')));
      $c=new Criteria();
      $c->add(GameUserPeer::USER_ID, $this->user_id);
      $c->add(GameUserPeer::GAME_ID, $request->getParameter('id'));
      $game_user=GameUserPeer::doSelectOne($c);
      if(empty($game_user))
      {
        $game_user=new GameUser();
        $game_user->setUserId($this->user_id);
        $game_user->setGameId($request->getParameter('id'));
      }
      else
      {
         $game_user->setCreatedAt(time());
      }
      $game_user->save();   
    }
    else
    {
      return $this->forward('sfGuardAuth','signin');
    } 
  }
  public function executeAllgames()
   {
    $this->page=$this->getRequestParameter('page', 1);
    $this->photo_owner = sfGuardUserPeer::retrieveByUsername($this->getRequestParameter('username'));
    $this->forward404Unless($this->photo_owner);
    //id of a user whose photos are retrived
    $photo_owner_user_id=$this->photo_owner->getId();
    $this->games=GamePeer::getAllUserGamesPager($this->page, $photo_owner_user_id);
    //id of a user who signed in
    $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
   }
/*   public function executeNew(sfWebRequest $request)
  {
    $this->form = new GameForm();
  }
public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new GameForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($game = GamePeer::retrieveByPk($request->getParameter('id')), sprintf('Object game does not exist (%s).', $request->getParameter('id')));
    $this->form = new GameForm($game);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($game = GamePeer::retrieveByPk($request->getParameter('id')), sprintf('Object game does not exist (%s).', $request->getParameter('id')));
    $this->form = new GameForm($game);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($game = GamePeer::retrieveByPk($request->getParameter('id')), sprintf('Object game does not exist (%s).', $request->getParameter('id')));
    $game->delete();

    $this->redirect('games/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $game = $form->save();

      $this->redirect('games/edit?id='.$game->getId());
    }
  }*/
}
