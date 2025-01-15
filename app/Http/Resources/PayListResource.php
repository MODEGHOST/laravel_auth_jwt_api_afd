<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PayListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'pay_list_id'=>$this->pay_list_id,
            'acc_id'=>$this->acc_id,
            'invoice_id'=>$this->invoice_id,
            'pay_vat'=>$this->pay_vat,
            'pay_type'=>$this->pay_type,
            'description'=>$this->description,
            'amount'=>$this->amount,
            'total'=>$this->total,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
        ];
    }
}
