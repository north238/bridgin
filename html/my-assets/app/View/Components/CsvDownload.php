<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class CsvDownload extends Component
{
    public $assets;
    /**
     * コンポーネントインスタンスを作成
     */
    public function __construct(
        $assets
    ) {
        $this->assets = $assets;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.csv-download');
    }
}
