<?php

return array_merge(
	require(dirname(__FILE__).'/main.php'),
	[
		'components'=>[
			'fixture'=>[
				'class'=>'system.test.CDbFixtureManager',
			],
		],
	]);
