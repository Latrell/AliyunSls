<?php

class MainTest extends \PHPUnit_Framework_TestCase
{

	protected $endpoint = '<sls_region_endpoint>';

	protected $access_key_id = '<your_access_key_id>';

	protected $access_key = '<your_access_key>';

	protected $project = '<your_project_name>';

	protected $logstore = '<your_logstore_name>';

	protected $sls = null;

	public function setUp()
	{
		require_once __DIR__ . '/../vendor/autoload.php';

		$this->sls = new Latrell\AliyunSls\AliyunSls($this->endpoint, $this->access_key_id, $this->access_key, $this->project, $this->logstore);
	}

	public function testPutLogs()
	{
		$ret = $this->sls->putLogs('TestTopic', [
			'TestKey' => 'TestContent'
		]);

		$this->assertTrue($ret);
	}

	public function testListLogstores()
	{
		$ret = $this->sls->listLogstores();

		$stores = $ret->getLogstores();

		$this->assertTrue(in_array($this->logstore, $stores));
	}

	public function testListTopics()
	{
		$ret = $this->sls->listTopics();

		$topics = $ret->getTopics();

		$this->assertTrue(in_array('TestTopic', $topics));
	}

	public function testGetHistograms()
	{
		$ret = $this->sls->getHistograms(time() - 3600, time(), 'TestTopic');

		$header = $ret->getHeader('_info');
		$this->assertEquals($header['http_code'], 200);
	}

	public function testGetLogs()
	{
		$ret = $this->sls->getLogs(time() - 3600, time(), 'TestTopic');

		$header = $ret->getHeader('_info');
		$this->assertEquals($header['http_code'], 200);
	}
}
