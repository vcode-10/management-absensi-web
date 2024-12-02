<table>
    <thead>
        <tr>
            <th>Nama</th>
            @for ($day = 1; $day <= 31; $day++)
                <th>{{ $day }}</th>
            @endfor
        </tr>
    </thead>
    <tbody>
        @foreach ($attendances as $attendance)
            <tr>
                <td>{{ $attendance['name'] }}</td>
                @for ($day = 1; $day <= 31; $day++)
                    <td>{{ getAttendanceStatus($attendance, $day) }}</td>
                @endfor
            </tr>
        @endforeach
    </tbody>
</table>
