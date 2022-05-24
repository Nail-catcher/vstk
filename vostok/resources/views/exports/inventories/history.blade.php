<table>
    <tr>
        <td>Материальная ведомость за "{{ $start->format('d.m.Y') }} - {{ $end->format('d.m.Y') }}"</td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <thead>
    <tr>
        <th rowspan="2" bgcolor="#fdfecc">
            № п/п
        </th>
        <th rowspan="2" bgcolor="#fdfecc">
            Склад/МОЛ
        </th>
        <th rowspan="2" bgcolor="#fdfecc">
            Номенклатура/наименование ТМЗ/ОС
        </th>
        <th rowspan="2" bgcolor="#fdfecc">
            Код/серийный номер/инвентарный номер
        </th>
        <th rowspan="2" bgcolor="#fdfecc">
            Ед.изм.
        </th>
        <th bgcolor="#fdfecc">
            Начальный остаток
        </th>
        <th bgcolor="#fdfecc">
            Приход
        </th>
        <th bgcolor="#fdfecc">
            Итого расход
        </th>
        <th bgcolor="#fdfecc">
            Конечный остаток
        </th>
    </tr>
    <tr>
        <th bgcolor="#fdfecc">количество</th>
        <th bgcolor="#fdfecc">количество</th>
        <th bgcolor="#fdfecc">количество</th>
        <th bgcolor="#fdfecc">количество</th>
    </tr>
    </thead>
    <tbody>
    @foreach($history as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->user->lastname }} {{ $item->user->firstname }}</td>
            <td>{{ $item->inventory->title }}</td>
            <td>{{ $item->inventory->serial_number }}</td>
            <td>шт</td>
            <td>0</td>
            <td>1</td>
            <td>
                @if($item->installed_at === null)
                    0
                @else
                    1
                @endif
            </td>
            <td>
                @if($item->installed_at !== null)
                    0
                @else
                    1
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td bgcolor="#fdfecc">
            Итого
        </td>
        <td bgcolor="#fdfecc"></td>
        <td bgcolor="#fdfecc"></td>
        <td bgcolor="#fdfecc"></td>
        <td bgcolor="#fdfecc"></td>
        <td bgcolor="#fdfecc">0</td>
        <td bgcolor="#fdfecc">
            {{ $history->count() }}
        </td>
        <td bgcolor="#fdfecc">
            {{ $history->where('installed_at', '!=', null)->count() }}
        </td>
        <td bgcolor="#fdfecc">
            {{ $history->where('installed_at', '=', null)->count() }}
        </td>
    </tr>
    </tfoot>
</table>
