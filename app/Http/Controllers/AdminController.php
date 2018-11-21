<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte;

class AdminController extends Controller
{
    protected function parserIndex()
    {
        $linkTariffs = 'http://cell.motivtelecom.ru/sverdlovsk-oblast/tariffs/b2c';
        $htmlTariffs = Goutte::request('GET', $linkTariffs);

        $tariffs = $htmlTariffs->filter('.tarifs_list a')->each(function ($tariff, $i) {
            return $tariff->attr('href');
        });
        
        $tarifs = array();        
        foreach($tariffs as $key => $tariff) {
            $linkTariff = 'http://cell.motivtelecom.ru' . $tariff;
            $htmlTariff = Goutte::request('GET', $linkTariff);
            //echo "{$key} => {1} ";
            $tarifs[$key] = $htmlTariff->filter('.el-dd > table')->children()->eq(3)->filter('.tariff-service-price')->text();
            //dd($htmlTariff->filter('.el-dd > table')->children()->eq(3)->filter('.tariff-service-price')->text());
        }
        dd($tarifs);
        return view('admin.parser.index');
    }
}
