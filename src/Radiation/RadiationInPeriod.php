<?php


namespace Sundata\Utilities\Radiation;

use InvalidArgumentException;
use Sundata\Utilities\Time\DateSplitter;
use Sundata\Utilities\Time\Period;

class RadiationInPeriod
{
    const LAST_DAY = 366;

    // TODO move this to Sundata helpers?
    public static function getAvgRadiation(Period $period): float
    {
        if (self::isMaxOf366days($period)) {
            return self::getAvgRadiationWithin1Year($period);
        }

        $periods = DateSplitter::splitInYears($period->getStart(), $period->getEnd());
        $radiation = 0;
        foreach ($periods as $period) {
            $radiation = $radiation + self::getAvgRadiationWithin1Year($period);
        }
        return $radiation;
    }

    public static function getRadiationPercentageOf7YAverage(Period $period): float
    {
        $radiation = self::getAvgRadiation($period);
        $percentage = ($radiation * 100) / self::getYearTotal();
        return round($percentage, 1);
    }

    private static function getYearTotal()
    {
        return self::AVG_CUM_RADIATION_PER_DAY[count(self::AVG_CUM_RADIATION_PER_DAY)];
    }

    private static function isMaxOf366days(Period $period): bool
    {
        $totalDays = $period->getStart()->diffInDays($period->getEnd()) + 1;
        if ($totalDays > self::maxDaysForCalculation()) {
            $maxDays = self::maxDaysForCalculation();
            return false;
        }
        return true;
    }

    /**
     * @param Period $period
     * @return float|int|mixed
     */
    private static function getAvgRadiationWithin1Year(Period $period)
    {
        $start = $period->getStart();
        $end = $period->getEnd();

        if ($start->isAfter($end))
            throw new InvalidArgumentException("Start can't be after end");
        if ($start->eq($end))
            return 0.0;

        // tricky bcs leap days
        else if ($start->day === $end->day && $start->month === $end->month) {
            return $start->year === $end->year
                ? 0
                : self::AVG_CUM_RADIATION_PER_DAY[self::LAST_DAY];

        } else if ($start->dayOfYear < $end->dayOfYear) {
            return self::AVG_CUM_RADIATION_PER_DAY[$end->dayOfYear]
                - self::AVG_CUM_RADIATION_PER_DAY[$start->dayOfYear];

        } else {
            $firstPart = self::AVG_CUM_RADIATION_PER_DAY[self::LAST_DAY]
                - self::AVG_CUM_RADIATION_PER_DAY[$start->dayOfYear];
            $secondPart = self::AVG_CUM_RADIATION_PER_DAY[$end->dayOfYear];
            return $firstPart + $secondPart;
        }
    }

    private static function maxDaysForCalculation(): int
    {
        return count(self::AVG_CUM_RADIATION_PER_DAY);
    }

    // seven year (2014-2020) average,
    const AVG_CUM_RADIATION_PER_DAY = [
        1 => 166,
        2 => 347.2857143,
        3 => 486.4285714,
        4 => 648.2857143,
        5 => 822.2857143,
        6 => 1054,
        7 => 1232.571429,
        8 => 1420.428571,
        9 => 1577.285714,
        10 => 1764.714286,
        11 => 1940.285714,
        12 => 2105.428571,
        13 => 2298.857143,
        14 => 2508.142857,
        15 => 2636.142857,
        16 => 2913.857143,
        17 => 3200.857143,
        18 => 3504.428571,
        19 => 3852.857143,
        20 => 4122.142857,
        21 => 4423.428571,
        22 => 4697.142857,
        23 => 4901.285714,
        24 => 5104.142857,
        25 => 5321.428571,
        26 => 5616.428571,
        27 => 5862.142857,
        28 => 6175.714286,
        29 => 6439,
        30 => 6760.714286,
        31 => 7019.285714,
        32 => 7256.428571,
        33 => 7586.428571,
        34 => 8049.428571,
        35 => 8384.428571,
        36 => 8785.428571,
        37 => 9214,
        38 => 9652.285714,
        39 => 9962.428571,
        40 => 10199,
        41 => 10497.85714,
        42 => 10895.71429,
        43 => 11432.57143,
        44 => 11967.42857,
        45 => 12514.14286,
        46 => 13127.28571,
        47 => 13818,
        48 => 14419.57143,
        49 => 15087.28571,
        50 => 15600.71429,
        51 => 15930.14286,
        52 => 16456.28571,
        53 => 16920.42857,
        54 => 17581.14286,
        55 => 18324,
        56 => 19062,
        57 => 19646.57143,
        58 => 20349,
        59 => 21061.85714,
        60 => 21756,
        61 => 22435,
        62 => 22823.71429,
        63 => 23630.71429,
        64 => 24479.57143,
        65 => 25047.14286,
        66 => 25781,
        67 => 26622.14286,
        68 => 27389,
        69 => 28304.42857,
        70 => 29175.28571,
        71 => 30251.42857,
        72 => 31249.71429,
        73 => 32121.71429,
        74 => 33004.57143,
        75 => 33666.28571,
        76 => 34688,
        77 => 35551.57143,
        78 => 36482.57143,
        79 => 37322.71429,
        80 => 38154,
        81 => 39278.57143,
        82 => 40382.57143,
        83 => 41769.42857,
        84 => 42873.14286,
        85 => 43885.28571,
        86 => 45188,
        87 => 46218,
        88 => 47402.28571,
        89 => 48733,
        90 => 49970.85714,
        91 => 51170.14286,
        92 => 52543.14286,
        93 => 53691.42857,
        94 => 54675.28571,
        95 => 56138.28571,
        96 => 57283.14286,
        97 => 58652.14286,
        98 => 60152.71429,
        99 => 61820.71429,
        100 => 63410.28571,
        101 => 64933.71429,
        102 => 66429.28571,
        103 => 68041.28571,
        104 => 69620.71429,
        105 => 71104.28571,
        106 => 72851.42857,
        107 => 74478.28571,
        108 => 76418,
        109 => 78170.71429,
        110 => 80297,
        111 => 82223.71429,
        112 => 84120.57143,
        113 => 85989,
        114 => 87598.28571,
        115 => 89194.57143,
        116 => 90628.71429,
        117 => 92167.28571,
        118 => 93664.71429,
        119 => 94975.42857,
        120 => 96218.42857,
        121 => 97850.71429,
        122 => 99476,
        123 => 101124.8571,
        124 => 102980.7143,
        125 => 104883.7143,
        126 => 106912.7143,
        127 => 108805.5714,
        128 => 110628.8571,
        129 => 112613.8571,
        130 => 114546.8571,
        131 => 116460.4286,
        132 => 118329,
        133 => 120198.7143,
        134 => 122406.1429,
        135 => 124669.4286,
        136 => 126553,
        137 => 128557.2857,
        138 => 130335.5714,
        139 => 132086,
        140 => 134062.7143,
        141 => 135766.1429,
        142 => 137936.2857,
        143 => 139686.4286,
        144 => 141645.5714,
        145 => 143542.7143,
        146 => 145412.4286,
        147 => 147295.4286,
        148 => 149155.8571,
        149 => 151080.8571,
        150 => 152979.4286,
        151 => 154714,
        152 => 157024.1429,
        153 => 158817.7143,
        154 => 160393.2857,
        155 => 162351.1429,
        156 => 164113.2857,
        157 => 166378.1429,
        158 => 168608,
        159 => 170321,
        160 => 172382.5714,
        161 => 174638,
        162 => 176989.1429,
        163 => 178538,
        164 => 180437.7143,
        165 => 182307.4286,
        166 => 184303.5714,
        167 => 185925.1429,
        168 => 187675.8571,
        169 => 189456,
        170 => 190861.5714,
        171 => 192695.2857,
        172 => 194421.7143,
        173 => 196236.8571,
        174 => 198339.5714,
        175 => 200222,
        176 => 202279.4286,
        177 => 204487.7143,
        178 => 206646.4286,
        179 => 208360.4286,
        180 => 210632.1429,
        181 => 212696.5714,
        182 => 214574.2857,
        183 => 216692.7143,
        184 => 219020.8571,
        185 => 221292,
        186 => 223188.5714,
        187 => 224861.1429,
        188 => 226968.8571,
        189 => 228609.5714,
        190 => 230134.5714,
        191 => 231766.7143,
        192 => 233644.8571,
        193 => 235273.4286,
        194 => 236892,
        195 => 238708.5714,
        196 => 240154.4286,
        197 => 242136.2857,
        198 => 244183.8571,
        199 => 246277,
        200 => 248340.7143,
        201 => 250147.8571,
        202 => 252368,
        203 => 254667.4286,
        204 => 256912.7143,
        205 => 258990.1429,
        206 => 260402.8571,
        207 => 262203.7143,
        208 => 264074.7143,
        209 => 265350.4286,
        210 => 267102.7143,
        211 => 268971.8571,
        212 => 270842.2857,
        213 => 272842.7143,
        214 => 274589.8571,
        215 => 276347.5714,
        216 => 277968.2857,
        217 => 279893.8571,
        218 => 281870.7143,
        219 => 283919.4286,
        220 => 285404.7143,
        221 => 286968,
        222 => 288500.4286,
        223 => 290312.1429,
        224 => 291789,
        225 => 293425.8571,
        226 => 294973.1429,
        227 => 296312.2857,
        228 => 297825.4286,
        229 => 298949.2857,
        230 => 300202.7143,
        231 => 301812.5714,
        232 => 303422.4286,
        233 => 304990.7143,
        234 => 306737.8571,
        235 => 308256.1429,
        236 => 309925.2857,
        237 => 311465.4286,
        238 => 312914.5714,
        239 => 314257.4286,
        240 => 315711.1429,
        241 => 317177.7143,
        242 => 318480.5714,
        243 => 319844.4286,
        244 => 321339.1429,
        245 => 322760.2857,
        246 => 323814.8571,
        247 => 324904.1429,
        248 => 325937.1429,
        249 => 326927.1429,
        250 => 328111.7143,
        251 => 329433.1429,
        252 => 330660.7143,
        253 => 331857.7143,
        254 => 333073.8571,
        255 => 334205.1429,
        256 => 335597.8571,
        257 => 336887.7143,
        258 => 338237.4286,
        259 => 339231.1429,
        260 => 340369.2857,
        261 => 341408.1429,
        262 => 342583,
        263 => 343708.4286,
        264 => 344997.7143,
        265 => 345878.5714,
        266 => 346856.7143,
        267 => 347734,
        268 => 348732.8571,
        269 => 349574.5714,
        270 => 350681,
        271 => 351617.5714,
        272 => 352476.2857,
        273 => 353319,
        274 => 354179.8571,
        275 => 354919.8571,
        276 => 355826.2857,
        277 => 356534,
        278 => 357375.7143,
        279 => 358055,
        280 => 358654.4286,
        281 => 359223.5714,
        282 => 359904.7143,
        283 => 360752.2857,
        284 => 361431.4286,
        285 => 362135.7143,
        286 => 362737.8571,
        287 => 363332.1429,
        288 => 363982.4286,
        289 => 364521.2857,
        290 => 365151.4286,
        291 => 365786,
        292 => 366355,
        293 => 366855.5714,
        294 => 367210.2857,
        295 => 367691.4286,
        296 => 368158.5714,
        297 => 368603.7143,
        298 => 369010,
        299 => 369478.8571,
        300 => 370166.1429,
        301 => 370648.5714,
        302 => 371037.5714,
        303 => 371532.7143,
        304 => 372056,
        305 => 372526.4286,
        306 => 373036.8571,
        307 => 373460.5714,
        308 => 373878.7143,
        309 => 374221.8571,
        310 => 374652.2857,
        311 => 375014.1429,
        312 => 375469.1429,
        313 => 375857.4286,
        314 => 376203.7143,
        315 => 376473.2857,
        316 => 376770.2857,
        317 => 377196.7143,
        318 => 377468.8571,
        319 => 377670,
        320 => 377816.1429,
        321 => 378156.2857,
        322 => 378400.8571,
        323 => 378680.4286,
        324 => 378898.2857,
        325 => 379141.8571,
        326 => 379414.7143,
        327 => 379715,
        328 => 379975.1429,
        329 => 380235.4286,
        330 => 380524.2857,
        331 => 380683.7143,
        332 => 380873,
        333 => 381109.4286,
        334 => 381366,
        335 => 381538.8571,
        336 => 381686.7143,
        337 => 381860.4286,
        338 => 382105.2857,
        339 => 382298,
        340 => 382510.4286,
        341 => 382650.8571,
        342 => 382806.2857,
        343 => 383024.7143,
        344 => 383204.1429,
        345 => 383333.4286,
        346 => 383521.1429,
        347 => 383675.5714,
        348 => 383889.7143,
        349 => 384067.4286,
        350 => 384185.2857,
        351 => 384390.2857,
        352 => 384530.7143,
        353 => 384722.4286,
        354 => 384864.5714,
        355 => 385016,
        356 => 385104.4286,
        357 => 385243.5714,
        358 => 385385,
        359 => 385559.7143,
        360 => 385743.5714,
        361 => 385916.5714,
        362 => 386159.5714,
        363 => 386329.1429,
        364 => 386519.4286,
        365 => 386751.1429,
        366 => 386751.1429,
    ];

}