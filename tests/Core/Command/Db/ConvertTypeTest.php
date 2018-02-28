<?php
/**
 * @author Viktar Dubiniuk <dubiniuk@owncloud.com>
 *
 * @copyright Copyright (c) 2018, ownCloud GmbH
 * @license AGPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 */


namespace Tests\Core\Command\Db;


use OC\Core\Command\Db\ConvertType;
use OC\DB\ConnectionFactory;
use Symfony\Component\Console\Tester\CommandTester;
use Test\TestCase;

/**
 * Class ConvertTypeTest
 *
 * @group DB
 */
class ConvertTypeTest extends TestCase{
	/** @var CommandTester */
	private $commandTester;

	/** @var \Doctrine\DBAL\Connection */
	private $connection;

	protected function setUp() {
		parent::setUp();

		$this->connection = \OC::$server->getDatabaseConnection();
		if (!$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\SqlitePlatform) {
			$this->markTestSkipped("Test only relevant on Sqlite");
		}
	}

	/**
	 * @expectedException \Doctrine\DBAL\DBALException
	 */
	public function testConvertToMysql() {
		$params = [
			'type' => 'mysql',
			'username' => 'dumb',
			'hostname' => 'localhost',
			'database' => 'convertdb',
			'--password' => 'test'

		];
		$command = new ConvertType(
			\OC::$server->getConfig(),
			new ConnectionFactory(\OC::$server->getSystemConfig()),
			\OC::$server->getAppManager()
		);
		$this->commandTester = new CommandTester($command);
		$this->commandTester->execute($params);
	}
}
