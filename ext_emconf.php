<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "videoce"
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Video Content Element',
	'description' => 'Another content element for Youtube and Vimeo videos.',
	'category' => 'misc',
	'author' => 'Pascal Mayer',
	'author_email' => 'typo3@simple.ch',
	'author_company' => 'simplicity gmbh',
	'shy' => '',
	'version' => '0.6.3',
	'priority' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '6.2.0-6.2.99',
			'extbase' => '6.2.0-6.2.99',
			'fluid' => '6.2.0-6.2.99',
		),
		'conflicts' => array(
		),
	),
);

?>