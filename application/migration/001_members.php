defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration_Users class.
 * 
 * @extends CI_Migration
 */
class Migration_Members extends CI_Migration {

	/**
	 * up function.
	 * 
	 * @access public
	 * @return void
	 */
	public function up() {
	
		/*
		 * CREATE TABLE `members` (
		 * `id` int(11) NOT NULL AUTO_INCREMENT,
		 * `type` int(11) DEFAULT NULL,
		 * `firstname` varchar(45) NOT NULL,
		 * `lastname` varchar(45) NOT NULL,
		 * `ssid` varchar(12) NOT NULL,
		 * `phone` varchar(12) NOT NULL,
		 * `address` varchar(45) DEFAULT NULL,
		 * `zip` varchar(10) DEFAULT NULL,
		 * `city` varchar(45) DEFAULT NULL,
		 * `data` int(11) DEFAULT NULL,
		 * PRIMARY KEY (`id`),
		 * KEY `type` (`type`),
		 * KEY `data` (`data`),
		 * CONSTRAINT `data` FOREIGN KEY (`data`) REFERENCES `member_data` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
		 * CONSTRAINT `type` FOREIGN KEY (`type`) REFERENCES `types` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
		 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8
		*/
		
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => false,
				'auto_increment' => true,
				'null' => false
			),
			'type' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false
			),
			'firstname' => array(
				'type' => 'VARCHAR',
				'constraint' => 45,
				'null' => false,
			),
			'lastname' => array(
				'type' => 'VARCHAR',
				'constraint' => 45,
				'null' => false,
			),
			'ssid' => array(
				'type' => 'VARCHAR',
				'constraint' => 12,
				'null' => false
			),
			'phone' => array(
				'type' => 'VARCHAR',
				'constraint' => 12,
				'null' => false
			),
			'address' => array(
				'type' => 'VARCHAR',
				'constraint' => 45,
				'null' => false,
			),
			'zip' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'null' => false,
			),
			'city' => array(
				'type' => 'VARCHAR',
				'constraint' => 45,
				'null' => false,
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => false,
			),
			'added' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => true,
			),
			'data' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false,
			),
		));
		$this->dbforge->add_key('id', true);
		$this->dbforge->add_key('type');
		$this->dbforge->add_key('data');
		$this->dbforge->create_table('members', TRUE);
	}

	/**
	 * down function.
	 * 
	 * @access public
	 * @return void
	 */
	public function down() {
		$this->dbforge->drop_table('members');
	}
}