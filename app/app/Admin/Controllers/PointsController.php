<?php

namespace App\Admin\Controllers;

use Log;
use App\Models\Points;
use App\Models\PointLogs;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Content;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Validation\Rule;
use Encore\Admin\Widgets\Box;
use Carbon\Carbon;

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

        $url = app('request')->getRequestUri();
        $url = parse_url($url, PHP_URL_QUERY);
        if(!is_null($url) and $url != '_pjax=%23pjax-container'){
            var_dump($url);
            parse_str($url, $q);
            $grid->model()->getFilter($q);
        }

        $grid->disableExport();

        $grid->column('id', __('ID'));
        $grid->column('created_at', __('申請日時'))->date('Y-m-d H:i:s');
        $grid->column('updated_at', __('更新日時'))->date('Y-m-d H:i:s');
        $grid->column('categories', __('CATEGORIES'))->display(function () {

            if($this->categories == 'deposit'){
                $r = '入金';
            }
            if($this->categories == 'withdrawal'){
                $r = '出金';
            }
            return $r;
        });
        $grid->column('status', __('STATUS'))->display(function () {

            if($this->status == 'untreated'){
                $r = '申請中';
            }
            if($this->status == 'processed'){
                $r = '手続き完了';
            }
            return $r;
        });;
        $grid->column('point', __('POINT'));

        // ポイントの合計最新行を取得
        $grid->tools(function ($tools) {
            $points_untreated = PointLogs::getTotal();
            $sum_points = Points::getTotal();
            $tools->append('<div style="margin-top:30px;">保有ポイント:'.$sum_points.'</div>'.'<div class="untreatedpoint">申請中のポイント:'.$points_untreated.'</div>');
        });

        // filter
        $grid->filter(function ($filter) {
            $filter->column(1/2, function ($filter){

                $filter->disableIdFilter();
                $filter->like('id', 'ID');
                $filter->between('created_at', '登録日時')->date('Y-m-d H:i:s');
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

        // 入金/出金処理用
        $form = new Form(new PointLogs());
        $form->hidden('user_id','USERID')->value($user_id);
        $form->number('point', __('POINT'));
        $form->radio('categories')->options(['deposit' => '入金', 'withdrawal'=> '出金'])->default('deposit');
        $form->hidden('status', 'status')->value('untreated');

        return $form;
    }
}
