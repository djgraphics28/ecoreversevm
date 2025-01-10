<x-mail::message>
# Hello Admin,

**{{ $data['student_name'] }}** has inserted a **{{ $data['object'] }}** object and has earned **{{ $data['points'] }} points**.

## Total Points: {{ $data['total_points'] }}

### Inserted Object Histories:
| Date & Time          | Object Inserted    | Points Earned |
|----------------------|--------------------|---------------|
@foreach($data['histories'] as $history)
| {{ $history['created_at'] }} | {{ $history['object_inserted'] }} | {{ $history['points'] }} |
@endforeach

<x-mail::button :url="''">
View More Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
