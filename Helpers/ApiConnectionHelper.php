<?php

/**
 * Class ApiConnectionHelper
 * @author github.com/mrjavaci
 */

use RouterOS\Query;


class ApiConnectionHelper
{
    private $client;
    private $interface;

    public function __construct($myConfig)
    {
        try {
            $config = new \RouterOS\Config($myConfig);
            $client = new \RouterOS\Client($config);
            $this->client = $client;
        } catch (Exception $exception) {
            die($exception);
        }
    }

    public function getQueues()
    {
        $query = new Query('/queue/simple/print');
        $response = $this->client->query($query)->read();
        return $response;
    }

    public function setInterface($interface)
    {
        $this->interface = $interface;
    }

    public function getRxTx()
    {
        //  $query = (new Query('/interface'))->equal('monitor-traffic', 'ether1');
        $query =
            (new Query('/interface/monitor-traffic'))
                ->equal('interface', $this->interface)
                ->equal('once');
        $response = $this->client->query($query)->read();
        return $response;
    }


}