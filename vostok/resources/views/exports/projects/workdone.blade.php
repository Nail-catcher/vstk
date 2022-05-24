<table>
    <tbody>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="6">Акт выполненных планово - профилактических работ на БС {{ $station->base_station_type }}
                область {{ $station->area->title }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="6">
                {{ $application->started_at }} на БС {{ $station->bts_id }} при выполнении ППР было выполнено
                следующее:
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>№</td>
            <td>Наименование</td>
            <td>Датчик\Группа</td>
            <td>Норма</td>
            <td>Отклонение</td>
            <td>Примечание</td>
        </tr>
        @foreach ($startings as $startingIndex => $starting)
            @if ($startingIndex > 0)
                <tr>
                    <td></td>
                    <td>Доработка</td>
                    <td></td>
                </tr>
            @endif
            @foreach ($starting->progresses as $progressIndex => $progressItem)
                <tr>
                    <td>
                        {{ $progressIndex + 1 }}
                    </td>
                    <td>
                        {{ $progressItem->progress->title }}
                        
                    </td>
                    @if ($progressItem->typeable !== null)
                    @if ($progressItem->typeable->modelable !== null)
                    <td> {{ $progressItem->typeable->modelable->title}}</td>
                    @else
                    <td></td>
                    @endif
                        <td>
                            {{ $progressItem->typeable->value }}
                        </td>
                        <td>
                            {{ $progressItem->typeable->deviation }}
                        </td>
                    @else
                    <td></td>
                        <td></td>
                        <td></td>
                    @endif
                    <td>
                        {{ $progressItem->comment }}
                    </td>
                </tr>
            @endforeach

        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="6">Работы провели:</td>
        </tr>
        @foreach ($application->users as $user)
            <tr>
                <td></td>
                <td>Инженер</td>
                <td></td>
                <td colspan="3">
                    {{ $user->lastname }}
                    {{ $user->firstname }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td>Ответственный Инженер</td>
            <td></td>
            <td colspan="3">
                {{ $application->engineer->lastname }}
                {{ $application->engineer->firstname }}
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>
