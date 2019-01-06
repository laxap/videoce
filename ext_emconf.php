<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "videoce"
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
	'title' => 'Video Content Element',
	'description' => 'Another content element for Youtube, Vimeo and Dailymotion videos.',
	'category' => 'fe',
	'author' => 'Pascal Mayer',
	'author_email' => 'typo3@lascap.ch',
	'author_company' => '',
	'version' => '0.10.0',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'modify_tables' => 'tt_content',
	'clearCacheOnLoad' => 1,
	'constraints' => [
		'depends' => [
            'typo3' => '9.5.0-9.5.99'
		],
		'conflicts' => [],
	],
    'autoload' => [
        'psr-4' => ['Laxap\\Videoce\\' => 'Classes']
    ],
];

?>