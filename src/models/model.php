<?php

namespace models;

use DateTime;

class Model {
    public function toDTO() : array {
        $properties = get_object_vars($this);
        $dto = [];
    
        foreach ($properties as $name => $value) {
            if ($value instanceof DateTime) {
                $dto[$name] = $value->format('Y-m-d H:i:s');
            } else {
                $dto[$name] = $value;
            }
        }
    
        return $dto;
    }
}