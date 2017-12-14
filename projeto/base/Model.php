<?php

namespace projeto\base;

class Model extends \yii\base\Model
{
    
    public function getErrosString(){
        
        foreach ($this->_errors as $name => $es) {
            if (!empty($es)) {
                $errors .= $name.':'.$es.'<br/>';
            }
        }
        return $errors;
        
    }
}