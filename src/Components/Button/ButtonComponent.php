<?php

declare(strict_types=1);

namespace Plugin\Core\Components\Button;

use Plugin\Core\Abstractions\AbstractComponent;

class ButtonComponent extends AbstractComponent
{
    public function key(): string
    {
        return 'button';
    }

    public function defaults(): array
    {
        return [
            'content' => 'Click Here',
            'attributes' => [
                'attr1' => 'attribute',
                'attr2' => 'attribute',
            ],
        ];
    }
}
