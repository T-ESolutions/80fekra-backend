<?php

namespace App\Nova\Actions;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class PrintOrder extends Action
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
        $order = $models->first();
        // Generate or display the printable version of the order here
        $pdf = $this->generatePDF($order);
        $fileName = $order->id . '-order.pdf';
        // Save the PDF to a temporary file
        $pdf->save(storage_path('app/public/' . $fileName));
        // Delete the temporary file
        $filePath = url('storage/' . $fileName);

        return Action::download($filePath, $order->id . 'order.pdf');

    }


    protected function generatePDF(Order $order)
    {
        // Customize this method to generate the PDF using a library like Dompdf
        $pdf = \PDF::loadView('exports.order_pdf', compact('order'));

        return $pdf;
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
