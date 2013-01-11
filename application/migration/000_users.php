defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration_Users class.
 * 
 * @extends CI_Migration
 */
class Migration_Users extends CI_Migration {

	/**
	 * up function.
	 * 
	 * @access public
	 * @return void
	 */
	public function up() {
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => false,
				'auto_increment' => true,
				'null' => false
			),
			'username' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => false
			),
			'firstname' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => true,
			),
			'lastname' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => true,
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => false,
			),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => false,
			),
			'phone' => array(
				'type' => 'VARCHAR',
				'constraint' => 12,
				'null' => true,
			),
			'key' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => false,
			),
			'registered' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => false,
			),
			'first_login' => array(
				'type' => 'TINY_INT',
				'constraint' => 4,
				'null' => false,
			),
			'loggedin' => array(
				'type' => 'TINY_INT',
				'constraint' => 4,
				'null' => false,
			),
		));
		
		$this->dbforge->create_table('users', true);
	}

	/**
	 * down function.
	 * 
	 * @access public
	 * @return void
	 */
	public function down() {
		$this->dbforge->drop_table('users');
	}
}