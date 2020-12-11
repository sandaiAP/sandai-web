<?php

namespace App\Admin\Controllers;

use App\Models\Staff;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;

class StaffController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Staff';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        // Id、名前をソート可能なようにして一覧表示、actionは編集・削除のみ
        $grid = Admin::grid(Staff::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('name')->sortable();
            $grid->actions(function ($actions) {
                // $actions->disableDelete(); // 削除無効
                // $actions->disableEdit(); // 編集無効
                $actions->disableView(); // 詳細表示無効
            });
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Staff::findOrFail($id));



        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Staff());



        return $form;
    }
}
