<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProxyList extends Controller
{
    /**
     * Show proxy list.
     *
     * @param  Request  $request
     * @return Response
     */
    public function show(Request $request)
    {
        try {
            $proxyList = file_get_contents('../proxyList.txt');
            $proxyList = unserialize($proxyList);
        } catch(\Exception $e) {
            $proxyList = [];
        }
        $filter = [];
        $fieldsFilter = ['country', 'anonymity', 'https', 'checked'];
        foreach($fieldsFilter as $field){
            if($request->has($field)){
                $filter[$field] = $request->query($field);
                continue;
            }
            $filter[$field] = 'All';
        }
        $countryValues = self::getUniqueFieldValues($proxyList, 'country');
        $anonymityValues = self::getUniqueFieldValues($proxyList, 'anonymity');
        $httpsValues = self::getUniqueFieldValues($proxyList, 'https');
        $checkedValues = self::getUniqueFieldValues($proxyList, 'checked');
        self::filterByFieldValue($proxyList, $filter);
        self::addNumber($proxyList);
        $params = [
            'proxyList' => $proxyList,
            'fieldsFilter' => $filter,
            'countryValues' => $countryValues,
            'anonymityValues' => $anonymityValues,
            'httpsValues' => $httpsValues,
            'checkedValues' => $checkedValues,
        ];
        return view('proxy-list', $params);
    }

    private static function addNumber(&$proxyList)
    {
        $i = 1;
        foreach($proxyList as $k => $v){
            $proxyList[$k]['i'] = $i++;
        }
    }

    private static function getUniqueFieldValues($proxyList, $column)
    {
        $values = array_column($proxyList, $column);
        $values = array_unique($values);
        sort($values);
        array_unshift($values, 'All');
        return $values;
    }

    private static function filterByFieldValue(array &$proxyList, array $filter)
    {
        foreach($filter as $field => $value){
            if($value === 'All'){
                continue;
            }
            foreach($proxyList as $k => $proxy){
                if($proxy[$field] !== $value){
                    unset($proxyList[$k]);
                }
            }
        }
    } 
}