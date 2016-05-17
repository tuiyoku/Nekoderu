<?php

namespace App\Controller;

class CatsController extends AppController
{
    public function index()
    {
//        $this->Crud->on('beforePaginate', function (Event $event) {
//
//            // Search Pluginの検索条件の追加
//            $event->subject->query = $this->Cats->find(
//                'search',
//                $this->request->query
//            );
//
//        });


        $this->Crud->on('beforePaginate', function($e) {
//            $end = $this->request->query['map_end'];
//            $from_time = $this->request->query['map_start'];
//            $flgs = explode(",", $this->request->query["map_flg"]);
//
//            $end = strtotime(date("Y-m-d H:i:s", (int)$end));
//            $from_time = strtotime(date("Y-m-d H:i:s", (int)$from_time));
//
//            $condition = [
//                ['time > ' . $from_time],
//                ['time < ' . $end],
//                ['flg IN (' . $flgs . ')'],
//            ];

            $e->subject->query = $this->Cats->find(
                'search',
                $this->Cats->filterParams($this->request->query)
            );
        });
        return $this->Crud->execute();
    }
}