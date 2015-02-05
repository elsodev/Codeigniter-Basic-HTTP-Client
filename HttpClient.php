<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class HttpClient
 * Simple HTTP client using cURL to make http requests easier
 * Supports: POST, GET
 *
 * @author  Elson Tan (@elsodev)
 * @version 1.0
 */

class HttpClient
{
    //properties
    private $headers,
            $data,
            $url,
            $ch,
            $results,
            $curl_returntransfer = true,
            $curl_header = false,
            $error = false,
            $errorMsg;

    /**
     * Constructor
     * @param $params
     */
    public function __construct($params = NULL)
    {
        if(!is_null($params)){
            $this->setOptions($params);
        }
    }

    /**
     * Set options
     * @param $params
     */
    public function setOptions($params){
        foreach ($params as $key => $val)
        {
            $this->{$key} = $val;
        }

        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, $this->curl_returntransfer);
        curl_setopt($this->ch, CURLOPT_HEADER, $this->curl_header);
    }

    /**
     * Execute cURL
     * @return bool
     */
    private function execute(){
        $this->error = false;

        //executes the curl
        $this->results = curl_exec($this->ch);

        if(curl_errno($this->ch)){
            //set error message
            $this->error = true;
            $this->errorMsg = curl_error($this->ch);
            curl_close($this->ch);
            return false;
        } else {
            curl_close($this->ch);
            return true;
        }
    }

    /**
     * Get Results
     * @return string
     */
    public function getResults(){
        return $this->results;
    }

    /**
     * Get Results in array
     * @return array
     */
    public function getResultsArray(){
        return json_decode( $this->results, true );
    }

    /**
     * Get Error Status
     * @return bool
     */
    public function getError(){
        return $this->error;
    }

    /**
     * Get error message
     * @return string
     */
    public function getErrorMsg(){
        return $this->errorMsg;
    }

    /**
     * Check if supplied data is array, then convery it to query format.
     * @param $d
     * @return string
     */
    private function queryData($d){
        if (is_array($d)) {
            $data = http_build_query($d);
        } else {
            $data = $d;
        }
        return $data;
    }

    /**
     * Make sure URL and Data is provided
     * @return bool
     */
    private function checkEssentials(){
        $this->error = false;
        if (!empty($this->url) && !empty($this->data)) {
            return true;
        }

        $this->error = true;
        $this->errorMsg = 'No URL/Data provided';
        return false;

    }


    /**
     * Setup POST
     * @return bool
     */
    public function post(){
        if ($this->checkEssentials()) {
            $post_data = $this->queryData($this->data);

            $options = array(
                CURLOPT_URL => $this->url,
                CURLOPT_POST => count($post_data),
                CURLOPT_POSTFIELDS => $post_data,
            );

            curl_setopt_array ( $this->ch, $options );

            //set headers
            if( !empty($this->headers) ){
                curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
            }
            return $this->execute();
        }
        return false;
    }

    /**
     * Setup GET
     * @return bool
     */
    public function get()
    {
        if ($this->checkEssentials()) {

            $get_data = $this->queryData($this->data);

            curl_setopt($this->ch, CURLOPT_URL, $this->url . '?' . $get_data);

            //set headers
            if (!empty($this->headers)) {
                curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
            }
            return $this->execute();
        }
        return false;
    }

}

/* End of file HttpClient.php */