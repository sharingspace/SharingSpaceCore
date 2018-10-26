<?php

namespace App\Events;

abstract class Event
{

    Event::listen('github.webhook', function()
	{
	  if(shell_exec('cd ~/sites/anyshare &&  /usr/bin/git checkout master-update 2>&1')){
	  	return true;
	  }	 
	  return false;
	});
}
