<table class="iksweb">
	<tbody>
		<tr>
			<td colspan="9">Акт установки оборудования</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="3">г.Алматы</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="3">{{$today}}</td>
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
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="6">Комиссия утвержденная приказом № 212-H от « 01 » ноября 2018г. в составе:</td>
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
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="9">Председатель комиссии:</td>
		</tr>
		<tr>
			<td colspan="9">     1. Заместитель Генерального директора – Технический директор Петровский А.В.</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="9">Члены комиссии:</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="6">     1. Директор департамента эксплуатации</td>
			<td></td>
			<td colspan="2">Франгов  В.А.</td>
		</tr>
		<tr>
			<td colspan="6">     2. Начальник отдела эксплуатации сетей</td>
			<td></td>
			<td colspan="2">Дорофеев В.В.</td>
		</tr>
		<tr>
			<td colspan="6">     3. Руководитель регионального подразделения </td>
			<td></td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="6">     4. Юрисконсульт </td>
			<td></td>
			<td colspan="2">Касымова Н.А.</td>
		</tr>
		<tr>
			<td colspan="6">     5. Заместитель главного бухгалтера </td>
			<td></td>
			<td colspan="2">Рысбекова Н.А.</td>
		</tr>
		<tr>
			<td colspan="6">     6. Начальник отдела безопасности </td>
			<td></td>
			<td colspan="2">Есдаулетов А.Д.</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="9">Подтверждает установку на БС {{$station->bts_id}}  установленного по адресу: {{$station->region->title}} р-н {{$station->city->title}} обл.  следующего оборудования:</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>№</td>
			<td>Наименование оборудования</td>
			<td>Номенклатурный номер</td>
			<td>ПУФ</td>
			<td>Кол-во</td>
			<td>Дата </td>
			<td>Примечание</td>
			<td></td>
			<td></td>
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

            @foreach ($progressItem->inventories as $inventoryIndex => $inventoryItem)
            <tr>

			<td>{{ $inventoryIndex + 1 }}</td>
			<td>{{ $inventoryItem->title }}</td>
			<td>{{ $inventoryItem->manufacturer_code }}</td>
			<td></td>
			<td>1</td>
			<td>{{ $progressItem->created_at }}</td>
			<td>{{$progressItem->comment}}</td>
			<td></td>
			<td></td>
		</tr>
              @endforeach  
            @endforeach

        @endforeach
		
		
		
		
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="9">В целом оборудование отвечает техническим нормам, требованиям и введено в эксплуатацию.</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
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
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="9">Председатель комиссии:</td>
		</tr>
		<tr>
			<td colspan="6">1. Заместитель Генерального директора  Технический директор</td>
			<td>_____________</td>
			<td colspan="2">Петровский А.В.</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="9">Члены комиссии:</td>
		</tr>
		<tr>
			<td colspan="6">     1. Директор департамента эксплуатации</td>
			<td>____________</td>
			<td colspan="2">Франгов  В.А.</td>
		</tr>
		<tr>
			<td colspan="6">     2. Начальник отдела эксплуатации сетей</td>
			<td>____________</td>
			<td colspan="2">Дорофеев В.В.</td>
		</tr>
		<tr>
			<td colspan="6">     3. Руководитель регионального подразделения </td>
			<td>____________</td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="6">     4. Юрисконсульт </td>
			<td>____________</td>
			<td colspan="2">Касымова Н.А.</td>
		</tr>
		<tr>
			<td colspan="6">     5. Заместитель главного бухгалтера </td>
			<td>____________</td>
			<td colspan="2">Рысбекова Н.А.</td>
		</tr>
		<tr>
			<td colspan="6">     6. Начальник отдела безопасности </td>
			<td>____________</td>
			<td colspan="2">Есдаулетов А.Д.</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
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
			<td></td>
			<td></td>
		</tr>
	</tbody>
</table>