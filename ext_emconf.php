<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "videoce"
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
	'title' => 'Video Content Element',
	'description' => 'Another content element for Youtube, Vimeo and Dailymotion videos.',
	'category' => 'fe',
	'author' => 'Pascal Mayer',
	'author_email' => 'typo3@bsdist.ch',
	'author_company' => '',
	'version' => '0.9.0',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'modify_tables' => 'tt_content',
	'clearCacheOnLoad' => 1,
	'constraints' => [
		'depends' => [
            'typo3' => '8.7.0-8.7.99',
            'fluid_styled_content' => '8.7.0-8.7.99',
		],
		'conflicts' => [],
	],
    'autoload' => [
        'psr-4' => ['Laxap\\Videoce\\' => 'Classes']
    ],
];

?>