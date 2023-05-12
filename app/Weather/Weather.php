<?php

namespace App\Weather;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Weather
{
    public int $dayTemp;
    public int $dayWind;
    public string $dayDate ;
    public int $dayPressure;
    public array $hourly;
    private Collection $originalData;

    private ?int $dayMinimum = null;
    private ?int $dayMaximum = null;


    public function __construct(array $hourly,Collection $originalData)
    {
        $this->hourly = $hourly;
        $this->originalData = $originalData;
        $this->_calcDay();
    }

    /**
     * get Minimum Temperature of Current Day
     */
    public function getDayTempMinimum(): int
    {
        if (!is_null($this->dayMinimum))
            return $this->dayMinimum;
        else {
            $this->dayMinimum = min(array_column($this->hourly, 'temp'));
        }

        return $this->dayMinimum;
    }

    /**
     * get Maximum Temperature of Current Day
     */
    public function getDayTempMaximum(): int
    {
        if (!is_null($this->dayMaximum))
            return $this->dayMaximum;
        else {
            $this->dayMaximum = max(array_column($this->hourly, 'temp'));
        }

        return $this->dayMaximum;
    }

    /**
     * get Original Data from Weather Provider
     */
    public function getOriginalData(): Collection
    {
        return $this->originalData;
    }

    /**
     * calc averages of current day
     */
    private function _calcDay(): void
    {
        $this->dayTemp = array_sum(array_column($this->hourly, 'temp')) / count($this->hourly);
        $this->dayWind = array_sum(array_column($this->hourly, 'windSpeed')) / count($this->hourly);
        $this->dayPressure = array_sum(array_column($this->hourly, 'pressure')) / count($this->hourly);
        //dd(array_column($this->hourly,'time'));
        $this->dayDate = Str::substr(array_column($this->hourly, 'time')[0],0,10);

    }


}
