<?php

class Kalkulator
{
    protected int $daya;

    public function __construct()
    {
        $this->daya = 0;
    }

    public function penjumlahan($angka1, $angka2)
    {
        if ($this->checkDaya() == true) {
            echo $angka1 + $angka2;
        }
    }

    public function pengurangan($angka1, $angka2)
    {
        if ($this->checkDaya() == true) {
            echo $angka1 - $angka2;
        }
    }

    public function perkalian($angka1, $angka2)
    {
        if ($this->checkDaya() == true)  {
            echo $angka1 * $angka2;
        }
    }

    public function pembagian($angka1, $angka2)
    {
        if ($this->checkDaya() == true) {
            if ($angka2 == 0) {
                echo "Tidak dapat melakukan pembagian dengan angka 0";
            } else {
                echo $angka1 / $angka2;
            }
        }
    }

    public function isiDaya($daya)
    {
        if($this->daya == 100) {
            echo "Daya penuh";
        } else {
            $this->daya += $daya;
        }
    }

    public function perpangkatan($angka1, $angka2)
    {
        if ($this->checkDaya() == true) {
            $hasil = pow($angka1,$angka2);
            if ($hasil > 1000000) {
                echo "Nilai diluar batas yang ditentukan";
            } else {
                echo $hasil;
            }
        }
    }

    protected function dayaBerkurang()
    {
        $this->daya -= 10;
    }

    private function checkDaya()
    {
        if($this->daya == 0) {
            echo "Daya Habis";
            return false;
        } else {
            $this->dayaBerkurang();
            return true;
        }
    }
}

class KalkulatorHemat extends Kalkulator
{
    protected function dayaBerkurang()
    {
        $this->daya -= 5;
    }
}

$kalkulator = new KalkulatorHemat();
$kalkulator->isiDaya(10);
$kalkulator->perpangkatan(2,3);

