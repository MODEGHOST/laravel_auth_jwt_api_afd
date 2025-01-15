@component('mail::message')
# {{ $mailData['title'] }}

วันที่ทำ OT  :  {{ $mailData['date']}} <br/>
หมายเลข OT  :  {{ $mailData['ot_id']}} <br/>
หน่วยงาน  :   {{ $mailData['dept']}} <br/>
สถานะ  :     {{ $mailData['status']}} <br/>
  
@component('mail::button', ['url' => $mailData['url']])
คลิกเข้าสู่ระบบ
@endcomponent
  
Best Regards,

OT-Team
<!-- {{ config('app.name') }} -->
@endcomponent
