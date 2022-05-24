<table>
	<tbody>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td  style="text-align:right;">ПРИЛОЖЕНИЕ № 3</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td  style="text-align:right;" colspan="3">к договору № ___ от  {{$today}}</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td colspan="3"  style="text-align:right;">на техническое обслуживание Антенно-мачтовых </td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td colspan="4"  style="text-align:right;">сооружений, антенно-фидерных устройств, радиорелейного </td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td colspan="3"  style="text-align:right;">оборудования ТОО «Мобайл Телеком-Сервис»</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="7"  style="text-align:center;">Отчет по аварийно-восстановительным работам</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>N
</td>
			<td rowspan="2">ID Site</td>
			<td rowspan="2">Регион</td>
			<td colspan="4">Номера поступивших ПБ </td>
		</tr>
		<tr>
			<td>п.п</td>
			<td>Отработанных с выездом</td>
			<td>Отработанных без выезда</td>
			<td>Из них сверхконтрольных в ЗО Исполнителя</td>
			<td>Сверхконтрольные ПБ, повлиявшие на невыполнение KPI по области </td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		@foreach ($stations as $key=>$station)
		<tr>
			<td>{{$key + 1}}</td>
			<td>{{$station->bts_id}}</td>
			<td>{{$station->area->title}}</td>
			@foreach ($station->applications as $key=>$application)
		
			<table>
				
			<tr>
			
			<td>
				@if($application->status->id == 7 && $application->ticket !== null)
				{{$application->ticket}}
				@else
				@endif
			</td>
			
			<td>
				@if($application->status->id == 8 && $application->ticket !== null)
				{{$application->ticket}}
				@else
				@endif
			</td>
			
			<td>
				
				@if($application->ticket !== null)
				{{$application->ticket}}
				@else

				@endif
				
			</td>
			
			<td>
				@if($application->ended_at > $application->deadline_at && $application->ticket !== null)
				{{$application->ticket}}
				@else

				@endif
			</td>
			
			
		</tr>
		
		</table>
		
			@endforeach
		</tr>
		@endforeach
		<tr>
			<td></td>
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
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="2">От Заказчика</td>
			<td></td>
			<td></td>
			<td></td>
			<td colspan="2">От Исполнителя</td>
		</tr>
		<tr>
			<td colspan="3">______________</td>
			<td>Р Абыханов</td>
			<td></td>
			<td>____________</td>
			<td>М Сауранбеков</td>
		</tr>
		<tr>
			<td>МП</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>МП</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
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
			<td></td>
		</tr>
		<tr>
			<td></td>
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
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
</table>