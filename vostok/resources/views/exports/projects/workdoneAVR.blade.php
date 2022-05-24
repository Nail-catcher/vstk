<table>
    <tbody>
        <tr>
            <td style="font-weight:700;">Обьект</td>
            <td>{{ $station->bts_id }}</td>
            <td></td>
            <td>Согласовано</td>
            <td>Руководитель РП/ЭУ</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight:700;">Тип</td>
            <td>
                {{ $station->prop_type }}
            </td>
            <td></td>
            <td>ФИО:</td>
            <td colspan="2">
                {{ $application->user->lastname }}
                {{ $application->user->firstname }}
            </td>
        </tr>
        <tr>
            <td style="font-weight:700;">Сер</td>
            <td></td>
            <td></td>
            <td colspan="2" style="text-align:center;">________________________________</td>
            <td></td>
        </tr>
        <tr>
            <td style="font-weight:700;">ПУФ</td>
            <td></td>
            <td></td>
            <td colspan="2" style="text-align:center;">Подпись</td>
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
            <td colspan="6" style="text-align:center;">Акт выполненных работ</td>
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
            <td colspan="6">Мы, нижеподписавшиеся:</td>
        </tr>
        @foreach ($application->users as $key => $user)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td colspan="5" style="text-align:center;">{{ $user->lastname }} {{ $user->firstname }}</td>
                <p></p>
            </tr>
        @endforeach
        <tr>
            <td>{{ count($application->users) + 1 }}</td>
            <td colspan="5" style="text-align:center;">
                {{ $application->user->lastname }}
                {{ $application->user->firstname }}
            </td>
            <p></p>
        </tr>
        <tr>
            <td>{{ count($application->users) + 2 }}</td>
            <td colspan="5" style="text-align:center;">
                {{ $application->engineer->lastname }}
                {{ $application->engineer->firstname }}
            </td>
            <p></p>
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
            <td colspan="6">составили настоящий акт о том, что на БС {{ $station->bts_id }}
                {{ $application->area->title }} р-на {{ $application->division->title  }} об-ти проведены следующие работы: </td>
        </tr>
        <tr>
            <td rowspan="2">№</td>
            <td colspan="2">Демонтаж оборудования</td>
            <td colspan="2">Установка оборудования</td>
            <td></td>
        </tr>
        <tr>
            <td>Наименование</td>
            <td>Серийный номер</td>
            <td>Наименование</td>
            <td>Серийный номер</td>
            <td></td>
        </tr>
        
        @foreach ($station->inventories as $key => $inventory)
            <tr>
               
                 
                <td>
                    {{ $key + 1 }}
                </td>
                <td>
                    {{ $inventory->title }}
                </td>
                <td>
                    {{ $inventory->serial_number }}
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
              </tr>    
        @endforeach
        @if ($startings && $station)
        @if ($startings->station_id ===$station->id)
        @foreach ($startings->progresses as $key => $progress)
        @foreach ($progress->inventories as $key => $inventory)
        <tr>
            <td>{{ $key + 1 }}
                </td>
                <td>
                </td>
                <td>
                </td>
              
                <td>
                    {{ $inventory->title }}
                </td>
                <td>
                    {{ $inventory->serial_number }}
                </td>
            </tr>    
        @endforeach
        @endforeach
        @endif
        @endif
        <tr>
            <td colspan="6">Данный Акт составлен и подписан:</td>
        </tr>
        <tr>
            <td>1</td>
            <td colspan="4" style="text-align:center;">____________________________________________________</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="4" style="text-align:center;">Должность ФИО</td>
            <td></td>
        </tr>
        <tr>
            <td>2</td>
            <td colspan="4" style="text-align:center;">____________________________________________________</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="4" style="text-align:center;">Должность ФИО</td>
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
