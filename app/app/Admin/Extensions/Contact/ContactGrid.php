<?php

namespace App\Admin\Extensions\Contact;

use Closure;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Encore\Admin\Grid;

class ContactGrid extends Grid
{

    /**
     * View for grid to render.
     *
     * @var string
     */
    protected $view = 'admin::extensions.contact.table'; // ファイル名を変更します

    /**
     * Create a new grid instance.
     *
     * @param Eloquent $model
     * @param Closure  $builder
     */
    public function __construct(Eloquent $model, Closure $builder = null)
    {
        parent::__construct($model, $builder);
    }
}
