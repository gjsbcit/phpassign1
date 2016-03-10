<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Image extends Eloquent implements UserInterface, RemindableInterface {

    public $timestamps = true;

    protected $fillable = ['image_name', 'user', 'image', 'ext'];

    use UserTrait, RemindableTrait;

    protected $table = 'images';
}
