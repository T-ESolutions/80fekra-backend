<?php

namespace App\Nova\Actions;

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

        return Action::message('Status Changed. (' . $models->count() . ')');
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
                    'pending' => 'طلب جديد',
                    'on_progress' => 'جاري التجهيز',
                    'shipped' => 'تم الشحن',
                    'delivered' => 'تم التوصيل',
                    'rejected' => 'مرفوض',
                    'canceled_by_user' => 'تم الالغاء عن طريق المستخدم',
                    'canceled_by_admin' => 'تم الالغاء عن طريق الادمن'
                ])
                ->displayUsingLabels(),
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
