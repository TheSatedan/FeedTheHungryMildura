<?php

$dbConnection = databaseConnection();


class contenteditor
{
	const ModuleDescription = 'This Module Allows access to change all Content on pages in a text Editor.';
	const ModuleAuthor = 'Sunsetcoders Development Team.';
	const ModuleVersion = '1.0';
	
	function __construct()
	{
		
	}
	
	public function landingPage()
	{
		echo 'Hello World';
	}
}