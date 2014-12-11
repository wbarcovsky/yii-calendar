<?php

class m141211_002120_create_demo_users extends CDbMigration
{
	public function safeUp()
	{
		for ($i = 0; $i < 10; $i++)
		{
			$email = $i . '@demo.ru';
			$password = md5('secret');
			$this->dbConnection->createCommand("INSERT INTO users(email,password) VALUE('{$email}', '{$password}')")->execute();
		}
	}

	public function safeDown()
	{
		for ($i = 0; $i < 10; $i++)
		{
			$email = $i . '@demo.ru';
			$this->dbConnection->createCommand("DELETE FROM users WHERE email='{$email}'")->execute();
		}
	}
}