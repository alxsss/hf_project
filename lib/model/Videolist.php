<?php

class Videolist extends BaseVideolist
{
 public function getLastVideolistYtvideo($criteria = null, PropelPDO $con = null)
        {
                if ($criteria === null) {
                        $criteria = new Criteria(VideolistPeer::DATABASE_NAME);
                }
                elseif ($criteria instanceof Criteria)
                {
                        $criteria = clone $criteria;
                }

                if ($this->collVideolistYtvideos === null) {
                        if ($this->isNew()) {
                           $this->collVideolistYtvideos = array();
                        } else {

                                $criteria->add(VideolistYtvideoPeer::VIDEOLIST_ID, $this->id);
                                $criteria->addDescendingOrderByColumn(VideolistYtvideoPeer::CREATED_AT);

                                VideolistYtvideoPeer::addSelectColumns($criteria);
                                $this->collVideolistYtvideos = VideolistYtvideoPeer::doSelectOne($criteria, $con);
                        }
                } else {
                                                if (!$this->isNew()) {


                                $criteria->add(VideolistYtvideoPeer::VIDEOLIST_ID, $this->id);
                                $criteria->addDescendingOrderByColumn(VideolistYtvideoPeer::CREATED_AT);

                                VideolistYtvideoPeer::addSelectColumns($criteria);
                                if (!isset($this->lastVideolistYtvideoCriteria) || !$this->lastVideolistYtvideoCriteria->equals($criteria)) {
                                        $this->collVideolistYtvideos = VideolistYtvideoPeer::doSelectOne($criteria, $con);
                                }
                        }
                }
                $this->lastVideolistYtvideoCriteria = $criteria;
                return $this->collVideolistYtvideos;
        }

}
