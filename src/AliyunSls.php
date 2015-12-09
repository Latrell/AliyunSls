<?php
namespace Latrell\AliyunSls;

use Aliyun_Sls_Client;
use Aliyun_Sls_Models_ListLogstoresRequest;
use Aliyun_Sls_Models_LogItem;
use Aliyun_Sls_Models_PutLogsRequest;
use Aliyun_Sls_Models_ListTopicsRequest;
use Aliyun_Sls_Models_GetHistogramsRequest;
use Aliyun_Sls_Models_GetLogsRequest;

class AliyunSls
{

	protected $client;

	protected $project, $logstore;

	public function __construct($endpoint, $access_key_id, $access_key, $project = '', $logstore = '')
	{
		$this->client = new Aliyun_Sls_Client($endpoint, $access_key_id, $access_key);

		$this->project = $project;
		$this->logstore = $logstore;
	}

	/**
	 * 列出Project下的所有Logstore名称。
	 *
	 * @param string $project
	 * @return Aliyun_Sls_Models_ListLogstoresResponse
	 */
	public function listLogstores($project = '')
	{
		$project = $project ?  : $this->project;

		$request = new Aliyun_Sls_Models_ListLogstoresRequest($project);
		$response = $this->client->listLogstores($request);
		return $response;
	}

	/**
	 * 向指定的Logstore写入日志。
	 *
	 * @param string $topic
	 * @param array $contents
	 * @param string $project
	 * @param string $logstore
	 * @return boolean
	 */
	public function putLogs($topic, $contents, $project = '', $logstore = '')
	{
		$project = $project ?  : $this->project;
		$logstore = $logstore ?  : $this->logstore;

		$log_item = new Aliyun_Sls_Models_LogItem();
		$log_item->setTime(time());
		$log_item->setContents($contents);
		$logitems = [
			$log_item
		];
		$request = new Aliyun_Sls_Models_PutLogsRequest($project, $logstore, $topic, null, $logitems);

		$response = $this->client->putLogs($request);

		return array_get($response->getAllHeaders(), '_info.http_code') === 200;
	}

	/**
	 * 列出Logstore中的日志主题。
	 *
	 * @param string $project
	 * @param string $logstore
	 * @return Aliyun_Sls_Models_ListTopicsResponse
	 */
	public function listTopics($project = '', $logstore = '')
	{
		$project = $project ?  : $this->project;
		$logstore = $logstore ?  : $this->logstore;

		$request = new Aliyun_Sls_Models_ListTopicsRequest($project, $logstore);

		$response = $this->client->listTopics($request);

		return $response;
	}

	/**
	 * 查询Logstore中的日志在时间轴上的分布。
	 *
	 * @param integer $from
	 * @param integer $to
	 * @param string $topic
	 * @param string $query
	 * @param string $project
	 * @param string $logstore
	 * @return Aliyun_Sls_Models_GetHistogramsResponse
	 */
	public function getHistograms($from = null, $to = null, $topic = null, $query = null, $project = null, $logstore = null)
	{
		$project = $project ?  : $this->project;
		$logstore = $logstore ?  : $this->logstore;

		$request = new Aliyun_Sls_Models_GetHistogramsRequest($project, $logstore, $from, $to, $topic, $query);

		$response = $this->client->getHistograms($request);

		return $response;
	}

	/**
	 * 查询Logstore中的日志数据。
	 *
	 * @param string $from
	 * @param string $to
	 * @param string $topic
	 * @param string $query
	 * @param string $line
	 * @param string $offset
	 * @param string $reverse
	 * @param string $project
	 * @param string $logstore
	 * @return Aliyun_Sls_Models_GetLogsResponse
	 */
	public function getLogs($from = null, $to = null, $topic = null, $query = null, $line = 100, $offset = null, $reverse = null, $project = null, $logstore = null)
	{
		$project = $project ?  : $this->project;
		$logstore = $logstore ?  : $this->logstore;

		$request = new Aliyun_Sls_Models_GetLogsRequest($project, $logstore, $from, $to, $topic, $query, $line, $offset, $reverse);

		$response = $this->client->getLogs($request);
		return $response;
	}

	public function getProject()
	{
		return $this->project;
	}

	public function setProject($value)
	{
		$this->project = $value;
		return $this;
	}

	public function getLogstore()
	{
		return $this->logstore;
	}

	public function setLogstore($value)
	{
		$this->logstore = $value;
		return $this;
	}
}
