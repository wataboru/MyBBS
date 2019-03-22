<?php

namespace Fuel\Migrations;

class Create_threads
{
	public function up()
	{
		\DBUtil::create_table('threads', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => '11'),
			'Subject' => array('null' => false, 'type' => 'text'),
			'Body' => array('null' => false, 'type' => 'text'),
			'CreatedUserId' => array('null' => false, 'type' => 'Int'),
			'DeleteFlag' => array('null' => false, 'type' => 'boolean', 'default' => 0),
			'created_at' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
			'updated_at' => array('constraint' => '11', 'null' => false, 'type' => 'int'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('threads');
	}
}
