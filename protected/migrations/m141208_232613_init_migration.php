<?php

class m141208_232613_init_migration extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('users', array(
			'id'       => 'pk',
			'email'    => 'varchar(255) NOT NULL',
			'password' => 'varchar(255)'
		), "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

		$this->createTable('events', array(
			'id'        => 'pk',
			'user_id'   => 'int(10) NOT NULL',
			'title'     => 'varchar(100)',
			'type'      => 'varchar(100)',
			'text'      => 'varchar(500)',
			'date'      => 'date NOT NULL',
			'time_hour' => 'int(10) NOT NULL',
		), "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
	}

	public function safeDown()
	{
		print 'Dropping tables users & events';
		$this->dropTable('users');
		$this->dropTable('events');
		return false;
	}
}