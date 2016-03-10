<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Note extends Eloquent implements UserInterface, RemindableInterface {

    public $timestamps = true;

    protected $fillable = ['user', 'note', 'tbd', 'link'];

    use UserTrait, RemindableTrait;

    protected $table = 'notes';
}
