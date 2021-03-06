<?php
/**
*
* @package testing
* @copyright (c) 2012 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

class phpbb_filesystem_clean_path_test extends phpbb_test_case
{
	protected $filesystem;

	public function setUp()
	{
		parent::setUp();
		$this->filesystem = new \phpbb\filesystem(
			new \phpbb\symfony_request(
				new phpbb_mock_request()
			),
			dirname(__FILE__) . './../../phpBB/',
			'php'
		);
	}

	public function clean_path_data()
	{
		return array(
			array('foo', 'foo'),
			array('foo/bar', 'foo/bar'),
			array('foo/bar/', 'foo/bar/'),
			array('foo/./bar', 'foo/bar'),
			array('foo/./././bar', 'foo/bar'),
			array('foo/bar/.', 'foo/bar'),
			array('./foo/bar', './foo/bar'),
			array('../foo/bar', '../foo/bar'),
			array('one/two/three', 'one/two/three'),
			array('one/two/../three', 'one/three'),
			array('one/../two/three', 'two/three'),
			array('one/two/..', 'one'),
			array('one/two/../', 'one/'),
			array('one/two/../three/../four', 'one/four'),
			array('one/two/three/../../four', 'one/four'),
		);
	}

	/**
	* @dataProvider clean_path_data
	*/
	public function test_clean_path($input, $expected)
	{
		$this->assertEquals($expected, $this->filesystem->clean_path($input));
	}
}
