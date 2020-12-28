<?php

namespace App\Admin\Controllers;

use Log;
use App\Http\Controllers\Controller;
use App\Models\News;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Table;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return Admin::content(function (Content $content){

            $news = News::getLatest();

            $items = [];
            foreach ($news as $v) {
                $items[] = [
                    'id' => $v['id'],
                    'categories' => $v['categories'],
                    'title' => $v['title'],
                    'body' => $v['body'],
                ];
            }

            $content->title('Dashboard');
            $content->description('');
            $content->row(function (Row $row) use($items){
                    $row->column(12, function (Column $column) use($items) {

                        if (empty($items)) {
                            $items = 'ニュースがありません';
                            $box = new Box('お知らせ',$items);
                        }else{
                            $table = new Table(['ID','カテゴリ','タイトル','内容'],$items);
                            $box = new Box('お知らせ',$table->render());
                        }

                        $box->collapsable();
                        $box->style('info');
                        $box->solid();
                        $column->append($box);
                    });
                    // $row->column(4, function (Column $column) {
                    //     $column->append(Dashboard::environment());
                    // });

                    // $row->column(4, function (Column $column) {
                    //     $column->append(Dashboard::extensions());
                    // });

                    // $row->column(4, function (Column $column) {
                    //     $column->append(Dashboard::dependencies());
                    // });
            });
        });
    }
}
