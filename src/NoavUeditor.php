<?php

namespace Flaravel\NoavUeditor;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Field;

class NoavUeditor extends Field
{
    protected $config;
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'noav-ueditor';


    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->withMeta([
            'serveUrl' => config('ueditor.route.name')
        ]);
    }

    public function options(array $options)
    {
        return $this->withMeta(array_merge($this->meta, $options));
    }
}
