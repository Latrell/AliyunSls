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
		$request = new Aliyun_Sls_Models_ListLogstoresRequest($project ?  : $this->project);
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
		$log_item = new Aliyun_Sls_Models_LogItem();
		$log_item->setTime(time());
		$log_item->setContents($contents);
		$logitems = [
			$log_item
		];
		$request = new Aliyun_Sls_Models_PutLogsRequest($project ?  : $this->project, $logstore ?  : $this->logstore, $topic, null, $logitems);

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
		$request = new Aliyun_Sls_Models_ListTopicsRequest($project ?  : $this->project, $logstore ?  : $this->logstore);

		$response = $this->client->listTopics($request);

		return $response;
	}

	/**
	 * 查询Logstore中的日志在时间轴上的分布。
	 *
	 * @param string $topic
	 * @param integer $from
	 * @param integer $to
	 * @param string $query
	 * @param string $project
	 * @param string $logstore
	 * @return Aliyun_Sls_Models_GetHistogramsResponse
	 */
	public function getHistograms($topic, $from, $to, $query = '', $project = '', $logstore = '')
	{
		$request = new Aliyun_Sls_Models_GetHistogramsRequest($project ?  : $this->project, $logstore ?  : $this->logstore, $from, $to, $topic, $query);

		$response = $this->client->getHistograms($request);

		return $response;
	}

	/**
	 * 查询Logstore中的日志数据。
	 *
	 * @param string $topic
	 * @param integer $from
	 * @param integer $to
	 * @param string $query
	 * @param string $project
	 * @param string $logstore
	 * @return Aliyun_Sls_Models_GetLogsResponse
	 */
	public function getLogs($topic, $from, $to, $query = '', $project = '', $logstore = '')
	{
		$request = new Aliyun_Sls_Models_GetLogsRequest($project ?  : $this->project, $logstore ?  : $this->logstore, $from, $to, $topic, $query, 100, 0, False);

		$response = $this->client->getLogs($request);
		return $response;
	}
}
