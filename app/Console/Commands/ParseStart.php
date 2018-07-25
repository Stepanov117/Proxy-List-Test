<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Sunra\PhpSimple\HtmlDomParser;

class ParseStart extends Command
{
    private const URL_PROXY_LIST = 'https://free-proxy-list.net/';
    private const FILE_PARSE_DATA = 'parseData.txt';
    private const FILE_PROXY_LIST = 'proxyList.txt';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Proxy-list parsing.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {  
        $parseData = self::getParseData();
        if(empty($parseData)){
            $this->info('Error: empty parseData!');
            return false;
        }
        $putFlag = self::putParseDataIntoFile($parseData);
        if($putFlag === false){
            $this->info('Error: can not put parseData into file!');
            return false;
        }
        $html = self::getParseDataFromFile();
        if(empty($html)){
            $this->info('Error: empty HTML!');
            return false;
        }
        $proxyList = self::getProxyListFromHtml($html);
        if(empty($proxyList)){
            $this->info('Error: empty proxyList!');
            return false;
        }
        $putFlag = self::putProxyListIntoFile($proxyList);
        if($putFlag === false){
            $this->info('Error: can not put proxyList into file!');
            return false;
        }
        $this->info('Success! Hell Yeah!');
        return true;
    }

    private static function getParseData()
    {
        $ch = curl_init(self::URL_PROXY_LIST);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    private static function putParseDataIntoFile(string $data)
    {
        return file_put_contents(self::FILE_PARSE_DATA, $data);
    }

    private static function getParseDataFromFile():string
    {
        return file_get_contents(self::FILE_PARSE_DATA);
    }

    private static function getProxyListFromHtml(string $html):array
    {
        $dom = HtmlDomParser::str_get_html($html);
        $elems = $dom->find('table#proxylisttable');
        if(!isset($elems[0])){
            return [];
        }
        $trs = $elems[0]->find('tr');
        $proxyList = [];
        foreach($trs as $tr){
            $tds = $tr->find('td');
            if(count($tds) == 0){
                continue;
            }
            $proxy['ip'] = $tds[0]->plaintext;
            $proxy['port'] = $tds[1]->plaintext;
            $proxy['country'] = $tds[3]->plaintext;
            $proxy['anonymity'] = $tds[4]->plaintext;
            $proxy['https'] = $tds[6]->plaintext;
            $proxy['checked'] = $tds[7]->plaintext;
            $proxyList[] = $proxy;
            unset($proxy);
        }
        return $proxyList;
    }

    private static function putProxyListIntoFile(array $proxyList)
    {
        $proxyList = serialize($proxyList);
        return file_put_contents(self::FILE_PROXY_LIST, $proxyList);
    }
}
