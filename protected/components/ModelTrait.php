<?php

trait ModelTrait
{
    /**
     * Returns all model errors as array
     * @return array
     */
    public function allErrors()
    {
        $s = [];
        foreach ($this->errors as $errors) {
            foreach ($errors as $error) {
                $s[] = $error;
            }
        }
        return $s;
    }

    /**
     * Returns first validate error of model
     * @return Events[]
     */
    public function firstError()
    {
        $errors = $this->allErrors();
        return current($errors);
    }
}