<?php
namespace CMS\Widget\Model;

abstract class WidgetAbstract
{
    private $data = [];

    abstract public function execute();
}