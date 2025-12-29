<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RegressionLinear
{
    /**
     * Build regression from (x,y) arrays.
     * Returns: [a,b,n,sum_x,sum_y,sum_x2,sum_xy, yhat_by_x]
     */
    public function fit(array $x, array $y): array
    {
        $n = count($x);
        if ($n === 0 || $n !== count($y)) {
            throw new Exception('Data X dan Y harus ada dan jumlahnya sama.');
        }

        $sum_x = 0.0; $sum_y = 0.0; $sum_x2 = 0.0; $sum_xy = 0.0;
        for ($i=0; $i<$n; $i++) {
            $xi = (float)$x[$i];
            $yi = (float)$y[$i];
            $sum_x += $xi;
            $sum_y += $yi;
            $sum_x2 += $xi * $xi;
            $sum_xy += $xi * $yi;
        }

        $den = ($n * $sum_x2) - ($sum_x * $sum_x);
        if (abs($den) < 1e-12) {
            throw new Exception('Denominator nol. Pastikan X bervariasi (tidak semua sama).');
        }

        // persamaan (2.2) dan (2.3)
        $a = (($sum_y * $sum_x2) - ($sum_x * $sum_xy)) / $den;
        $b = (($n * $sum_xy) - ($sum_x * $sum_y)) / $den;

        $yhat_by_x = [];
        for ($i=0; $i<$n; $i++) {
            $xi = (float)$x[$i];
            $yhat_by_x[$i] = $a + ($b * $xi); // persamaan (2.1)
        }

        return [
            'a' => $a,
            'b' => $b,
            'n' => $n,
            'sum_x' => $sum_x,
            'sum_y' => $sum_y,
            'sum_x2' => $sum_x2,
            'sum_xy' => $sum_xy,
            'yhat' => $yhat_by_x,
        ];
    }

    public function predict(float $a, float $b, float $x): float
    {
        return $a + ($b * $x);
    }

    /** Metrics: R2, MAE, MSE, RMSE, MAPE, SD(Y) sample & population, categories */
    public function evaluate(array $y, array $yhat): array
    {
        $n = count($y);
        if ($n === 0 || $n !== count($yhat)) {
            throw new Exception('Data Y dan Yhat harus ada dan jumlahnya sama.');
        }

        $sum_y = 0.0;
        for ($i=0; $i<$n; $i++) $sum_y += (float)$y[$i];
        $ybar = $sum_y / $n;

        $SST = 0.0; $SSE = 0.0; $SSR = 0.0;
        $abs_err = 0.0; $sq_err = 0.0; $ape = 0.0;

        for ($i=0; $i<$n; $i++) {
            $yi = (float)$y[$i];
            $yhi = (float)$yhat[$i];
            $SST += ($yi - $ybar) * ($yi - $ybar);
            $SSE += ($yi - $yhi) * ($yi - $yhi);
            $SSR += ($yhi - $ybar) * ($yhi - $ybar);
            $abs_err += abs($yi - $yhi);
            $sq_err  += ($yi - $yhi) * ($yi - $yhi);

            // handle Yi=0 for MAPE: skip or treat as 0 (here: skip to avoid division by zero)
            if (abs($yi) > 1e-12) {
                $ape += abs(($yi - $yhi) / $yi);
            }
        }

        $R2 = ($SST > 1e-12) ? (1.0 - ($SSE / $SST)) : 0.0;
        $MAE = $abs_err / $n;
        $MSE = $sq_err / $n;
        $RMSE = sqrt($MSE);

        // MAPE avg only on non-zero Yi
        $nonZeroCount = 0;
        for ($i=0; $i<$n; $i++) if (abs((float)$y[$i]) > 1e-12) $nonZeroCount++;
        $MAPE = ($nonZeroCount > 0) ? (($ape / $nonZeroCount) * 100.0) : 0.0;

        // SD(Y) population and sample
        $var_pop = ($SST / $n);
        $sd_pop = sqrt($var_pop);

        $sd_samp = null;
        if ($n > 1) {
            $var_samp = ($SST / ($n - 1));
            $sd_samp = sqrt($var_samp);
        }

        $cat_mape = $this->category_mape($MAPE);
        $cat_sd = $this->category_sd($RMSE, $sd_pop);

        return [
            'ybar' => $ybar,
            'SST' => $SST,
            'SSE' => $SSE,
            'SSR' => $SSR,
            'R2' => $R2,
            'MAE' => $MAE,
            'MSE' => $MSE,
            'RMSE' => $RMSE,
            'MAPE' => $MAPE,
            'sd_pop' => $sd_pop,
            'sd_samp' => $sd_samp,
            'cat_mape' => $cat_mape,
            'cat_sd' => $cat_sd,
        ];
    }

    public function category_mape(float $mape): string
    {
        if ($mape < 10) return 'sangat baik';
        if ($mape >= 10 && $mape <= 20) return 'baik';
        if ($mape > 20 && $mape <= 50) return 'cukup';
        return 'buruk';
    }

    public function category_sd(float $rmse, float $sd_y): string
    {
        if ($rmse < $sd_y) return 'baik';
        if (abs($rmse - $sd_y) < 1e-12) return 'cukup';
        return 'buruk';
    }
}
