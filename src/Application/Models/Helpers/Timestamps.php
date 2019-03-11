<?php


namespace Application\Models\Helpers;


trait Timestamps {
    protected $timestamps = true;
    public $createdTime, $updatedTime;
}