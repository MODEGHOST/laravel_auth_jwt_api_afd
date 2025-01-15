<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PettyCashResource extends JsonResource
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
            'petty_cash_id'=>$this->petty_cash_id,
            'emp_id'=>$this->emp_id,
            'pay_to'=>$this->pay_to,
            'status'=>$this->status,
            'section'=>$this->section,
            'division'=>$this->division,
            'dept'=>$this->dept,
            'company'=>$this->company,
            'req_by'=>$this->req_by,
            'files'=>$this->files,
            'credit_type'=>$this->credit_type,
            'cost_center'=>$this->cost_center,
            'project'=>$this->project,
            'product'=>$this->product,
            'boi'=>$this->boi,
            'intercompany'=>$this->intercompany,
            'reserve'=>$this->reserve,
            'payed_at'=>$this->payed_at,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'pay_list'=>PayListResource::collection($this->paylist),
        ];
    }
}
