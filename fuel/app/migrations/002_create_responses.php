<?php

namespace Fuel\Migrations;

class Create_responses
{
	public function up()
	{
		\DBUtil::create_table('responses', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => 11),
			'ThreadId' => array('constraint' => 11, 'null' => false, 'type' => 'int'),
			'Body' => array('null' => false, 'type' => 'text'),
			'CreateUserId' => array('null' => false, 'type' => 'int'),
			'DeleteFlag' => array('null' => false, 'type' => 'boolean', 'default' => 0),
			'created_at' => array('constraint' => 11, 'null' => false, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'null' => false, 'type' => 'int'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('responses');
	}
}
