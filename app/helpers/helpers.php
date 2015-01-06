<?php

################################# Helper Function for Flash Messages  #################################

class FlashMessage
{
	public static function DisplayAlert($message, $type)
	{
		return "<h4 class='alert alert-" . $type . "' align='center'>" . $message . "</h4>";
	}
}