<?php

namespace App\Admin\Controllers;

use App\Models\PointLogs;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PointLogsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'PointLogs';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PointLogs());

        $grid->column('created_at', __('申請日時'))->date('Y-m-d G:i:s');
        $grid->column('updated_at', __('更新日時'))->date('Y-m-d G:i:s');
        $grid->column('categories', __('CATEGORIES'));
        $grid->column('status', __('STATUS'));
        $grid->column('id', __('ID'));
        $grid->column('user_id', __('USERID'));
        $grid->column('point', __('POINT'));

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
        $show = new Show(PointLogs::findOrFail($id));

        $show->field('created_at', __('CREATED'));
        $show->field('updated_at', __('UPDATED'));
        $show->field('categories', __('CATEGORIES'));
        $show->field('status', __('STATUS'));
        $show->field('id', __('ID'));
        $show->field('user_id', __('USERID'));
        $show->field('point', __('POINT'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {

        $user_id=Admin::user()->id;

        $form = new Form(new PointLogs());
        $form->hidden('user_id','USERID')->value($user_id);
        $form->number('point', __('POINT'));
        $form->radio('categories')->options(['deposit' => '入金', 'withdrawal'=> '出金'])->default('deposit');

        return $form;
    }
}