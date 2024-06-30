<?php
require_once "ImodifiableModel.php";

abstract class ModifiableAbstModel implements ImodifiableModel
{
    protected $id = 0;

    public function getById($id)
    {
        $this->setId($id);
        return $this->read();
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }
}
