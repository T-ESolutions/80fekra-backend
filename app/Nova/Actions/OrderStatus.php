<?php

namespace App\Nova\Actions;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;

class OrderStatus extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $model->update(['status' => $fields->status]);
        }

        return Action::message('تم تغيير حالة الطلب. (' . $models->count() . ')');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make('حالة الطلب', 'status')
                ->options([
                    Order::STATUS_PENDING => 'طلب جديد',
                    Order::STATUS_ON_PROGRESS => 'جاري التجهيز',
                    Order::STATUS_SHIPPED => 'تم الشحن',
                    Order::STATUS_DELIVERED => 'تم التوصيل',
                    Order::STATUS_REJECTED => 'مرفوض',
                    Order::STATUS_CANCELLED_BY_USER => 'تم الالغاء عن طريق المستخدم',
                    Order::STATUS_CANCELLED_BY_ADMIN => 'تم الالغاء عن طريق الادمن'
                ])
                ->displayUsingLabels()
                ->rules('required'),
        ];
    }

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name()
    {
        return "تغيير الحاله ";
    }
}
