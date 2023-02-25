<?php
    namespace App\Services;

    class CommissionService
    {
        /**
         * percentage per number of referred distributors
         *
         * @param integer $noReferred
         * @return integer
         */
        public function commissionPercent(int $noReferred):int
        {
            $percent = 5;
            if($noReferred === 0) return $percent;
            switch ($noReferred) {
                case ($noReferred <= '4'):
                    $percent = 5;
                    break;
                case ($noReferred <= 10):
                    $percent = 10;
                    break;
                case ($noReferred <= 20):
                    $percent = 15;
                    break;
                case ($noReferred <= 29):
                    $percent = 20;
                    break;
                case ($noReferred >=30):
                    $percent = 30;
                    break;
            }
            return $percent;
        }

        public function commissionAmount(float $amount, int $percent):float
        {
            return ($percent/100) * $amount;
        }
    }

    // var_dump((new CommissionService)->commissionAmount(200, 10));
?>
