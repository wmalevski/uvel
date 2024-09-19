<?php

namespace App\View\Components\Admin\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Create extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $formHeader,
        public string $formId,
        public string $formName,
        public string $formLabel,
        public string $formAction,
        public string $formTriggerText = 'Добави'
    )
    {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.forms.create');
    }
}
