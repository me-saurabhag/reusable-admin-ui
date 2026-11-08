<?php

namespace App\Presentation\Admin\ViewComposers;

use App\Presentation\Admin\Navigation\AdminMenuProvider;
use Illuminate\View\View;

class AdminLayoutComposer
{
    public function __construct(
        private readonly AdminMenuProvider $menuProvider
    ) {
    }

    public function compose(View $view): void
    {
        $view->with('menu', $this->menuProvider->sections());
    }
}
