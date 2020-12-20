<?php

namespace App\Admin\Controllers;

use App\Models\Points;
use App\Models\PointLogs;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PointsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Points';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PointLogs());
        $grid->disableActions();
        $grid->disableColumnSelector();
        $grid->disableExport();

        $grid->column('created_at', __('申請日時'))->date('Y-m-d G:i:s');
        $grid->column('updated_at', __('更新日時'))->date('Y-m-d G:i:s');
        $grid->column('categories', __('CATEGORIES'))->display(function () {

            $r = '入金';
            if($this->categories == 'widthdrawal'){
                $r = '出金';
            }
            return $r;
        });
        $grid->column('status', __('STATUS'))->display(function () {

            $r = '申請中';
            if($this->categories == 'processed'){
                $r = '手続き完了';
            }
            return $r;
        });;
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

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('point', __('Point'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

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
        $form->hidden('status', 'status')->value('untreated');

        return $form;
    }
}
