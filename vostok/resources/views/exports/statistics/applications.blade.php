<table>
    <thead>
    <tr>
        <th>РП</th>
        <th>ЭУ</th>
        <th>Приоритет</th>
        <th>№ ОРД</th>
        <th>№ ПБ</th>
        <th>БС ID</th>
        <th>Вид работ</th>
        <th>Тип работ</th>
        <th>Ответственный РП</th>
        <th>Ответственный инженер</th>
        <th>Срок</th>
        <th>Проект</th>
        <th>Дата создания</th>
        <th>Статус</th>
    </tr>
    </thead>
    <tbody>
    @foreach($applications as $application)
        <tr>
            <td>{{ $application->division->title }}</td>
            <td>{{ $application->area->title }}</td>
            <td>{{ $application->priority }}</td>
            <td>{{ $application->document }}</td>
            <td>{{ $application->ticket }}</td>
            <td>{{ $application->stations->implode('bts_id', ', ') }}</td>
            <td>{{ $application->works->implode('title', ', ') }}</td>
            <td>{{ $application->type->title }}</td>
            <td>{{ $application->user->full_name }}</td>
            <td>{{ $application->engineer->full_name }}</td>
            <td>{{ $application->deadline_at->format('d.m.Y H:i:s') }}</td>
            <td>{{ $application->project->title }}</td>
            <td>{{ $application->created_at->format('d.m.Y H:i:s') }}</td>
            <td>{{ $application->status->title }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
