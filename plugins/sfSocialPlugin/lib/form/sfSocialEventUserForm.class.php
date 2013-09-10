<?php

/**
 * sfSocialEventUser form.
 *
 * @package    sfSocialPlugin
 * @subpackage form
 * @author     Massimiliano Arione <garakkio@gmail.com>
 */
class sfSocialEventUserForm extends BasesfSocialEventUserForm
{

  public function configure()
  {
    // hide unuseful fields
    unset($this['created_at']);

    // make "confirm" a choice
    $this->widgetSchema['confirm'] = new sfWidgetFormChoice(array('choices'  => sfSocial::getI18NChoices(sfSocialEventUserPeer::$confirmChoices), 'expanded' => false));
    $this->validatorSchema['confirm'] = new sfValidatorChoice(array('required' => false, 'choices' => array_keys(sfSocialEventUserPeer::$confirmChoices)));
    $this->widgetSchema['confirm']->setLabel('Will you participate?');
    // make user_id hidden
    $this->widgetSchema['user_id'] = new sfWidgetFormInputHidden();
    $this->setDefault('user_id', $this->options['user_id']);
    $this->setValidator('user_id', new sfValidatorChoice(array('choices' => array($this->options['user_id']))));

    // make event_id hidden
    $this->widgetSchema['event_id'] = new sfWidgetFormInputHidden();
    $this->setDefault('event_id', $this->options['event']->getId());
    $this->setValidator('event_id', new sfValidatorChoice(array('choices' => array($this->options['event']->getId()))));
  }

  /**
   * ovveride: when save, if user previously confirmed and now doesn't,
   *  it needs to remove it from sfSocialEventUser
   * @param PropelPDO $con
   */
  public function doSave($con = null)
  {
    $obj = $this->getObject();
   /* if (!$obj->isNew() && $this->getValue('confirm'))
    {
	   parent::doSave($con);
	  
    }
    else*/
    {
   try
      {
        $con->beginTransaction();
        parent::doSave($con);
        $c = new Criteria;
        $c->add(sfSocialEventInvitePeer::EVENT_ID, $this->getValue('event_id'));
        $c->add(sfSocialEventInvitePeer::USER_ID, $this->getValue('user_id'));
        $invite=sfSocialEventInvitePeer::doSelectOne($c);
        if(!empty($invite))
        {
          $invite->setReplied(1);
	  $invite->save();
        }	
        $con->commit();
      }
      catch (Exception $e)
      {
        $con->rollBack();
        throw $e;
      }		
    }
  }

}
