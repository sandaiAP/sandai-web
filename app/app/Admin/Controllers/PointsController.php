<?php

namespace App\Admin\Controllers;

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

    public function index(Content $content)
    {

        $html = "<h3>"."ポイント合計"."</h3>";

        return $content
            ->header('ポイント')
            ->description($html)
            ->body($this->grid());
    }

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

        $grid->column('id', __('ID'));
        $grid->column('created_at', __('申請日時'))->date('Y-m-d G:i:s');
        $grid->column('updated_at', __('更新日時'))->date('Y-m-d G:i:s');
        $grid->column('categories', __('CATEGORIES'))->display(function () {

            $r = '入金';
            if($this->categories == 'withdrawal'){
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

        // 入金/出金処理用
        $form = new Form(new PointLogs());
        $form->hidden('user_id','USERID')->value($user_id);
        $form->number('point', __('POINT'));
        $form->radio('categories')->options(['deposit' => '入金', 'withdrawal'=> '出金'])->default('deposit');
        $form->hidden('status', 'status')->value('untreated');

        $form->saving(function (Form $form) {

            $points = Points::where('user_id',$form->user_id)->first();

            ### データのnull問題対応ー＞完了
            $cpoint = is_null($points) ? 0 : $points->point;
            $formpoint = is_null($form->point) ? 0 : (int) $form->point;
            $now = Carbon::now();

            // ポイント合計値
            if( $form->categories == 'deposit' ){

                $sumpoints = $cpoint + $formpoint;

            }elseif($form->categories == 'withdrawal'){

                $sumpoints = $cpoint - $formpoint;

            }else{
                $sumpoints = 0;
            }

            // insert
            Points::create([
                'user_id' => $form->user_id,
                'point' => $sumpoints,
                'created_at' => $now,
                'updated_at' => $now
            ]);

        });

        return $form;
    }
}
