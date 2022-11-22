<?php

declare(strict_types = 1);

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;

/**
 * Class TotalPosts
 *
 * @package Statistics\Calculator
 */
class NoopCalculator extends AbstractCalculator
{

    protected const UNITS = 'posts';

    /**
     * @var int
     * @var array
     */
    private $totals = 0;
    private $users = [];

    /**
     * @param SocialPostTo $postTo
     */
    protected function doAccumulate(SocialPostTo $postTo): void
    {
        $key = $postTo->getAuthorName();

        $this->users[$key] = ($this->users[$key] ?? 0) + 1;
    }

    /**
     * @return StatisticsTo
     */
    protected function doCalculate(): StatisticsTo
    {

        $stats = new StatisticsTo();
        foreach ($this->users as $splitPeriod => $total) {
            $this->totals = $this->totals + $total;
        }

        return (new StatisticsTo())->setValue($this->totals/count($this->users));
    }
}
