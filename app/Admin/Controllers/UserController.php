<?php

namespace App\Admin\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Table;

class UserController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('用户列表')
            ->description('用户列表')
            ->body($this->grid());
    }

    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    protected function grid()
    {
        $grid = new Grid(new User);

//        $grid->header(function ($query) {
//            $sex = $query->select(\DB::raw('count(sex) as count, sex'))
//                ->groupBy('sex')->get()->pluck('count', 'sex')->toArray();
//
//            $doughnut = view('admin.chart.gender', compact('sex'));
//
//            return new Box('Sex Ratio', $doughnut);
//        });

        $grid->id('Id')->sortable();    // 第一列显示id字段，并将这一列设置为可排序列
        $grid->name('Name')->display(function ($name) {
            return "<span style='color:green;'>$name</span>";
        })->expand(function ($model) {
            $posts = $model->posts()->take(10)->get()->map(function ($post) {
                return $post->only(['id', 'title', 'content', 'created_at']);
            });

            return new Table(['ID', 'Title', 'Content', 'Created At'], $posts->toArray());
        });

        $grid->sex('Sex')->using(['0' => '女', '1' => '男'])->modal('Comments', function ($model) {
            $comments = $model->comments()->take(10)->get()->map(function ($comment) {
                return $comment->only(['id', 'content', 'created_at']);
            });

            return new Table(['ID', 'Content', 'Created At'], $comments->toArray());
        });

        $grid->email('Email')->editable();
        // $grid->avatar('Avatar')->image();
        $grid->avatar('Avatar')->display(function ($avatar) {
            return "<img src='$avatar' style='width: 25px;'>";
        });
        $grid->email_verified_at('Email verified at')->label();
        $grid->password('Password');
        $grid->remember_token('Remember token');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

        // filter($callback)方法用来设置表格的简单搜索框
        $grid->filter(function ($filter) {
            $filter->like('name', 'Name');
            $filter->equal('sex')->select(['0' => '女', '1' => '男']);
            // 设置created_at字段的范围查询
            $filter->between('created_at', 'Created Time')->datetime();
        });

        // 添加不存在的字段
        $grid->column('column_not_in_table')->display(function () {
            return 'blablabla....';
        });

        $grid->model()->orderBy('id', 'desc');

        $grid->paginate(15);

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->sex('Sex')->using(['0' => '女', '1' => '男']);
        $show->email('Email');
        $show->email_verified_at('Email verified at');
        $show->password('Password');
        $show->remember_token('Remember token');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);

        $form->text('name', 'Name')->rules('required|min:10');
        $form->select('sex', 'Sex')->options([0 => 'female', 1 => 'male']);
        $form->multipleSelect('hobby', 'Hobby')->options([1 => 'foo', 2 => 'bar', 'val' => 'Option name']);
        $form->listbox('color', 'Color')->options([1 => 'foo', 2 => 'bar', 'val' => 'Option name']);
        $form->color('yellow', 'Yellow')->default('#ccc');

        $form->email('email', 'Email');
        $form->image('avatar', 'Avatar')->uniqueName();
        $form->datetime('email_verified_at', 'Email verified at')->default(date('Y-m-d H:i:s'));
        $form->password('password', 'Password');
        $form->text('remember_token', 'Remember token');

        return $form;
    }
}
