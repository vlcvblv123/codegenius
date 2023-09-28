<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Course;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Order';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order());

        $grid->column('id', __('Id'));
        //match buyer id from the database
        $grid->column('user_token', __('Buyer'))->display(function($token){
            return User::where('token','=', $token)->value("name");
        });
        $grid->column('total_amount', __('Total amount'));
        //name is the column name in the Course table
        $grid->column('course_id', __('Course'))->display(function($id){
            return Course::where('id',"=", $id)-> value("name");
        });
        $grid->column('status', __('Status'))->display(function($status){
            return $status=="1"?"paid":"pending";
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->disableActions();// $grid->disableActions();
        $grid->disableCreateButton();
        // $grid->disableExport();
        // $grid->disableFilter();
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
        $show = new Show(Order::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_token', __('User token'));
        $show->field('total_amount', __('Total amount'));
        $show->field('course_id', __('Course id'));
        $show->field('status', __('Status'));
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
        $form = new Form(new Order());

        
        $form->text('user_token', __('User token'));
        $form->text('total_amount', __('Total amount'));
        $form->number('course_id', __('Course id'));
        $form->number('status', __('Status'));

        return $form;
    }
}
