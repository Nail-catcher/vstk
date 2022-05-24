
<table>
    <thead>
    <tr>
        <th>Регион (РП)</th>
        <th>Город присутствия</th>
        <th>Наименование должности</th>
        <th>Ф.И.О. сотрудника</th>
        <th>СЭД</th>
        @foreach($period as $date)
            @if (date('N', strtotime($date)) <= 5)
            <th>{{ $date->format("d") }}</th>

            @endif
        @endforeach
        <th>CDMA 450</th>
        <th>% CDMA</th>
        <th>МТС</th>
        <th>% MTC</th>
        <th>Отпуск/Больничный (кол.дней)</th>
        <th>Обучение</th>
        <th>Рабочих дней в 
            @php
            $arr = [
              'январе',
              'феврале',
              'марте',
              'апреле',
              'мае',
              'июне',
              'июле',
              'августе',
              'сентябре',
              'октябре',
              'ноябре',
              'декабре'
            ];
$month = $date->format('n')-1;
            echo $arr[$month]; 
@endphp
        </th>
        <th>Итого</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        @php
            $mts = $user->applications->where('type_id', 1)->count();
            $mtsForEngineers = $user->applicationsForEngineers->where('type_id', 1)->count();
            $cdmaForEngineers = $user->applicationsForEngineers->where('type_id', 2)->count();
            $cdma = $user->applications->where('type_id', 2)->count();
            $appForEngineers = $user->applicationsForEngineers->count();
            $applications_count = $user->applications->count();
            $working_days = 0;
            $vacation_days = 0;
             $all_working_days = 0;
        @endphp
        <tr>
            <td>{{ $user->division->title }}</td>
            <td>{{ $user->division->title }}</td>
            <td>{{ $user->position->title }}</td>
            <td>{{ $user->full_name }}</td>
            <td>{{ $user->lastname_with_initials }}</td>
            @foreach($period as $date)
                @php
                    if (date('N', strtotime($date)) <= 5){
                   $working_days++;
}
                $all_working_days++;
                @endphp
                @if (date('N', strtotime($date)) <= 5)
                <th>
                    {{ $user->applications->whereBetween('ended_at', [$date->startOfDay()->format('Y-m-d H:i:s'),
                   $date->endOfDay()->format('Y-m-d H:i:s')])->count() +
                   $user->applicationsForEngineers->whereBetween('ended_at', [$date->startOfDay()->format('Y-m-d H:i:s'),
                   $date->endOfDay()->format('Y-m-d H:i:s')])->count() }}
                </th>
                @endif
            @endforeach
            
            <td>{{ $working_days }}</td>
            <td>
                @if($cdma !== 0)
                    {{ round((($working_days-$mts - $mtsForEngineers)/$working_days) * 100, 2) }}%
                @else
                    0.00%
                @endif
            </td>
            <td>{{ $mts }}</td>
            <td>
                @if($mts !== 0)
                    {{ round((($mts + $mtsForEngineers)/$working_days) * 100, 2) }}%
                @else
                    0.00%
                @endif
            </td>
            <td>
                @php
                    $vacation = $user->vacations->whereIn('status_id', [3,4])->sum(function ($vacation) {
                       return $vacation->ended_at->diffInDays($vacation->started_at);
                   });
                    $vacation_days += $vacation;
                @endphp
                {{ $vacation }}
            </td>
            <td>
                @php
                    $vacation = $user->vacations->where('status_id', 6)->sum(function ($vacation) {
                       return $vacation->ended_at->diffInDays($vacation->started_at);
                   });
                    $vacation_days += $vacation;
                @endphp
                {{ $vacation }}
            </td>
            <td>{{ $working_days }}</td>
            <td>

                {{ $applications_count + $appForEngineers }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
