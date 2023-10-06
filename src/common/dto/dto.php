<?php

namespace common\dto;

class DTO {
    public function toDTOArray() : array {
        $properties = get_object_vars($this);
        $dto = [];

        foreach ($properties as $name => $value) {
            $dto[$name] = $value;
        }

        return $dto;
    }
}