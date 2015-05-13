<?php

namespace MillerVein\Component\Collection;

use Doctrine\Common\Collections\ArrayCollection as DoctrineArrayCollection;

/**
 * Description of ArrayCollection
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class ArrayCollection extends DoctrineArrayCollection{
    public function getIds(){
        $id = [];
        foreach($this as $element){
            $id[] = $element->getId();
        }
        return $id;
    }
}
