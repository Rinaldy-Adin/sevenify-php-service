<?php

class Model {
    public function toDTO() : array {
        $properties = get_object_vars($this);
        $dto = [];

        foreach ($properties as $name => $value) {
            $dto[$name] = $value;
        }

        return $dto;
    }
}