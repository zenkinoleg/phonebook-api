<?php

namespace App\Services;

class AppStats
{
    private $timeClicks;

    public function __construct()
    {
        $this->timeClicks = [];
        $this->click('App Started');
    }

    public function click(?string $title = null)
    {
//      $this->timeClicks = $this->timeClicks + [ _microsecs() => ($title ?? '') ];
        $this->timeClicks[] = [
            'time' => _microsecs(),
            'title' => $title ?? ''
        ];
        return $this;
    }

    public function sinceLastTime()
    {
    }

    public function sinceStarted()
    {
    }

    public function getData(?int $human = 0) : array
    {
        $arr = $this->timeClicks ?? [];
        if (!$human) {
            return $arr;
        }
/*
        reset($arr);
        $first = key($arr);
        $res = collect($arr)->mapWithKeys(function ($item,$key) use ($first) {
            return [ ($key - $first)/1000 . ' s' => $item ];
        });
*/
        $first = $arr[0]['time'];
        $res = collect($arr)->map(function ($item) use ($first) {
            $item['secs'] = ($item['time']-$first)/1000;
            return $item;
        });
        return $res->toArray();
    }
}
