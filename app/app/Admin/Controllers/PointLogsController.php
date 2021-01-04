<?php

namespace App\Admin\Controllers;

use App\Models\Points;
use App\Models\PointLogs;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

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

        $url = app('request')->getRequestUri();
        $url = parse_url($url, PHP_URL_QUERY);
        if(!is_null($url) and $url != '_pjax=%23pjax-container'){
            var_dump($url);
            parse_str($url, $q);
            $grid->model()->getFilter($q);
        }

        $grid->disableExport();

        $grid->column('id', __('ID'));
        $grid->column('user_id', __('USERID'));
        $grid->column('point', __('POINT'));
        $grid->column('created_at', __('CREATED'))->date('Y-m-d H:i:s');
        $grid->column('updated_at', __('UPDATED'))->date('Y-m-d H:i:s');
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
                $r = '未処理';
            }
            if($this->status == 'processed'){
                $r = '処理済';
            }
            return $r;
        });;

        // filter
        $grid->filter(function ($filter) {
            $filter->column(1/2, function ($filter){

                $filter->disableIdFilter();
                $filter->like('id', 'ID');
                $filter->between('created_at', '時間範囲')->date('Y-m-d H:i:s');
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
        $form->radio('categories')->options(['deposit' => '入金', 'withdrawal'=> '出勤'])->default('deposit');
        $form->radio('status')->options(['untreated' => '未処理', 'processed'=> '処理済'])->default('deposit');

        $form->saving(function (Form $form) {

            $points = Points::GetFirst();

            $formpoint = is_null($form->point) ? 0 : (int) $form->point;

            $now = Carbon::now();

            // ¥Ý¥¤¥ó¥ÈºÏÓ‹‚Ž
            if( $form->categories == 'deposit' ){

                $sumpoints = $points + $formpoint;

            }elseif($form->categories == 'withdrawal'){

                $sumpoints = $points - $formpoint;

            }else{
                $sumpoints = 0;
            }

            if($form->status == 'processed'){

                // insert
                Points::create([
                    'user_id' => $form->user_id,
                    'point' => $sumpoints,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);

            }

        });

        return $form;
    }
}
