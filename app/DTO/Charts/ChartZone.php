<?php

namespace App\DTO\Charts;

class ChartZone
{
    public function __construct(
        public readonly ?float $from,
        public readonly ?float $to,
        public readonly string $type,
        public readonly string $label,
        public readonly int $priority = 0,
    ) {}

    public function toArray(): array
    {
        return [
            'from' => $this->from,
            'to' => $this->to,
            'type' => $this->type,
            'label' => $this->label,
            'priority' => $this->priority,
        ];
    }
}
