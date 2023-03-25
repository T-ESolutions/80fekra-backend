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

class OrderPaymentStatus extends Action
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
            $model->update(['payment_status' => $fields->payment_status]);
        }

        return Action::message('تم تغيير حالة الدفع. (' . $models->count() . ')');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make('حالة الدفع', 'payment_status')
                ->options([
                    Order::PAYMENT_STATUS_PAID => 'مدفوع',
                    Order::PAYMENT_STATUS_NOT_PAID => 'لم يتم الدفع'
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
        return "تغيير حالة الدفع ";
    }
}
