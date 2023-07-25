<?php

namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Markdown;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class InvetoryPhoneLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'phone';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Inlocuire Telefon';

    /**
     * The maximum amount of this layout type that can be added
     */
    protected $limit = 1;

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make('Title'),
            Markdown::make('Content')
        ];
    }

}
